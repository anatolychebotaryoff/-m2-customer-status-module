<?php
/**
 * StoreFront CyberSource Tokenized Payment Extension for Magento
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of StoreFront Consulting, Inc.
 *
 * @category  SFC
 * @package   SFC_CyberSource
 * @author    Garth Brantley <garth@storefrontconsulting.com>
 * @copyright 2009-2013 StoreFront Consulting, Inc. All Rights Reserved.
 * @license   http://www.storefrontconsulting.com/media/downloads/ExtensionLicense.pdf StoreFront Consulting Commercial License
 * @link      http://www.storefrontconsulting.com/cybersource-saved-credit-cards-extension-for-magento/
 *
 */

class SFC_CyberSource_Helper_Payment extends Mage_Payment_Helper_Data
{

    /**
     * Retrieve method model object
     *
     * @param   string $code
     * @return  Mage_Payment_Model_Method_Abstract|false
     */
    public function getMethodInstance($code)
    {
        // Check if code includes key
        $key = SFC_CyberSource_Model_Method::METHOD_CODE . SFC_CyberSource_Model_Method::METHOD_CODE_KEY_TOKEN;
        if ($key == substr($code, 0, strlen($key))) {
            $classKey = self::XML_PATH_PAYMENT_METHODS . '/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/model';
            $class = Mage::getStoreConfig($classKey);
            /** @var SFC_CyberSource_Model_Method $model */
            $model = Mage::getModel($class);
            $encodedMethodParts = explode(SFC_CyberSource_Model_Method::METHOD_CODE_KEY_TOKEN, $code);
            $paymentToken = $encodedMethodParts[1];
            $model->setSavedProfile($paymentToken);

            return $model;
        }
        else {
            return parent::getMethodInstance($code);
        }
    }

    /**
     *
     * @param mixed $store
     * @param mixed $quote
     * @return mixed
     */
    public function getStoreMethods($store = null, $quote = null)
    {
        // Log
        /*
        Mage::log('SFC_CyberSource_Helper_Payment::getStoreMethods', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        if(is_numeric($store)) {
            Mage::log('Store Id: ' . $store, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        }
        if($store != null && is_object($store)) {
            Mage::log('Store Id: ' . $store->getId(), Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        }
        if(is_numeric($quote)) {
            Mage::log('Quote Id: ' . $quote, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        }
        if($quote != null && is_object($quote)) {
            Mage::log('Quote Id: ' . $quote->getId(), Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        }
        */
        // Call parent implementation
        $parentMethods = parent::getStoreMethods($store, $quote);
        // Build new list
        $methods = array();
        // Find payment method in list
        /** @var Mage_Payment_Model_Method_Abstract $method */
        foreach ($parentMethods as $method) {
            // Check, is this method current method
            if ($method->getCode() == SFC_CyberSource_Model_Method::METHOD_CODE) {
                // Get customer
                $customer = $this->getCustomerForProfiles($quote);
                if (strlen($customer->getId())) {
                    // Lookup profiles for this customer
                    $profileCollection = Mage::getModel('sfc_cybersource/payment_profile')->getCollection();
                    $profileCollection
                        ->addFieldToFilter('customer_id', $customer->getId());
                    // Iterate payment profiles
                    /** @var SFC_CyberSource_Model_payment_profile $paymentProfile */
                    foreach ($profileCollection as $paymentProfile) {
                        // Build new method out of profile
                        $newMethodCode = SFC_CyberSource_Model_Method::METHOD_CODE .
                            SFC_CyberSource_Model_Method::METHOD_CODE_KEY_TOKEN . $paymentProfile->getData('payment_token');
                        $newMethodInstance = $this->getMethodInstance($newMethodCode);
                        $methods[] = $newMethodInstance;
                    }
                }
            }
            // Add method from parent implementation
            $methods[] = $method;
        }

        return $methods;
    }

    protected function getCustomerForProfiles($quote)
    {
        // If quote is null, use customer from session
        if ($quote != null && is_object($quote) && $quote instanceof Mage_Sales_Model_Quote) {
            $customer = $quote->getCustomer();

            return $customer;
        }
        else {
            /** @var Mage_Customer_Model_Session $customerSession */
            //$customerSession = Mage::getSingleton('customer/session');
            /** @var Mage_Customer_Model_Customer $customer */
            $customer = $customerSession->getCustomer();

            return $customer;
        }
    }

}
