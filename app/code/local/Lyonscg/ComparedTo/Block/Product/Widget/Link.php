<?php
/**
 * Product Compare Widget Link Class
 *
 * @category  Lyons
 * @package   Lyonscg_ComparedTo
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */

/**
 * Widget to display link to the product
 */

class Lyonscg_ComparedTo_Block_Product_Widget_Link
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $head = Mage::app()->getLayout()->getBlock('head');
        $head->addJs('varien/product.js');
        $head->addItem('skin_js', 'js/bundle.js');
        $head->addJs('js/itoris/groupedproductconfiguration/groupedproduct.js');
        return $this;
    }

    /**
     * Before rendering html, but after trying to load cache
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        // Get First Product to compare
        $product1 = $this->getCorrectId($this->getData('product1'), 'product');
        $this->setData('product1', $product1);

        // Get Second Product to compare
        $product2 = $this->getCorrectId($this->getData('product2'), 'product');
        $this->setData('product2', $product2);

        // Load Products
        $firstProduct = Mage::getModel('catalog/product')->load($product1);
        $secondProduct = Mage::getModel('catalog/product')->load($product2);

        if ($firstProduct && $secondProduct) {
            $this->setAttributes(explode(',', $this->getAttributes()));

            // Load Review Summaries onto Products
            Mage::getModel('review/review')->getEntitySummary($firstProduct, Mage::app()->getStore()->getId());
            Mage::getModel('review/review')->getEntitySummary($secondProduct, Mage::app()->getStore()->getId());

            // Get First Review
            $review1 = $this->getCorrectId($this->getData('review1'), 'review');
            $this->setData('review1', $review1);

            // Get Second Review
            $review2 = $this->getCorrectId($this->getData('review2'), 'review');
            $this->setData('review2', $review2);

            $review1 = Mage::getModel('review/review')->load($review1);
            $review2 = Mage::getModel('review/review')->load($review2);

            $firstProduct->setReview($review1);
            $secondProduct->setReview($review2);

            // Load Options for grouped products
            $options1 = $this->getData('options1');
            if ($options1) {
                $firstProduct->setConfiguredOptions(explode(',', $options1));
            }

            $options2 = $this->getData('options2');
            if ($options2) {
                $secondProduct->setConfiguredOptions(explode(',', $options2));
            }

            $this->setData('products', array(1 => $firstProduct, 2 => $secondProduct));
        }

        return $this;
    }

    /**
     * Get the ID from a passed in string
     *
     * String examples are:
     * product/1234
     * product/1234/4567
     * review/1234
     *
     * @param $value
     * @param $type
     *
     * @return bool|string
     */
    protected function getCorrectId($value, $type)
    {
        $value = explode('/', $value);
        $id = false;
        if (isset($value[0]) && isset($value[1]) && $value[0] == $type) {
            $id = $value[1];
        }
        return $id;
    }

    /**
     * Get Option text for product, attribute and attribute id
     *
     * @param $product
     * @param $attributeName
     * @param $id
     *
     * @return null
     */
    protected function getOptionText($product, $attributeName, $id)
    {
        $attr = $product->getResource()->getAttribute($attributeName);
        if ($attr->usesSource()) {
            return $attr->getSource()->getOptionText($id);
        }
        return null;
    }

    /**
     * Load attribute by code to used on frontend
     *
     * @param $attributeName
     *
     * @return Mage_Eav_Model_Entity_Attribute_Abstract
     * @throws Mage_Core_Exception
     */
    protected function getAttribute($attributeName)
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, $attributeName);
        return $attribute;
    }

    /**
     * Retrieve url for add product to cart
     * Will return product view page URL if product has required options
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($product, $additional = array())
    {
        if ($product->getTypeInstance(true)->hasRequiredOptions($product)) {
            if (!isset($additional['_escape'])) {
                $additional['_escape'] = true;
            }
            if (!isset($additional['_query'])) {
                $additional['_query'] = array();
            }
            $additional['_query']['options'] = 'cart';

            return $this->getProductUrl($product, $additional);
        }
        return $this->helper('checkout/cart')->getAddUrl($product, $additional);
    }

    /**
     * Retrieve Product URL using UrlDataObject
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $additional the route params
     * @return string
     */
    public function getProductUrl($product, $additional = array())
    {
        if ($this->hasProductUrl($product)) {
            if (!isset($additional['_escape'])) {
                $additional['_escape'] = true;
            }
            return $product->getUrlModel()->getUrl($product, $additional);
        }

        return '#';
    }

    /**
     * @return Itoris_GroupedProductConfiguration_Helper_Data
     */
    public function getDataHelper() {
        return Mage::helper('itoris_groupedproductconfiguration');
    }

    /**
     * Add Option Block for bundle products
     *
     * @param $subProduct
     *
     * @return Mage_Core_Block_Abstract
     */
    public function optionBlock($subProduct) {
        $wrapper = $this->getLayout()->createBlock('catalog/product_view');
        $wrapper->setTemplate('catalog/product/view/options/wrapper.phtml');
        $coreTemplate = $this->getLayout()->createBlock('core/template');
        $coreTemplate->setTemplate('catalog/product/view/options/js.phtml');
        $wrapper->append($coreTemplate);
        $product = Mage::getModel('catalog/product')->load($subProduct->getId());
        if ($subProduct->getTypeId() == 'bundle') {
            //$optionBlock = $this->getLayout()->createBlock('bundle/catalog_product_view_type_bundle');
            $bundleBlock = $this->getLayout()->createBlock('bundle/catalog_product_view_type_bundle');
            $bundleBlock->setProduct($product);
            //$bundleBlock->addPriceBlockType('bundle', 'bundle/catalog_product_price', 'bundle/catalog/product/price.phtml');
            $bundleBlock->setTemplate('itoris/groupedproductconfiguration/product/bundle/bundle.phtml');
            $wrapper->append($bundleBlock);
            $optionBlock = $this->getLayout()->createBlock('itoris_groupedproductconfiguration/product_bundle_option');
            $optionBlock->setProduct($product);
            $optionBlock->addRenderer('select', 'itoris_groupedproductconfiguration/product_bundle_options_select');
            $optionBlock->addRenderer('multi', 'itoris_groupedproductconfiguration/product_bundle_options_multi');
            $optionBlock->addRenderer('radio', 'itoris_groupedproductconfiguration/product_bundle_options_radio');
            $optionBlock->addRenderer('checkbox', 'itoris_groupedproductconfiguration/product_bundle_options_checkbox');
            //$optionBlock->setTemplate('bundle/catalog/product/view/type/bundle/options.phtml');
            $optionBlock->setTemplate('itoris/groupedproductconfiguration/product/bundle/options.phtml');
        } elseif ($subProduct->getTypeId() == 'configurable') {
            $optionBlock = $this->getLayout()->createBlock('catalog/product_view_type_configurable');
            $optionBlock->setProduct($product);
            $optionBlock->setTemplate('itoris/groupedproductconfiguration/product/configurable/options.phtml');
        } else {
            /* @var $optionBlock Mage_Catalog_Block_Product_View_options */
            $optionBlock = $this->getLayout()->createBlock('catalog/product_view_options');
            $optionBlock->addOptionRenderer('text', 'catalog/product_view_options_type_text', 'catalog/product/view/options/type/text.phtml');
            $optionBlock->addOptionRenderer('file', 'catalog/product_view_options_type_file', 'catalog/product/view/options/type/file.phtml');
            $optionBlock->addOptionRenderer('select', 'catalog/product_view_options_type_select', 'catalog/product/view/options/type/select.phtml');
            $optionBlock->addOptionRenderer('date', 'catalog/product_view_options_type_date', 'catalog/product/view/options/type/date.phtml');
            $optionBlock->setProduct($product);
            $optionBlock->setTemplate('itoris/groupedproductconfiguration/product/options.phtml');
        }

        $wrapper->append($optionBlock);
        return $wrapper;
    }

    /**
     * Json config values for bundle products
     *
     * @param $subProduct
     *
     * @return mixed
     */
    public function getConfig($subProduct) {
        $config = array();
        /*if (!$subProduct->hasOptions()) {
            return Mage::helper('core')->jsonEncode($config);
        }*/

        $_request = Mage::getSingleton('tax/calculation')->getRateRequest(false, false, false);
        /* @var $product Mage_Catalog_Model_Product */
        $product = Mage::getModel('catalog/product')->load($subProduct->getId());
        $_request->setProductClassId($product->getTaxClassId());
        $defaultTax = Mage::getSingleton('tax/calculation')->getRate($_request);

        $_request = Mage::getSingleton('tax/calculation')->getRateRequest();
        $_request->setProductClassId($product->getTaxClassId());
        $currentTax = Mage::getSingleton('tax/calculation')->getRate($_request);

        $_regularPrice = $product->getPrice();
        $_finalPrice = $product->getFinalPrice();
        $_priceInclTax = Mage::helper('tax')->getPrice($product, $_finalPrice, true);
        $_priceExclTax = Mage::helper('tax')->getPrice($product, $_finalPrice);
        $_tierPrices = array();
        $_tierPricesInclTax = array();
        foreach ($product->getTierPrice() as $tierPrice) {
            $_tierPrices[] = Mage::helper('core')->currency($tierPrice['website_price'], false, false);
            $_tierPricesInclTax[] = Mage::helper('core')->currency(
                Mage::helper('tax')->getPrice($product, (int)$tierPrice['website_price'], true),
                false, false);
        }
        $config = array(
            'productId'           => $product->getId(),
            'priceFormat'         => Mage::app()->getLocale()->getJsPriceFormat(),
            'includeTax'          => Mage::helper('tax')->priceIncludesTax() ? 'true' : 'false',
            'showIncludeTax'      => Mage::helper('tax')->displayPriceIncludingTax(),
            'showBothPrices'      => Mage::helper('tax')->displayBothPrices(),
            'productPrice'        => Mage::helper('core')->currency($_finalPrice, false, false),
            'productOldPrice'     => Mage::helper('core')->currency($_regularPrice, false, false),
            'priceInclTax'        => Mage::helper('core')->currency($_priceInclTax, false, false),
            'priceExclTax'        => Mage::helper('core')->currency($_priceExclTax, false, false),
            /**
             * @var skipCalculate
             * @deprecated after 1.5.1.0
             */
            'skipCalculate'       => ($_priceExclTax != $_priceInclTax ? 0 : 1),
            'defaultTax'          => $defaultTax,
            'currentTax'          => $currentTax,
            'idSuffix'            => '_clone',
            'oldPlusDisposition'  => 0,
            'plusDisposition'     => 0,
            'plusDispositionTax'  => 0,
            'oldMinusDisposition' => 0,
            'minusDisposition'    => 0,
            'tierPrices'          => $_tierPrices,
            'tierPricesInclTax'   => $_tierPricesInclTax,
        );

        $responseObject = new Varien_Object();
        if (is_array($responseObject->getAdditionalOptions())) {
            foreach ($responseObject->getAdditionalOptions() as $option=>$value) {
                $config[$option] = $value;
            }
        }
        //return $config;
        return Mage::helper('core')->jsonEncode($config);
    }

    /**
     * Retrieve given media attribute label or product name if no label
     *
     * @param Mage_Catalog_Model_Product $product
     * @param string $mediaAttributeCode
     *
     * @return string
     */
    public function getImageLabel($product=null, $mediaAttributeCode='image')
    {
        if (is_null($product)) {
            $product = $this->getProduct();
        }

        $label = $product->getData($mediaAttributeCode.'_label');
        if (empty($label)) {
            $label = $product->getName();
        }

        return $label;
    }
}
