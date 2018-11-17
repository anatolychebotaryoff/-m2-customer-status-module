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
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */

class SFC_CyberSource_Model_Method extends Mage_Payment_Model_Method_Cc
{
    const METHOD_CODE = 'sfc_cybersource';
    const METHOD_CODE_KEY_TOKEN = '_token_';

    /**
     * Payment method code
     */
    protected $_code = self::METHOD_CODE;

    /**
     * Form block type
     */
    protected $_formBlockType = 'sfc_cybersource/cim_form_cc';

    /**
     * Info block type
     */
    protected $_infoBlockType = 'sfc_cybersource/cim_info_cc';

    /**
     * Availability options
     */
    protected $_isGateway = true;
    protected $_canAuthorize = true;
    protected $_canCapture = true;
    protected $_canCapturePartial = false;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = true;
    protected $_canVoid = true;
    protected $_canUseInternal = true;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = true;
    protected $_canSaveCc = false;
    protected $_canFetchTransactionInfo = true;

    /**
     * Members to hold saved card instance data     *
     */
    protected $_savedPaymentToken = null;
    protected $_savedCcLastDigits = null;
    protected $_savedCcType = null;

    /**
     * Turn this method instance into a method representing once particular saved card / profile
     */
    public function setSavedProfile($paymentToken)
    {
        // Lookup payment profile
        // Payment profile exists, lets lookup the Id
        /** @var SFC_CyberSource_Model_payment_profile $profile */
        $profile = Mage::getModel('sfc_cybersource/payment_profile')->getCollection()
            ->addFieldToFilter('payment_token', $paymentToken)
            ->getFirstItem();
        if (strlen($profile->getId())) {
            // Save profile id
            $this->_savedPaymentToken = $paymentToken;
            // Save additional information about payment profile
            $this->_savedCcLastDigits = substr($profile->getData('customer_cardnumber'), -4);
            // Save CC type
            $this->_savedCcType = $profile->getData('cc_type');
        }
    }

    /**
     * Retrieve payment method title
     *
     * @return string
     */
    public function getTitle()
    {
        // If this is a saved card instance, title is saved card last digits
        if (strlen($this->_savedPaymentToken)) {
            return 'Use my Saved Credit Card (' . substr($this->_savedCcLastDigits, -4) . ')';
        }
        // If this is the admin panel, let set a standard title
        if (Mage::app()->getStore()->isAdmin()) {
            return 'Add Card (CyberSource by StoreFront Consulting)';
        }
        else {
            return $this->getConfigData('title');
        }
    }

    /**
     * Retrieve payment method code
     *
     * @return string
     */
    public function getCode()
    {
        if (empty($this->_code)) {
            Mage::throwException(Mage::helper('payment')->__('Cannot retrieve the payment method code.'));
        }
        if (strlen($this->_savedPaymentToken)) {
            return self::METHOD_CODE . SFC_CyberSource_Model_Method::METHOD_CODE_KEY_TOKEN . $this->_savedPaymentToken;
        }
        else {
            return $this->_code;
        }
    }

    /**
     * Retrieve block type for method form generation
     *
     * @return string
     */
    public function getFormBlockType()
    {
        if (strlen($this->_savedPaymentToken)) {
            return 'sfc_cybersource/cim_form_cc_saved';
        }
        else {
            return parent::getFormBlockType();
        }
    }

    /**
     * Retrieve information from payment configuration
     *
     * @param string $field
     * @param int|string|null|Mage_Core_Model_Store $storeId
     *
     * @return mixed
     */
    public function getConfigData($field, $storeId = null)
    {
        if (null === $storeId) {
            $storeId = $this->getStore();
        }
        $path = 'payment/' . self::METHOD_CODE . '/' . $field;

        return Mage::getStoreConfig($path, $storeId);
    }

