<?php

require_once  Mage::getModuleDir('controllers', 'Mage_Paypal') . DS . 'ExpressController.php';

class Sam_CustomShipping_ExpressController extends Mage_Paypal_ExpressController {

    /**
     * Update Order (combined action for ajax and regular request)
     */
    public function updateOrderAction()
    {
        Mage::getSingleton($this->_checkoutType, array(
            'config' => $this->_config,
            'quote'  => Mage::getSingleton('checkout/session')->getQuote(),
        ))->prepareOrderReview($this->_initToken());
        parent::updateOrderAction();
    }

}