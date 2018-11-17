<?php

class Celigo_Connector_AsyncController extends Mage_Core_Controller_Front_Action {
    /** @var Celigo_Connector_Helper_Data */
    protected $_helper;
    protected $_model;
    /**
     * Initialize Helper
     */
    public function _construct() {
        $this->_helper = Mage::helper('connector');
        $this->_model = Mage::getModel('connector/connector');
    }
    public function indexAction() {
        $this->getResponse()->setRedirect(Mage::getBaseUrl());
    }
    public function orderImportAction() {
        ignore_user_abort(true);
        set_time_limit(0);
        try {
            $data = $this->getRequest()->getPost();
            if (isset($data['orderIds'][0]) && trim($data['orderIds'][0]) != '') {
                $orderIds = $data['orderIds'];
                if (isset($data['cc'])) {
                    Mage::getSingleton('core/session')->setPaymentDetails($data['cc']);
                }
                $this->_model->pushOrderToNS($orderIds, Celigo_Connector_Helper_Async::TYPE_SYNC);
            } else {
                $this->getResponse()->setRedirect(Mage::getBaseUrl());
            }
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMeesage() , Zend_Log::ERR, '', '');
            $this->getResponse()->setRedirect(Mage::getBaseUrl());
        }
    }
    public function customerImportAction() {
        ignore_user_abort(true);
        set_time_limit(0);
        try {
            $data = $this->getRequest()->getPost();
            $customerId = $storeId = $websiteId = '';
            if (isset($data['customerId']) && trim($data['customerId']) != '') {
                $customerId = $data['customerId'];
            }
            if (isset($data['storeId']) && trim($data['storeId']) != '') {
                $storeId = $data['storeId'];
            }
            if (isset($data['websiteId']) && trim($data['websiteId']) != '') {
                $websiteId = $data['websiteId'];
            }
            if (isset($data['customerId']) && trim($data['customerId']) != '') {
                // Push the customer to NetSuite
                $result = $this->_model->pushCustomerToNetSuite($customerId, $storeId, $websiteId, Celigo_Connector_Helper_Async::TYPE_SYNC);
            } else {
                $this->getResponse()->setRedirect(Mage::getBaseUrl());
            }
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMeesage() , Zend_Log::ERR, '', '');
            $this->getResponse()->setRedirect(Mage::getBaseUrl());
        }
    }
}