    /**
     * Assign data to info model instance
     *
     * @param   mixed $data
     * @return  $this
     */
    public function assignData($data)
    {
        // Get Mage_Payment_Model_Info instance from quote
        $info = $this->getInfoInstance();

        // Clear existing payment details from payment row
        $info->setData('cc_type', null);
        $info->setData('cc_number', null);
        $info->setData('cc_last4', null);
        $info->setData('cybersource_token', null);
        $info->setAdditionalInformation('payment_token', null);
        $info->setAdditionalInformation('saved_cc_last_4', null);

        // Call parent assignData
        parent::assignData($data);

        // Assign payment info data from savedCim* members
        if (strlen($this->_savedPaymentToken)) {
            $info->setAdditionalInformation('payment_token', $this->_savedPaymentToken);
            $info->setAdditionalInformation('saved_cc_last_4', substr($this->_savedCcLastDigits, -4));
            $info->setData('cc_number', SFC_CyberSource_Helper_Gateway::CC_MASK . substr($this->_savedCcLastDigits, -4));
            $info->setData('cc_last4', substr($this->_savedCcLastDigits, -4));
            $info->setData('cc_type', $this->_savedCcType);
            $info->setData('cybersource_token', $this->_savedPaymentToken);
        }
        // Assign payment token if 'cybersource_token' field is set in data.... ie when its coming from Mage cart API
        else if (strlen($data['cybersource_token'])) {
            $info->setAdditionalInformation('payment_token', $data['cybersource_token']);
            $info->setAdditionalInformation('saved_cc_last_4', substr($data['saved_cc_last_4'], -4));
            $info->setData('cc_number', SFC_CyberSource_Helper_Gateway::CC_MASK . substr($data['saved_cc_last_4'], -4));
            $info->setData('cc_last4', substr($data['saved_cc_last_4'], -4));
            //$info->setData('cc_type', $this->_savedCcType);
            $info->setData('cybersource_token', $data['cybersource_token']);
        }

        // Save Save Card flag in additional info
        if (isset($data['save_card'])) {
            $info->setAdditionalInformation('save_card', $data['save_card']);
        }

        return $this;
    }

    /**
     * Check whether payment method can be used
     *
     * @param Mage_Sales_Model_Quote|null $quote
     *
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        // If $quote object not populated, call parent method
        if ($quote == null) {
            // Call parent
            return parent::isAvailable($quote);
        }
        // Check the checkout method selected and look for guest checkout
        if ($quote != null && $quote->getCheckoutMethod() == Mage_Checkout_Model_Type_Onepage::METHOD_GUEST) {
            // Check configuration settings
            if (Mage::getStoreConfig('payment/' . self::METHOD_CODE . '/allow_guest_checkout') == '1') {
                // Guest checkout option is enabled, call parent method to see if payment method is available
                return parent::isAvailable($quote);
            }
            else {
                // return No for guest checkout situation when guest checkout option disabled
                return false;
            }
        }

        // Look for a blank checkout method - This can occur with the OneStepCheckout extension and possibly other checkout extensions
        // This code was specifically put in place to make it easy to use extension with OSC without modifying extension
        /*
        if ($quote != null && $quote->getCheckoutMethod() == '') {
            // Say method is not available in this situation, where checkout method is blank
            return false;
        }
        */

