<?php

class Celigo_Connector_Model_Observer extends Mage_Core_Model_Abstract {
    /** @var Celigo_Connector_Helper_Data */
    protected $_helper;
    /** @var Celigo_Connector_Model_Connector */
    protected $_model;
    /**
     * Initialize Helper & Model
     */
    public function _construct() {
        $this->_helper = Mage::helper('connector');
        $this->_model = Mage::getModel('connector/connector');
    }
    /**
     * Customer save after event observer
     * @param Varien_Event_Observer $observer
     */
    public function customerSaveAfter($observer) {
        /* Check if the event triggered by API */
        if ($this->_isApiRequest()) {
            
            return;
        }
        /* Check if the event triggered by Checkout Module */
        if ($this->_isCheckoutRequest()) {
            
            return;
        }
        $customer = $observer->getEvent()->getCustomer();
        $keyString = 'customer_save_observer_executed_' . $customer->getId();
        if (Mage::registry($keyString)) {
            
            return;
        }
        $websiteId = $customer->getWebsiteId();
        $storeId = $customer->getStoreId();
        if ($storeId == 0) $storeId = '';
        /** If the Push to NetSuite setting was set to No then return false */
        if (!$this->_helper->getIsConnectorModuleEnabled($storeId, $websiteId)) {
            
            return;
        }
        /** If the action is required then make following happen */
        try {
            /** Push customer information to NetSuite */
            $this->_model->pushCustomerToNetSuite($customer->getId() , $storeId, $websiteId);
            /** Set the registry variable value to customer ID */
            Mage::register($keyString, $customer->getId());
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, $websiteId);
        }
    }
    /**
     * Address save after event observer
     * @param Varien_Event_Observer $observer
     */
    public function afterAddressSaveAfter($observer) {
        /* Check if the event triggered by API */
        if ($this->_isApiRequest()) {
            
            return;
        }
        /* Check if the event triggered by Checkout Module */
        if ($this->_isCheckoutRequest()) {
            
            return;
        }
        /** @var $customerAddress Mage_Customer_Model_Address */
        $customerAddress = $observer->getCustomerAddress();
        $customer = $customerAddress->getCustomer();
        $keyString = 'customer_save_observer_executed_' . $customer->getId();
        if (Mage::registry($keyString)) {
            
            return;
        }
        $websiteId = $customer->getWebsiteId();
        $storeId = $customer->getStoreId();
        if ($storeId == 0) $storeId = '';
        /** If the Push to NetSuite setting was set to No then return false */
        if (!$this->_helper->getIsConnectorModuleEnabled($storeId, $websiteId)) {
            
            return;
        }
        /** If the address is not default billing or shipping address then return nothing */
        if (!($customer->getDefaultBilling() == $customerAddress->getEntityId() || $customer->getDefaultShipping() == $customerAddress->getEntityId())) {
            
            return;
        }
        /** If the action is required then make following happen */
        try {
            /** Push customer information to NetSuite */
            $this->_model->pushCustomerToNetSuite($customer->getId() , $storeId, $websiteId);
            /** Set the registry variable value to customer ID */
            Mage::register($keyString, $customer->getId());
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, $websiteId);
        }
    }
    /**
     * Checkout Onepage Succuss Action
     *
     * @param Varien_Event_Observer $observer
     */
    /**
     *	This event triggered in following Module Controller Actions
     *	Module: checkout --- Controller: onepage --- Action: success
     *	Module: checkout --- Controller: multishipping --- Action: success
     */
    public function checkoutOnepageSuccussAction($observer) {
        $orderIds = $observer->getEvent()->getOrderIds();
        /** Check if the order IDs or valid */
        if (empty($orderIds) || !is_array($orderIds)) {
            $this->_helper->addErrorMessageToLog("Method is checkoutOnepageSuccussAction, Error is: Order Ids ( {{$orderIds}} ) are empty or not an array", Zend_Log::ERR);
            
            return;
        }
        try {
            $this->_model->pushOrderToNS($orderIds);
            /** Destroy the payment information once the order is pushed */
            Mage::getSingleton('core/session')->setPaymentDetails('');
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, '', '');
            
            return;
        }
    }
    /**
     * salesQuotePaymentImportDataBefore
     *
     * @param Varien_Event_Observer $observer
     */
    public function salesQuotePaymentImportDataBefore($observer) {
        $storeId = Mage::app()->getStore()->getId();
        /** If the Push to NetSuite setting was set to No then return false */
        if (!$this->_helper->getIsConnectorModuleEnabled($storeId)) {
            
            return;
        }
        /** Save the payment information into session */
        try {
            $paymentData = $observer->getData('input');
            Mage::getSingleton('core/session')->setPaymentDetails($paymentData->getData());
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
        }
    }
    /**
     * Event Observer to listen sales order save after event
     *
     * @param Mage_Sales_Model_Order $observer
     */
    public function orderSaveAfter($observer) {
        /* Check if the event triggered by API */
        if ($this->_isApiRequest()) {
            
            return;
        }
        $order = $observer->getEvent()->getOrder();
        try {
            if ($order->getPushedToNs() === 1) {
                
                return;
            } elseif (!$this->_helper->getIsConnectorModuleEnabled($order->getStoreId())) {
                
                return;
            }
            $statuses = $this->_helper->getOrderStatusArray($order->getStoreId());
            if (count($statuses) > 0 && in_array($order->getStatus() , $statuses)) {
                $keyString = 'sales_order_save_after_observer_executed_' . $order->getId();
                if (Mage::registry($keyString)) {
                    
                    return;
                }
                // Push to NetSuite
                Mage::getModel('connector/connector')->pushOrderToNS($order->getId());
                /** Set the registry variable to order ID */
                Mage::register($keyString, $order->getId());
            }
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $order->getStoreId() , '');
        }
    }
    /**
     * Return true if the reqest is made via the api
     *
     * @return boolean
     */
    private function _isApiRequest() {
        
        return Mage::app()->getRequest()->getModuleName() === 'api';
    }
    /**
     * Return true if the reqest is made via checkout module
     *
     * @return boolean
     */
    private function _isCheckoutRequest() {
        $modName = Mage::app()->getRequest()->getModuleName();
        if (isset($modName) && $modName != '') {
            $pos = strpos(strtolower($modName) , 'checkout');
            if ($pos !== false) {
                
                return true;
            }
        }
        
        return false;
    }
}
