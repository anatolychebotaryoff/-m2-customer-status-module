<?php

class Celigo_Connector_Model_Connector extends Mage_Core_Model_Abstract {
    /** @var Celigo_Connector_Helper_Data */
    protected $_helper;
    const PUSHED_TO_NS_FLAG = 1;
    const PUSHTONS_DISABLED_MSG = 'Push to NetSuite functionality disabled for this store';
    const NOT_ALLOWED_STATUS_MSG = 'Order with this status cannot be pushed to NetSuite as per settings';
    const UNEXPECTED_ERROR_MSG = 'Unexpected error. Please try again';
    const PUT_METHOD = 'put';
    const POST_METHOD = 'post';
    const XML_PATH_TECHNICAL_CONTACT_EMAIL = 'connector/othersettings/technical_contact_email';
    public function _construct() {
        parent::_construct();
        $this->_helper = Mage::helper('connector');
        $this->_init('connector/connector');
    }
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {
        
        return array(
            array(
                'value' => 'SANDBOX',
                'label' => Mage::helper('connector')->__('SANDBOX')
            ) ,
            array(
                'value' => 'PRODUCTION',
                'label' => Mage::helper('connector')->__('PRODUCTION')
            ) ,
            array(
                'value' => 'BETA',
                'label' => Mage::helper('connector')->__('BETA')
            ) ,
        );
    }
    /**
     * Make a REST call and check the response
     * Usage: Mage::getModel('connector/connector')->makeRestCall($json, $storeId);
     *
     * @param string $json
     * @param string $controller
     * @param string $action
     * @return bool
     */
    public function makeRestCall($json, $storeId = '', $method = self::PUT_METHOD, $debug = false) {
        /** If the Push to NetSuite setting was set to No then return false */
        if (!$this->_helper->getIsConnectorModuleEnabled($storeId) && !$debug) {
            
            return self::PUSHTONS_DISABLED_MSG;
        }
        /* Uncomment following line to log the Request Module name, Controller name and Action Name */
        //$req = Mage::app()->getRequest(); $this->_helper->addErrorMessageToLog($req->getModuleName()."--".$req->getControllerName()."--".$req->getActionName(), 3);
        /* Uncomment following line to log the complete JSON Request Data */
        //$this->_helper->addErrorMessageToLog($json, Zend_Log::ERR); //return true;  exit;
        $headers = $this->_helper->getRestLetHeaders($storeId);
        $restLetUrl = $this->_helper->getRestletURL($storeId);
        if ($restLetUrl == '' || $json == '') {
            
            return 'REStLet URL was empty';
        }
        try {
            $api = new Celigo_Connector_Model_Restclient(array(
                'base_url' => $restLetUrl,
                'headers' => $headers
            ));
            $parameters = array();
            $parameters['body'] = (string)$json;
            if ($method == self::PUT_METHOD) {
                $result = $api->put("", $parameters, $headers);
            } elseif ($method == self::POST_METHOD) {
                $result = $api->post("", $parameters, $headers);
            }
            $messages = array();
            if (isset($result->response) && $result->response != '') {
                $response = Mage::helper('core')->jsonDecode($result->response);
                if (isset($response['result']) && is_array($response['result'])) {
                    if (count($response['result']) > 0) {
                        
                        foreach ($response['result'] as $resultRow) {
                            if (isset($resultRow['error']) && is_array($resultRow['error'])) {
                                if (isset($resultRow['error']['code']) && isset($resultRow['error']['message'])) {
                                    $message = "Error Code is: " . $resultRow['error']['code'] . " And Error Message is: " . $resultRow['error']['message'];
                                    $this->_helper->addErrorMessageToLog($message, Zend_Log::ERR, $storeId, '');
                                    $messages[] = $message;
                                }
                            } elseif (isset($resultRow['result'])) {
                                $messages[] = true;
                            } else {
                                $messages[] = false;
                            }
                        }
                    } else {
                        $messages[] = true;
                    }
                }
                if (isset($response['error']) && is_array($response['error'])) {
                    if (isset($response['error']['code']) && isset($response['error']['message'])) {
                        $message = "Error Code is: " . $response['error']['code'] . " And Error Message is: " . $response['error']['message'];
                        $this->_helper->addErrorMessageToLog($message, Zend_Log::ERR, $storeId, '');
                        $messages[] = $message;
                    }
                }
            }
            if (isset($result->error) && $result->error != '') {
                $message = "Error Message is: " . $result->error;
                $this->_helper->addErrorMessageToLog($message, Zend_Log::ERR, $storeId, '');
                $messages[] = $message;
            }
            /* Uncomment following line to log full result */
            //$this->_helper->addErrorMessageToLog($result, Zend_Log::ERR, $storeId);
            if ($result->info->http_code == 401) {
                $this->sendErrorEmailToMGAdmin($storeId);
            }
            
            return $messages;
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
            
            return $e->getMessage();
        }
    }
    /**
     * Return payment information as an array
     *
     * @return array
     */
    private function getOriginalPaymentInfomation($orderid = '', $storeId = '') {
        if ($orderid != '') {
            try {
                
                return $paymentinfo = Mage::getSingleton('core/session')->getPaymentDetails();
            }
            catch(Exception $e) {
                $this->_helper->addErrorMessageToLog("Method name is getOriginalPaymentInfomation and Error is: " . $e->getMessage() , Zend_Log::ERR, $storeId);
            }
        }
        
        return false;
    }
    /**
     * Push the selected order to NetSuite if not pushed
     */
    public function pushOrderToNS($orderIds = '', $type = Celigo_Connector_Helper_Async::TYPE_ASYNC, $debug = false, $isBatch = false) {
        if (!is_array($orderIds)) {
            $orderIds = array(
                $orderIds
            );
        }
        if ($type == Celigo_Connector_Helper_Async::TYPE_ASYNC) {
            if (Mage::helper('connector/async')->makeAsyncOrderImportCall($orderIds)) {
                
                return true;
            }
        }
        $orders = array();
        
        foreach ($orderIds as $orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
            if (!$order->getId()) {
                
                return 'This Order does not exists';
            }
            array_push($orders, $order);
        }
        try {
            $storeId = $orders[0]->getStoreId();
            /** If the Push to NetSuite setting was set to No then return false */
            if (!$this->_helper->getIsConnectorModuleEnabled($storeId) && !$debug) {
                
                return self::PUSHTONS_DISABLED_MSG;
            }
            // Make a Rest call Here
            $postData = array();
            $postData['id'] = 1;
            $postData['jsonrpc'] = '2.0';
            $postData['method'] = 'order';
            $postData['params'] = array();
            /** Build an array of Meta data Flow ID */
            $realtimeDataFlowId = '';
            if ($isBatch) {
                $realtimeDataFlowId = $this->_helper->getBatchOrderFlowId($storeId);
            } else {
                $realtimeDataFlowId = $this->_helper->getOrderFlowId($storeId);
            }
            if ($debug && trim($realtimeDataFlowId) == '') {
                $realtimeDataFlowId = $this->_helper->getBatchOrderFlowId($storeId);
            }
            if (trim($realtimeDataFlowId) == '') 
            return 'Flow Id is blank';
            $postData['params'][] = array(
                "realtimeDataFlowId" => $realtimeDataFlowId
            );
            $ordersInfo = array();
            
            foreach ($orders as $order) {
                /** Get all the order statuses from setting that need to be synced to NetSuite */
                $status = $this->_helper->getOrderStatusArray($storeId);
                if (count($status) == 0 && !$debug) {
                    //do not return just continue in the loop
                    continue;
                }
                if (in_array($order->getStatus() , $status) || $debug) {
                    $orderInfo = array();
                    $orderIncrementId = $order->getIncrementId();
                    $OrdersApiObj = Mage::getModel('sales/order_api');
                    $orderInfo = $OrdersApiObj->info($orderIncrementId);
                    //they all share payment info Alas!!!
                    $payment_information = $this->getOriginalPaymentInfomation($orderIds[0], $storeId);
                    if (is_array($payment_information)) {
                        
                        foreach ($payment_information as $key => $value) {
                            $orderInfo['payment'][$key] = $value;
                        }
                    }
                    array_push($ordersInfo, $orderInfo);
                } else {
                    //do not return just continue in the loop
                    continue;
                }
            }
            if (count($ordersInfo) <= 0) {
                
                return self::NOT_ALLOWED_STATUS_MSG;
            }
            $postData['params'][] = $ordersInfo;
            /** Convert the information into JSON format */
            $json = Mage::helper('core')->jsonEncode($postData);
            // Make a Rest call Here
            $result = $this->makeRestCall($json, $storeId, self::PUT_METHOD, $debug);
            $pushedOrderStatus = $this->_helper->getPushedOrderStatus($order->getStoreId());
            if ($result === true) {
                
                return $result;
            } else {
                if (is_array($result)) {
                    
                    foreach ($result as $row) {
                        if (($row === true && !is_array($row)) || trim($row) == "") {
                            
                            return true;
                        } else {
                            
                            return $row;
                        }
                    }
                }
            }
            /** Start :: Code to log the json content for testing */
            /* Mage::helper('connector')->addErrorMessageToLog($json, Zend_Log::DEBUG);
            /** End :: Code to log the json content for testing */
            $this->_helper->addErrorMessageToLog(self::UNEXPECTED_ERROR_MSG, Zend_Log::ERR, $storeId, '');
            
            return self::UNEXPECTED_ERROR_MSG;
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
            
            return $e->getMessage();
        }
    }
    /**
     * Return customer information along with default billing and shipping addresses information as an array
     *
     * @return array
     */
    private function getCustomerFullDetails($customerId = '', $storeId = '') {
        $resultArray = array();
        if ($customerId == '') 
        return $resultArray;
        try {
            $customerApiObj = Mage::getModel('customer/customer_api');
            $resultArray = $result = $customerApiObj->info($customerId);
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
        }
        if (isset($result['default_billing']) && $result['default_billing'] != '') {
            try {
                $customerAddressApiObj = Mage::getModel('customer/address_api');
                $resultArray['addresses'][] = $customerAddressApiObj->info($result['default_billing']);
            }
            catch(Exception $e) {
                $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
            }
        }
        if (isset($result['default_shipping']) && $result['default_shipping'] != '' && $result['default_shipping'] != $result['default_billing']) {
            try {
                $customerAddressApiObj = Mage::getModel('customer/address_api');
                $resultArray['addresses'][] = $customerAddressApiObj->info($result['default_shipping']);
            }
            catch(Exception $e) {
                $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
            }
        }
        
        return $resultArray;
    }
    public function pushCustomerToNetSuite($customerId = '', $storeId = '', $websiteId = '', $type = Celigo_Connector_Helper_Async::TYPE_ASYNC) {
        try {
            if ($type == Celigo_Connector_Helper_Async::TYPE_ASYNC) {
                if (Mage::helper('connector/async')->makeAsyncCustomerImportCall($customerId, $storeId, $websiteId)) {
                    
                    return true;
                }
            }
            $postData = array();
            $postData['id'] = 1;
            $postData['jsonrpc'] = '2.0';
            $postData['method'] = 'customer';
            $postData['params'] = array();
            /** Build an array of Meta data Flow ID */
            $realtimeDataFlowId = $this->_helper->getCustomerFlowId($storeId, $websiteId);
            if (trim($realtimeDataFlowId) == '') {
                
                return;
            }
            $postData['params'][] = array(
                "realtimeDataFlowId" => $realtimeDataFlowId
            );
            /** Get an array of customer information along with default shipping and billing address info by Customer ID */
            $customerInfo = array();
            $customerInfo[] = $this->getCustomerFullDetails($customerId, $storeId);
            $postData['params'][] = $customerInfo;
            /** Convert the information into JSON format */
            $json = Mage::helper('core')->jsonEncode($postData);
            // Make a Rest call Here
            $this->makeRestCall($json, $storeId);
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
        }
    }
    public function sendErrorEmailToMGAdmin($storeId = '') {
        try {
            $recipientEmails = array();
            $techEmail = $this->_helper->getConfigValue(self::XML_PATH_TECHNICAL_CONTACT_EMAIL);
            if (trim($techEmail) != '') {
                $recipientEmails[] = array(
                    "name" => "Technical Contact",
                    "email" => $techEmail
                );
            } else {
                $roleIds = array();
                $rulesCollection = Mage::getResourceModel('admin/permissions_collection')->addFieldToFilter("permission", "allow")->addFieldToFilter("resource_id", "all");
                if ($rulesCollection->count() > 0) {
                    
                    foreach ($rulesCollection as $rule) {
                        $roleIds[] = $rule->getRoleId();
                    }
                }
                if (count($roleIds) > 0) {
                    $adminUsersCollection = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('is_active', 1)->setOrder('user_id', 'ASC');
                    if ($adminUsersCollection->count() > 0) {
                        
                        foreach ($adminUsersCollection as $adminUser) {
                            $role = $adminUser->getRole();
                            if (in_array($role->getRoleId() , $roleIds)) {
                                $recipientEmails[] = array(
                                    "name" => $adminUser->getFirstname() ,
                                    "email" => $adminUser->getEmail()
                                );
                            }
                        }
                    }
                }
            }
            if (count($recipientEmails) > 0) {
                $fromName = "Celigo Magento Connector";
                $fromEmail = "magento@celigo.com";
                $nsemail = $this->_helper->getConfigValue(Celigo_Connector_Helper_Data::XML_PATH_NETSUITE_EMAIL, $storeId, '');
                
                foreach ($recipientEmails as $recipient) {
                    $toName = $recipient['name'];
                    $bodyHtml = "Dear {$toName},<br /><br />We are not able to connect to your NetSuite account through Magento.<br /><br />In general, connection errors are most likely related to expired NetSuite credentials and/or modified credentials that have not been updated in the Magento Admin panel. In any case, if an email or password has changed please be sure to update Magento Admin with the latest NetSuite credential information.<br /><br />You can update the credentials for \"Netsuite Integration User Details\" section in the Magento Admin panel.<br />This is available under: <strong>System > Configuration > Celigo Magento Connector (Plus)</strong><br /><br />Thanks,<br />Celigo Team";
                    $mail = new Zend_Mail();
                    $mail->setFrom($fromEmail, $fromName);
                    $mail->addTo($recipient['email'], $toName);
                    $mail->setSubject("IMPORTANT: Failed to connect to NetSuite account " . $nsemail . " through Magento");
                    $mail->setBodyHtml($bodyHtml);
                    $mail->send();
                }
            }
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
        }
    }
}