        // If all else fails, call the parent method
        return parent::isAvailable($quote);
    }

    public function hasVerification()
    {
        // Always ignore verification code in admin ordering
        if (Mage::app()->getStore()->isAdmin()) {
            return false;
        }
        else {
            return parent::hasVerification();
        }
    }

    /**
     * Validate payment method information object
     *
     * @return $this
     */
    public function validate()
    {
        $info = $this->getInfoInstance();
        if (strlen($this->_savedPaymentToken) || strlen($info->getAdditionalInformation('payment_token'))) {
            return true;
        }
        else {
            return parent::validate();
        }
    }

    /**
     * Send authorize request to gateway
     *
     * @param Mage_Payment_Model_Info|\Varien_Object $payment
     * @param  float $amount
     * @return $this
     */
    public function authorize(Varien_Object $payment, $amount)
    {
        // Log
        Mage::log('====== SFC_CyberSource_Model_Method::authorize called ======', Zend_Log::INFO,
            SFC_CyberSource_Helper_Data::LOG_FILE);

        if ($amount <= 0) {
            Mage::throwException(Mage::helper('sfc_cybersource')->__('Invalid amount for authorization.'));
        }

        // Get order, etc from $payment
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();
        /** @var Mage_Customer_Model_Customer $customer */
        $customer = $order->getCustomer();

        // Use API to create an send auth request
        $paymentToken = $this->_createCustomerPaymentProfile($payment);

        /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
        $gatewayHelper = Mage::helper('sfc_cybersource/gateway');
        $gatewayHelper->setConfigWebsite($customer->getWebsiteId());
        // Use API to create a new auth only transaction
        $response = $gatewayHelper->createAuthOnlyTransactionFromPayment($payment, $amount);
        $transactionId = $response->requestID;

        // Save transaction details in $payment
        $payment
            ->setIsTransactionClosed(0)
            ->setCcTransId($transactionId)
            ->setTransactionId($transactionId)
            //->setAdditionalInformation('cavv_response', $result['transactionResponse']->cavv_response)
            ->setAdditionalInformation('authorization_code', $response->ccAuthReply->authorizationCode)
            ->setAdditionalInformation('payment_action', $this->getConfigData('payment_action'))
            ->setAdditionalInformation('payment_token', $paymentToken)
            ->setAdditionalInformation('request_id', $response->requestID)
            ->setAdditionalInformation('request_token', $response->requestToken)
            // Save additional response info
            ->setAdditionalInformation('decision', $response->decision)
            ->setAdditionalInformation('reason_code', $response->reasonCode)
            ->setAdditionalInformation('avs_code', $response->ccAuthReply->avsCode)
            ->setAdditionalInformation('avs_code_raw', $response->ccAuthReply->avsCodeRaw)
        ;
        /*
        // Create transaction
        // Magento seems to be creating this transaction already
        // $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_AUTH);
        */

        // Now, depending on configuration, use API to delete profiles we created
        if ($this->shouldDeletePayProfileAfterTransaction($order)) {
            $gatewayHelper->deletePaymentProfile($customer->getId(), $paymentToken);
        }

        return $this;
    }

    /**
     * Send capture request to gateway
     *
     * @param Mage_Payment_Model_Info|\Varien_Object $payment
     * @param float $amount
     * @return $this
     */
    public function capture(Varien_Object $payment, $amount)
    {
        // Log
        Mage::log('====== SFC_CyberSource_Model_Method::capture called ======', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        if ($amount <= 0) {
            Mage::throwException(Mage::helper('sfc_cybersource')->__('Invalid amount for capture.'));
        }

        // Check if we're doing an auth n capture transaction or if we are just capturing and already auth'd transaction
        // Look for a value in cc_trans_id and also that the saved payment_action was 'authorize'
        if (strlen($payment->getData('cc_trans_id')) > 0 && $payment->getAdditionalInformation('payment_action') == 'authorize') {
            /*
             * We are doing PriorAuthCapture here...
             */

            /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
            $gatewayHelper = Mage::helper('sfc_cybersource/gateway');
            $websiteId = Mage::app()->getStore($payment->getOrder()->getStoreId())->getWebsiteId();
            $gatewayHelper->setConfigWebsite($websiteId);

            // Use API to create a new prior auth-capture transaction
            $response = $gatewayHelper->createPriorAuthCaptureTransactionFromPayment($payment, $amount);
            $transactionId = $response->requestID;

            // Save transaction details in $payment
            $payment
                ->setIsTransactionClosed(0)
                ->setParentTransactionId($payment->getData('cc_trans_id'))
                ->setCcTransId($transactionId)
                ->setTransactionId($transactionId)//->setAdditionalInformation('cavv_response', $result['transactionResponse']->cavv_response)
                ->setAdditionalInformation('request_id', $response->requestID)
                ->setAdditionalInformation('request_token', $response->requestToken)
            ;
            // Create transaction
            $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE);
        }
        else {
            /*
             * We are doing AuthCapture here...
             */

            // Get order, etc from $payment
            /** @var Mage_Sales_Model_Order $order */
            $order = $payment->getOrder();
            /** @var Mage_Customer_Model_Customer $customer */
            $customer = $order->getCustomer();

            /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
            $gatewayHelper = Mage::helper('sfc_cybersource/gateway');
            $gatewayHelper->setConfigWebsite($customer->getData('website_id'));

            // Create customer and payment profiles or lookup existing profiles
            $paymentToken = $this->_createCustomerPaymentProfile($payment);

            // Use API to create a new auth & capture transaction
            $response = $gatewayHelper->createAuthAndCaptureTransactionFromPayment($payment, $amount);
            $transactionId = $response->requestID;

            // Save transaction details in $payment
            $payment
                ->setIsTransactionClosed(0)
                ->setCcTransId($transactionId)
                ->setTransactionId($transactionId)
                //->setAdditionalInformation('cavv_response', $result['transactionResponse']->cavv_response)
                ->setAdditionalInformation('authorization_code', $response->ccAuthReply->authorizationCode)
                ->setAdditionalInformation('payment_action', $this->getConfigData('payment_action'))
                ->setAdditionalInformation('payment_token', $paymentToken)
                ->setAdditionalInformation('request_id', $response->requestID)
                ->setAdditionalInformation('request_token', $response->requestToken)
                // Save additional response info
                ->setAdditionalInformation('decision', $response->decision)
                ->setAdditionalInformation('reason_code', $response->reasonCode)
                ->setAdditionalInformation('avs_code', $response->ccAuthReply->avsCode)
                ->setAdditionalInformation('avs_code_raw', $response->ccAuthReply->avsCodeRaw)
            ;
            // Create transaction
            $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_CAPTURE);

            // Now, depending on configuration, use API to delete profiles we created
            if ($this->shouldDeletePayProfileAfterTransaction($order)) {
                $gatewayHelper->deletePaymentProfile($customer->getId(), $paymentToken);
            }

        }

        return $this;
    }

    /**
     * Void the payment through gateway
     *
     * @param Mage_Payment_Model_Info|\Varien_Object $payment
     * @return $this
     */
    public function void(Varien_Object $payment)
    {
        // Log
        Mage::log('====== SFC_CyberSource_Model_Method::void called ======', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
        $gatewayHelper = Mage::helper('sfc_cybersource/gateway');
        $websiteId = Mage::app()->getStore($payment->getOrder()->getStoreId())->getWebsiteId();
        $gatewayHelper->setConfigWebsite($websiteId);

        // Use API to create a new void transaction
        $response = $gatewayHelper->createAuthReversalTransaction(
            $payment->getAdditionalInformation('request_id'),
            $payment->getAdditionalInformation('request_token'),
            $payment->getOrder()->getBaseCurrencyCode(),
            $payment->getData('base_amount_authorized'));
        $transactionId = $response->requestID;

        // Save transaction details in $payment
        // Field cc_trans_id in payment should hold the single authorize trans id and then the single capture trans id
        // (or just the single auth n capture trans id)
        $payment
            ->setIsTransactionClosed(1)
            ->setShouldCloseParentTransaction(1)
            ->setParentTransactionId($payment->getData('cc_trans_id'))
            ->setTransactionId($transactionId . '-void');
        // Create transaction
        $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_VOID);
        // This seems to be necessary to keep 1.5.1.x and 1.10.1.x from duplicating the void transaction
        $payment->setSkipTransactionCreation(true);

        return $this;
    }

    /**
     * Cancel the payment through gateway
     *
     * @param Mage_Payment_Model_Info|\Varien_Object $payment
     * @return $this
     */
    public function cancel(Varien_Object $payment)
    {
        // Log
        Mage::log('====== SFC_CyberSource_Model_Method::cancel called ======', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        return $this->void($payment);
    }

    /**
     * Refund the amount with transaction id
     *
     * @param Mage_Payment_Model_Info|\Varien_Object $payment
     * @param float $requestedAmount
     * @return $this
     */
    public function refund(Varien_Object $payment, $requestedAmount)
    {
        // Log
        Mage::log('====== SFC_CyberSource_Model_Method::refund called ======', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
        $gatewayHelper = Mage::helper('sfc_cybersource/gateway');
        $websiteId = Mage::app()->getStore($payment->getOrder()->getStoreId())->getWebsiteId();
        $gatewayHelper->setConfigWebsite($websiteId);

        // Use API to create a new refund transaction
        $response = $gatewayHelper->createCreditTransaction(
            $payment->getAdditionalInformation('request_id'),
            $payment->getAdditionalInformation('request_token'),
            $payment->getOrder()->getBaseCurrencyCode(),
            $requestedAmount);
        $transactionId = $response->requestID;

        /**
         * Duplicate logic from standard Authorize.net payment method:
         *  '   If it is last amount for refund, transaction with type 'capture' will be closed
         *      and card will has last transaction with type 'refund'
         *  '
         * This means that we should close the parent capture transaction if we have refunded the full amount of capture
         */
        $shouldCloseCaptureTransaction = 0;
        if ($this->_formatAmount($payment->getAmountPaid() - $payment->getAmountRefunded()) == $this->_formatAmount($requestedAmount)) {
            $shouldCloseCaptureTransaction = 1;
        }

        // Save transaction details in $payment
        // Field cc_trans_id in payment should hold the single authorize trans id and then the single capture trans id
        // (or just the single auth n capture trans id)
        $payment
            ->setIsTransactionClosed(1)
            ->setShouldCloseParentTransaction($shouldCloseCaptureTransaction)
            ->setParentTransactionId($payment->getData('cc_trans_id'))
            ->setTransactionId($transactionId . '-refund');
        // This seems to be necessary to keep 1.5.1.x and 1.10.1.x from causing "transaction already closed" error on 1.5.1.x and 1.10.1.x
        $payment->setSkipTransactionCreation(true);
        // Create transaction
        $payment->addTransaction(Mage_Sales_Model_Order_Payment_Transaction::TYPE_REFUND);

        return $this;
    }

    /**
     * Create a new profile on gateway
     *
     * @param Mage_Payment_Model_Info|\Varien_Object $payment
     */
    protected function _createCustomerPaymentProfile(Varien_Object $payment)
    {
        // Log
        Mage::log('_createCustomerPaymentProfile()', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        try {
            // Get order, etc from $payment
            /** @var Mage_Sales_Model_Order $order */
            $order = $payment->getOrder();
            /** @var Mage_Customer_Model_Customer $customer */
            $customer = $order->getCustomer();

            /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
            $gatewayHelper = Mage::helper('sfc_cybersource/gateway');
            $gatewayHelper->setConfigWebsite($customer->getData('website_id'));

            // Get customer session
            /** @var Mage_Customer_Model_Session $customerSession */
            $customerSession = Mage::getSingleton('customer/session');

            // Check if customer using existing payment profile
            if (strlen($payment->getAdditionalInformation('payment_token')) > 0) {
                $paymentToken = $payment->getAdditionalInformation('payment_token');
                // Using existing payment profile, update billing address on profile
                $this->_updateBillingAddressAndFetchExpDate($paymentToken, $payment);
            }
            else {
                if (strlen(Mage::registry('created_payment_token'))) {
                    // This must be multi-address checkout and payment profile id was stored in registry on 1st go round
                    // Log
                    Mage::log('Payment profile created on previous order in multi-address checkout.', Zend_Log::INFO,
                        SFC_CyberSource_Helper_Data::LOG_FILE);
                    // Get payment token from registry
                    $paymentToken = Mage::registry('created_payment_token');
                    // Save addition info on payment
                    $payment->setData('cybersource_token', $paymentToken);
                    $payment->setAdditionalInformation('payment_token', $paymentToken);
                    $payment->setAdditionalInformation('saved_cc_last_4', $payment->getData('cc_last4'));
                }
                else {
                    // Create a new payment profile for customer
                    $paymentToken = $gatewayHelper->createPaymentProfileFromPayment($payment);
                    // Save token in Mage pay profile
                    $this->_createNewMagentoPaymentProfile($paymentToken, $payment);
                    // Save created profile ids in session
                    $customerSession->setData('created_payment_token', $paymentToken);
                    // Save created profile in registry
                    Mage::register('created_payment_token', $paymentToken);
                    // Save addition info on payment
                    $payment->setData('cybersource_token', $paymentToken);
                    $payment->setAdditionalInformation('payment_token', $paymentToken);
                    $payment->setAdditionalInformation('saved_cc_last_4', $payment->getData('cc_last4'));
                }
            }

            return $paymentToken;
        }
        catch (Exception $e) {
            Mage::log('600', null, 'mylogfile.log');
            Mage::log($e->getMessage(), null, 'mylogfile.log');
            // Whatever the exception, put up a generic error message
            Mage::log('Failed to find or save payment profile', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
            Mage::log('Error: ' . $e->getMessage(), Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
            // Throw new exception with generic message
            Mage::throwException(Mage::getStoreConfig('payment/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/default_error'));
        }
    }

    protected function _createNewMagentoPaymentProfile($paymentToken, Varien_Object $payment)
    {
        // Get order, etc from $payment
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();
        /** @var Mage_Customer_Model_Customer $customer */
        $customer = $order->getCustomer();

        // Only do this if order is not for a guest
        if(strlen($customer->getId())) {
            if (Mage::getStoreConfig('payment/' . self::METHOD_CODE . '/checkout_save_card_checkbox') != '1' ||
                $order->getPayment()->getAdditionalInformation('save_card') == '1') {
                // Create profile
                $profile = Mage::getModel('sfc_cybersource/payment_profile');
                $profile->setData('customer_id', $customer->getId());
                $profile->setData('customer_fname', $customer->getData('firstname'));
                $profile->setData('customer_lname', $customer->getData('lastname'));
                $profile->setData('customer_cardnumber', SFC_CyberSource_Helper_Gateway::CC_MASK . $payment->getData('cc_last4'));
                $profile->setData('cc_type', $payment->getData('cc_type'));
                $profile->setData('payment_token', $paymentToken);
                $profile->save();
            }
        }
    }

    protected function _updateBillingAddressAndFetchExpDate($paymentToken, Mage_Payment_Model_Info $payment)
    {
        try {
            // Get order, etc from $payment
            /** @var Mage_Sales_Model_Order $order */
            $order = $payment->getOrder();
            /** @var Mage_Customer_Model_Customer $customer */
            $customer = $order->getCustomer();
            /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
            $gatewayHelper = Mage::helper('sfc_cybersource/gateway');
            $gatewayHelper->setConfigWebsite($customer->getData('website_id'));

            // Lookup payment profile
            // Payment profile exists, lets lookup the Id
            /** @var SFC_CyberSource_Model_Payment_Profile $profile */
            $profile = Mage::getModel('sfc_cybersource/payment_profile')->getCollection()
                ->addFieldToFilter('payment_token', $paymentToken)
                ->getFirstItem();
            if (strlen($profile->getId())) {
                // Found existing profile
                // Retrieve profile from gateway
                $profile->retrieveProfileData();
                // Update billing address
                $orderBillingAddress = $order->getBillingAddress();
                $profile->setBillingAddressFields($orderBillingAddress);
                // Now save the payment profile
                $profile->saveProfileData();
                // Update expiration date on order payment record
                $payment->setData('cc_exp_month', $profile->getData('cc_exp_month'));
                $payment->setData('cc_exp_year', $profile->getData('cc_exp_year'));
                // Also update CC Type
                $payment->setData('cc_type', $profile->getData('cc_type'));
            }
            else {
                // Create a new Magento DB profile, cause there isn't one
                $this->_createNewMagentoPaymentProfile($paymentToken, $payment);
            }
        }
        catch (Exception $e) {
            Mage::log('674', null, 'mylogfile.log');
            Mage::log($e->getMessage(), null, 'mylogfile.log');
            // Whatever the exception, put up a generic error message
            Mage::log('Failed to update billing address!', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
            Mage::log('Error: ' . $e->getMessage(), Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
            // Throw new exception with generic message
            Mage::throwException(Mage::getStoreConfig('payment/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/default_error'));
        }
    }

    /**
     * Round up and cast specified amount to float or string
     *
     * @param string|float $amount
     * @param bool $asFloat
     * @return string|float
     */
    protected function _formatAmount($amount, $asFloat = false)
    {
        $amount = sprintf('%.2F', $amount); // 'f' depends on locale, 'F' doesn't
        return $asFloat ? (float)$amount : $amount;
    }

    protected function shouldDeletePayProfileAfterTransaction($order)
    {
        // Unfortunately, we have to check customer is guest flag as well as customer id
        // This is because in Magento, if checkout is first attempted as guest but fails, then customer decides to register during
        // checkout, customer is guest flag is left set to true
        $isGuestCheckout = $order->getCustomerIsGuest() && !strlen($order->getCustomerId());
        if ($isGuestCheckout) {
            if (Mage::getStoreConfig('payment/' . self::METHOD_CODE . '/guest_checkout_save_profiles') != '1') {
                return true;
            }
        }
        // Check if Save Card checkbox feature is turned on, and customer has cleared the Save Card checkbox
        else if (Mage::getStoreConfig('payment/' . self::METHOD_CODE . '/checkout_save_card_checkbox') == '1') {
            if ($order->getPayment()->getAdditionalInformation('save_card') != '1') {
                return true;
            }
        }

        // Otherwise, return false
        return false;
    }

}
