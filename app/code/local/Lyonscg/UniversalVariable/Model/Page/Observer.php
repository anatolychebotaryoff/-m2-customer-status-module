<?php
/**
 * Rewrite QuBit_UniversalVariable_Model_Page_Observer to work with full page cache for Magento EE
 *
 * @category   Lyons
 * @package    us_waterfilters
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_UniversalVariable_Model_Page_Observer extends QuBit_UniversalVariable_Model_Page_Observer
{
    // Current Full Action Name
    protected $_fullActionName = '';

    /**
     * Class variable for when no category exists
     * @var string
     */
    protected $_noCategory = 'No category';

    /**
     * Return current full action name
     *
     * @return string
     */
    protected function getFullActionName() {
        if (!$this->_fullActionName) {
            $this->_fullActionName = Mage::app()->getFrontController()->getAction()->getFullActionName();
        }
        return $this->_fullActionName;
    }

    /**
     * Rewrite to send current_product_id if page is a product page
     *
     * @param $observer
     * @return $this
     */
    public function setUniversalVariable($observer) {
        $this->_setUser();

        if ($this->_isCategory()) {
            $this->_setCategory($observer->getEvent()->getCurrentCategoryId());
        }

        $this->_setPage();

        if ($this->_isProduct()) {
            $this->_setProduct($observer->getEvent()->getCurrentProductId());
        }

        if ($this->_isCategory() || $this->_isSearch()) {
            $this->_setListing();
        }

        if (!$this->_isConfirmation()) {
            $this->_setBasket();
        }

        if ($this->_isConfirmation()) {
            $this->_setTranscation();
        }

        return $this;
    }

    /**
     * Rewrite _isProduct function to work with full page cache
     *
     * @return bool
     */
    public function _isProduct() {
        $onCatalog = false;
        if(Mage::registry('current_product')) {
            $onCatalog = true;
        } elseif ($this->getFullActionName() == 'catalog_product_view') {
            $onCatalog = true;
        }
        return $onCatalog;
    }

    /**
     * Rewrite to work with full page cache
     *
     * @return bool
     */
    public function _isHome() {
        if (Mage::app()->getRequest()->getRequestString() == "/") {
            return true;
        } elseif ($this->getFullActionName() == 'cms_index_index') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Rewrite to work with full page cache
     *
     * @return bool
     */
    public function _isCategory() {
        if ($this->_getControllerName() == 'category') {
            return true;
        } elseif ($this->getFullActionName() == 'catalog_category_view') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Rewrite to work with full page cache
     *
     * @return Mage_Catalog_Model_Category|mixed
     */
    protected function _getCurrentCategory() {
        if ($currentCategory = Mage::registry('current_category')) {
            return $currentCategory;
        }

        return Mage::getSingleton('catalog/layer')->getCurrentCategory();
    }

    /**
     * Rewrite to allow id of product to load in parameter
     *
     * @param null $id
     * @return bool
     */
    public function _setProduct($id = null) {
        $product  = $this->_getCurrentProduct($id);
        if (!$product) return false;
        $this->_product = $this->_getProductModel($product);
    }

    /**
     * Set current category if id is passed in
     *
     * @param int|null $id
     * @return bool
     */
    protected function _setCategory($id = null) {
        $category = Mage::getModel('catalog/category')->load($id);
        if (!$category->getId()) return false;
        Mage::register('current_category', $category, true);
    }

    /**
     * Rewrite to allow product to be loaded by passed id parameter
     *
     * @param $id
     * @return Mage_Core_Model_Abstract|mixed
     */
    protected function _getCurrentProduct($id = null) {
        if ($currentProduct = Mage::registry('current_product')) {
            return $currentProduct;
        }

        if (!empty($id)) {
            return Mage::getSingleton('catalog/product')->load($id);
        }

        return false;
    }

    /**
     * Override for outputting a string instead of false if no category exists
     *
     * @param $product
     * @return array|bool|string
     */
    public function _getProductCategories($product) {
        $cats = $product->getCategoryIds();
        if ($cats) {
            $category_names = array();
            foreach ($cats as $category_id) {
                $_cat = $this->_getCategory($category_id);
                $category_names[] = $_cat->getName();
            }
            return $category_names;
        } else {
            return array($this->_noCategory);
        }
    }

    /*
 * Set the model attributes to be passed front end
 */

    public function _getPageType() {
        if ($this->_isHome()) {
            return 'home';
        } elseif ($this->_isContent()) {
            return 'content';
        } elseif ($this->_isCategory()) {
            if ($currentCategory = $this->_getCurrentCategory()) {
                return $currentCategory->getName();
            }
            return 'category';
        } elseif ($this->_isSearch()) {
            return 'search';
        } elseif ($this->_isProduct()) {
            return 'product';
        } elseif ($this->_isBasket()) {
            return 'basket';
        } elseif ($this->_isCheckout()) {
            return 'checkout';
        } elseif ($this->_isConfirmation()) {
            return 'confirmation';
        } else {
            return $this->_getModuleName();
        }
    }

    /**
     * Rewrite to not load product for checkout performance, if product is in quote then it should be ok for store
     *
     * @param $items
     * @param $page_type
     * @return array
     */
    public function _getLineItems($items, $page_type) {
        $line_items = array();
        foreach($items as $item) {
            /** If product is in quote then it should be visible and not needed to be loaded again **/
            $litem_model             = array();
            $litem_model['product']  = $this->_getProductModel($item->getProduct());


            $litem_model['subtotal'] = (float) $item->getRowTotalInclTax();
            $litem_model['total_discount'] = (float) $item->getDiscountAmount();

            if ($page_type == 'basket') {
                $litem_model['quantity'] = (float) $item->getQty();
            } else {
                $litem_model['quantity'] = (float) $item->getQtyOrdered();
            }

	    $litem_model['product']['unit_sale_price'] = $item->getPrice();

	    //revert change by Qubit at request of business analytics
            // Recalculate unit_sale_price after voucher applied Github: #35
            // https://github.com/QubitProducts/UniversalVariable-Magento-Extension/issues/35
           // $unit_sale_price_after_discount = $litem_model['product']['unit_sale_price'];
           // $unit_sale_price_after_discount =
             //   $unit_sale_price_after_discount - ($litem_model['total_discount'] / $litem_model['quantity']);
           // $litem_model['product']['unit_sale_price'] = $unit_sale_price_after_discount;

            array_push($line_items, $litem_model);
        }
        return $line_items;
    }

    /**
     * Rewrite for getting stock item from passed in product instead of loading product stock again
     *
     * @param $product
     * @return array
     */
    public function _getProductModel($product) {
        $product_model = array();
        $product_model['id']       = $product->getId();
        $product_model['sku_code'] = $product->getSku();
        $product_model['url']      = $product->getProductUrl();
        $product_model['name']     = $product->getName();
        $product_model['unit_price']      = (float) $product->getPrice();
        $product_model['unit_sale_price'] = (float) $product->getFinalPrice();
        $product_model['currency']        = $this->_getCurrency();
        $product_model['description']     = strip_tags($product->getShortDescription());

        if ($product->getStockItem()) {
            $product_model['stock'] = (int) $product->getStockItem()->getQty();
        } else {
            $product_model['stock'] = 0;
        }


        $categories = $this->_getProductCategories($product);
        if (isset($categories[0])) {
            $product_model['category'] = $categories[0];
        }
        if (isset($categories[1])) {
            $product_model['subcategory'] = $categories[1];
        }

        return $product_model;
    }
}
