<?php

class USWF_PreviewCart_Model_Observer
{
    protected $_helper;

    /**
     * Class construct
     *
     * @param array $constructArguments
     */
    public function __construct(array $constructArguments)
    {
        $this->_helper = Mage::helper('uswf_previewcart');
    }

    public function checkoutCartAddPreviewPage(Varien_Event_Observer $observer)
    {
        if (Mage::getStoreConfigFlag(USWF_PreviewCart_Helper_Data::XML_PATH_PREVIEWCART_ACTIVE, Mage::app()->getStore())
            && $this->_helper->isModuleEnabled()
            && $observer->getRequest()->getActionName() == 'add') {
            if (!$this->_getSession()->getNoCartRedirect(true)
                && !$this->_getCart()->getQuote()->getHasError()
                && $this->hasItems($observer->getProduct())) {
                // clear layout messages in case url redirect
                $this->_getSession()->getMessages(true);
                $this->_getSession()->setNoCartRedirect(true);
                $observer->getResponse()->setRedirect(Mage::getUrl('uswf_previewcart'));
            }
        }
    }

    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Check is has items
     *
     * @return bool
     */
    public function hasItems($product)
    {
        if (Mage::registry('previewcart_product')) {
            Mage::unregister('previewcart_product');
        }

        Mage::register('previewcart_product', $product);
        if (Mage::getBlockSingleton('uswf_previewcart/crosssell')->hasItems()
            || Mage::getBlockSingleton('uswf_previewcart/upsell')->hasItems()) {
            return true;
        } else {
            return false;
        }
    }

}