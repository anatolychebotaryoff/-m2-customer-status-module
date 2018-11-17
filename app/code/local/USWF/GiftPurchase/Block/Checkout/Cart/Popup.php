<?php

class USWF_GiftPurchase_Block_Checkout_Cart_Popup extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all cart items
     *
     * @return array
     */
    public function getItems()
    {
        return Mage::getSingleton('checkout/cart')->getQuote()->getAllVisibleItems();
    }

    public function getPopupText(){
        return Mage::getSingleton('checkout/session')->getGiftProductRulePopupText();
    }
}
