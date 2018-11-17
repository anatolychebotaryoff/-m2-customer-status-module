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

/**
 * This class wraps the CyberSource API
 *
 */
class SFC_CyberSource_Helper_Gateway_Api extends Mage_Core_Helper_Abstract
{

    const WSDL_URL_TEST = 'https://ics2wstesta.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.67.wsdl';
    const WSDL_URL_LIVE = 'https://ics2wsa.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.67.wsdl';

    /** @var Mage_Core_Model_Website */
    private $_website = null;

    /**
     * Set the primary key id of the website to use for all configuration scope
     *
     * @param int $websiteId Primary key id of the website to use
     */
    public function setConfigWebsite($websiteId)
    {
        $this->_website = Mage::app()->getWebsite($websiteId);
    }

    /**
     * Return the website to use for pulling configuration settings
     *
     * @return Mage_Core_Model_Website|null
     */
    public function getConfigWebsite()
    {
        return $this->_website;
    }

    /**
     * Lookup up configuration setting, considering the configured configuration website id.
     *
     * @param string $configPath Path of the config setting to lookup
     * @return mixed
     */
    public function getConfig($configPath)
    {
        // Use website to get configuration
        $storeId = null;
        if ($this->getConfigWebsite() != null) {
            $storeId = $this->getConfigWebsite()->getDefaultGroup()->getDefaultStoreId();
        }
        // Lookup config setting
        $value = Mage::getStoreConfig($configPath, $storeId);

        // Return config setting value
        return $value;
    }

    /**
     * Lookup up payment method configuration setting, considering the configured configuration website id.
     *
     * @param string $relativeConfigPath Path of the config setting, relative to payment method
     * @return mixed
     */
    public function getMethodConfig($relativeConfigPath)
    {
        // Get payment method configuration
        return $this->getConfig('payment/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/' . $relativeConfigPath);
    }

    public function isTestMode()
    {
        // Lookup test mode setting
        $testMode = $this->getMethodConfig('test');

        return ($testMode == true);
    }

    protected function getMerchantId()
    {
        /** @var Mage_Core_Helper_Data $coreHelper */
        $coreHelper = Mage::helper('core');

        // Look up config
        $merchantId = $this->isTestMode() ? $this->getMethodConfig('test_merchant_id') : $this->getMethodConfig('merchant_id');
        $merchantId = $coreHelper->decrypt(trim($merchantId));

        return $merchantId;
    }

    protected function getSecurityKey()
    {
        /** @var Mage_Core_Helper_Data $coreHelper */
        $coreHelper = Mage::helper('core');

        // Look up config
        $securityKey = $this->isTestMode() ? $this->getMethodConfig('test_security_key') : $this->getMethodConfig('security_key');
        $securityKey = $coreHelper->decrypt(trim($securityKey));

        return $securityKey;
    }

    protected function getWsdl()
    {
        return $this->isTestMode() ? self::WSDL_URL_TEST : self::WSDL_URL_LIVE;
    }

    public function createRequest()
    {
        // Create new object
        $request = new stdClass();

        // Add standard fields to request
        $request->merchantID = $this->getMerchantId();
        // To help us troubleshoot any problems that you may encounter,
        // please include the following information about your PHP application.
        $request->clientLibrary = 'PHP';
        $request->clientLibraryVersion = phpversion();
        $request->clientEnvironment = php_uname();

        return $request;
    }

