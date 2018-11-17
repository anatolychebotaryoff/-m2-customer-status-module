<?php
class Sam_CustomShipping_Block_Shipping extends Mage_Core_Block_Template{

    protected function _beforeToHtml(){
        $this->getChild('shipping_method')->setQuote(Mage::getSingleton('checkout/session')->getQuote());
    }
}