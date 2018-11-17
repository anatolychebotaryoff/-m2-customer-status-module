<?php

class USWF_PreviewCart_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        if (!Mage::getStoreConfigFlag(USWF_PreviewCart_Helper_Data::XML_PATH_PREVIEWCART_ACTIVE, Mage::app()->getStore())
        || is_null($this->initProduct())) {
            $this->_redirect('/');
            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Init current product instance (if actual and available)
     *
     * @return Mage_Catalog_Model_Product
     */
    public function initProduct()
    {
        $lastAdded = (int) $this->_getLastAddedProductId();
        if (!$lastAdded) {
            return null;
        }
        if (!Mage::registry('previewcart_product')) {
            $product = Mage::getModel('catalog/product')->load($lastAdded);
            Mage::register('previewcart_product', $product);
        }
        return Mage::registry('previewcart_product');
    }

    /**
     * Get last product ID that was added to cart
     *
     * @return int
     */
    protected function _getLastAddedProductId()
    {
        return Mage::getSingleton('checkout/session')->getLastAddedProductId();
    }
}
