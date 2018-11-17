<?php

class USWF_PreviewCart_Block_Page extends Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retrieve current product instance (if actual and available)
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return Mage::registry('previewcart_product');
    }

    /**
     * Retrieve given media attribute label or product name if no label
     *
     * @param Mage_Catalog_Model_Product $product
     * @param string $mediaAttributeCode
     *
     * @return string
     */
    public function getImageLabel($product = null, $mediaAttributeCode = 'image')
    {
        if (is_null($product)) {
            $product = $this->getProduct();
        }

        $label = $product->getData($mediaAttributeCode . '_label');
        if (empty($label)) {
            $label = $product->getName();
        }

        return $label;
    }

    /**
     * Retrieve free shipping subtotal
     *
     * @return float
     */
    public function getFreeShippingSubtotal() {
        $result = 0;
        $freeshipping = Mage::getStoreConfig('carriers/freeshipping', Mage::app()->getStore());
        if (!is_null($freeshipping) && $freeshipping['active'] == 1 && isset($freeshipping['free_shipping_subtotal']) && $freeshipping['free_shipping_subtotal'] > 0) {
            $freeShippingSubtotal = $freeshipping['free_shipping_subtotal'];
            $subtotal = $this->helper('checkout/cart')->getQuote()->getSubtotal();
            $result = $freeShippingSubtotal - $subtotal;
        }
        return $result;
    }

    /**
     * Retrieve quote subtotal
     *
     * @return float
     */
    public function getSubtotal() {
        return $this->helper('checkout/cart')->getQuote()->getSubtotal();
    }
    /**
     * Get shopping cart items qty based on configuration (summary qty or items qty)
     *
     * @return int | float
     */
    public function getSummaryCount()
    {
        return $this->helper('checkout/cart')->getQuote()->getItemsSummaryQty();
    }

    /**
     * Get one page checkout page url
     *
     * @return bool
     */
    public function getCheckoutUrl()
    {
        return $this->helper('checkout/url')->getCheckoutUrl();
    }

    /**
     * Return the Group Page URL if exists
     *
     * @return String
     */
    public function getProductUrl()
    {
        $_product = $this->getProduct();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        //$item = $quote->getItemByProduct($_product);
        $item = false;
        foreach ($quote->getItemsCollection() as $_item) {
            if ($_item->getProductId() == $_product->getId()) {
                $item = $_item;
            }
        }
        if ($item) {
            $infoBuyRequest = $item->getOptionByCode('info_buyRequest');
            $buyRequest = new Varien_Object(unserialize($infoBuyRequest->getValue()));
            $nfsUrl = $buyRequest->getData('grouped-product-url');
            $parentId = $item->getData('grouped_product_id');
            if ($nfsUrl) {
                return $nfsUrl;
            } else if ($parentId) {
                $parent = Mage::getModel('catalog/product')->load($parentId);
                return $parent->getProductUrl();
            }

            if ($item->getRedirectUrl()) {
                return $item->getRedirectUrl();
            }
        }
        return $_product->getUrlModel()->getUrl($_product);
    }
}