    public function sendRequest($request)
    {
        try {
            Mage::log('Sending CyberSource request: ', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
            $this->logRequestInfo($request);

            // Create SoapClient
            $soapClient = new SFC_CyberSource_Model_Api_ExtendedSoapClient(
                $this->getWsdl(),
                array(),
                $this->getMerchantId(),
                $this->getSecurityKey());
            // Run transaction (call runTransaction method on API)
            $response = $soapClient->runTransaction($request);
            // Log response
            $this->logResponseInfo($response);
            // Check response
            if ($response == null ||
                $response->decision != "ACCEPT" ||
                $response->reasonCode != 100 ||
                (isset($response->SOAPFault) && $response->SOAPFault != '')
            ) {
                // Build error detail string
                $errorDetailString =
                    'Decision: ' .  $response->decision . "\n" .
                    'Reason Code: ' .  $response->reasonCode . "\n" .
                    'Raw Response: ' . "\n" . json_encode($response) . "\n"
                ;
                // Save error details in registry, so we can return it later
                Mage::unregister('subscribepro_transaction_error_detail');
                Mage::register('subscribepro_transaction_error_detail', $errorDetailString);

                // Throw transaction error
                $errorMessage = Mage::helper('sfc_cybersource/gateway_error')->mapErrorResponseToCustomerMessage($response);
                throw new SFC_CyberSource_Helper_Gateway_Exception($errorMessage, $response);
            }
        }
        catch (\SoapFault $sf) {
            Mage::log('SOAP Fault: ' . $sf->getCode(), Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);
            Mage::log('Message: ' . $sf->getMessage(), Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);
            throw $sf;
        }
        catch (\Exception $e) {
            Mage::log('Error: ' . $e->getMessage(), Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);
            throw $e;
        }

        return $response;
    }

    /**
     * Log any useful info in response from CyberSource API request
     */
    public function logRequestInfo($request)
    {
        if ($this->getConfig('dev/log/active') == '1') {
            // Build sanitized request object
            $cleanRequest = unserialize(serialize($request));
            // Now overwrite key fields
            $cleanRequest->merchantID = '***';
            if (isset($cleanRequest->card)) {
                $cleanRequest->card->accountNumber = '*******';
            }
            // Log
            Mage::log($cleanRequest, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        }
    }

    /**
     * Log any useful info in response from CyberSource API response
     */
    public function logResponseInfo($response)
    {
        if ($this->getConfig('dev/log/active') == '1') {
            // Log
            Mage::log('Received CyberSource API Response:', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
            Mage::log($response, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        }
    }

    /**
     * Retrieve customer payment profile from gateway
     */
    public function retrievePaymentProfile($customerId, $paymentToken)
    {
        Mage::log('retrievePaymentProfile called.', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        Mage::log('Customer id: ' . $customerId, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        Mage::log('Payment token: ' . $paymentToken, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        // Build request
        // Create new request object
        $request = $this->createRequest();
        $paySubscriptionRetrieveService = new stdClass();
        $paySubscriptionRetrieveService->run = 'true';
        $request->paySubscriptionRetrieveService = $paySubscriptionRetrieveService;
        // Set ref code and token
        $request->merchantReferenceCode = 'CUST-' . $customerId . '-PROF-' . uniqid();
        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->subscriptionID = $paymentToken;
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        // Send request
        $response = $this->sendRequest($request);

        // Check response
        $validXml =
            property_exists($response, 'paySubscriptionRetrieveReply') && property_exists($response->paySubscriptionRetrieveReply,
                'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to retrieve payment profile!', $response);
        }

        // Return
        return $response->paySubscriptionRetrieveReply;
    }

    /**
     * Retrieve customer payment profile from gateway
     */
    public function retrievePaymentProfileWithMerchantRef($merchantReferenceCode, $paymentToken)
    {
        Mage::log('retrievePaymentProfile called.', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        Mage::log('merchantReferenceCode: ' . $merchantReferenceCode, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        Mage::log('Payment token: ' . $paymentToken, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        // Build request
        // Create new request object
        $request = $this->createRequest();
        $paySubscriptionRetrieveService = new stdClass();
        $paySubscriptionRetrieveService->run = 'true';
        $request->paySubscriptionRetrieveService = $paySubscriptionRetrieveService;
        // Set ref code and token
        $request->merchantReferenceCode = $merchantReferenceCode;
        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->subscriptionID = $paymentToken;
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        // Send request
        $response = $this->sendRequest($request);

        // Check response
        $validXml =
            property_exists($response, 'paySubscriptionRetrieveReply') && property_exists($response->paySubscriptionRetrieveReply,
                'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to retrieve payment profile!', $response);
        }

        // Return
        return $response->paySubscriptionRetrieveReply;
    }

    /**
     * Delete an existing customer payment profile on gateway
     *
     */
    public function deletePaymentProfile($customerId, $paymentToken)
    {
        // Log
        Mage::log('deletePaymentProfile called.', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        Mage::log('Customer id: ' . $customerId, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        Mage::log('Payment token: ' . $paymentToken, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        // Build request
        // Create new request object
        $request = $this->createRequest();
        $paySubscriptionDeleteService = new stdClass();
        $paySubscriptionDeleteService->run = 'true';
        $request->paySubscriptionDeleteService = $paySubscriptionDeleteService;
        // Set ref code and token
        $request->merchantReferenceCode = 'CUST-' . $customerId . '-PROF-' . uniqid();
        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->subscriptionID = $paymentToken;
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        // Send request
        $response = $this->sendRequest($request);

        // Check response
        $validXml = property_exists($response, 'paySubscriptionDeleteReply') && property_exists($response->paySubscriptionDeleteReply,
                'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to delete payment profile!', $response);
        }

        // Return
        return;
    }

    protected function cleanPersonName($name)
    {
        // Only allow these chars
        // Customer Name/Suffix/Title,
        // Ship-To Name
        // May start with a letter, number, or question mark (?)
        // Subsequent characters can be any of following:
        // letters
        // numbers
        // question mark (?)
        // dash (-)
        // single quote (')
        // period (.)
        // comma (,)
        // forward slash (/)
        // 'at' sign (@)
        // ampersand (&)
        // parentheses ( or )
        // exclamation point (!)
        // plus sign (+)
        // colon (:)                            (applicable to Ship-To Name)
        $specialChars = preg_quote("?-'.,/@&()!+:", '/');
        $name = preg_replace('/[^A-Za-z0-9' . $specialChars . ']/', '', $name);
        // Replace first char, if it other than letter, num or ?
        $name = preg_replace('/^[^A-Za-z0-9?]+/', '', $name);

        return $name;
    }

    protected function cleanCompanyName($name)
    {
        // Only allow these chars
        // Company Name,
        // Ship-To Company Name
        // May start with a letter, number, or question mark (?)
        // Subsequent characters can be any of the following:
        // letters
        // numbers
        // question mark (?)
        // dash (-)
        // apostrophe (')
        // period (.)
        // comma (,)
        // forward slash (/)
        // 'at' sign (@)
        // ampersand (&)
        // parenthesis ()
        // exclamation point (!)
        // plus sign (+)
        // pound sign (#)
        $specialChars = preg_quote("?-'.,/@&()!+#", '/');
        $name = preg_replace('/[^A-Za-z0-9' . $specialChars . ']/', '', $name);
        // Replace first char, if it other than letter, num or ?
        $name = preg_replace('/^[A-Za-z0-9?]+/', '', $name);

        return $name;
    }

    protected function cleanPhoneNumber($phone)
    {
        // Only allow these chars
        // Company Name,
        // Ship-To Company Name
        // May start with a letter, number, or question mark (?)
        // Subsequent characters can be any of the following:
        // letters
        // numbers
        // dash (-)
        // parenthesis ()
        // plus sign (+)
        // comma (,)
        // asterisk (*)
        // period (.)
        // pound sign (#)
        // forward slash (/)
        $specialChars = preg_quote("-()+,*.#/", '/');
        $phone = preg_replace('/[^A-Za-z0-9' . $specialChars . ']/', '', $phone);

        return $phone;
    }
}
