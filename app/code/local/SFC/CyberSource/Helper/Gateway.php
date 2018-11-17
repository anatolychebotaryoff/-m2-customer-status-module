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
 * Main class to abstract calls to CyberSource SOAP API
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class SFC_CyberSource_Helper_Gateway extends SFC_CyberSource_Helper_Gateway_Api
{
    /**
     * Constants
     */
    // Credit Card Number Mask
    const CC_MASK = 'XXXX';

    public function createPaymentProfileFromPayment(Varien_Object $payment)
    {
        Mage::log('createPaymentProfileFromPayment called.', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        // Build request
        $request = $this->buildSubscriptionRequestFromPayment($payment);

        // Send request
        $response = $this->sendRequest($request);

        // Check response
        $validXml = property_exists($response, 'paySubscriptionCreateReply') && property_exists($response->paySubscriptionCreateReply,
                'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create payment profile!', $response);
        }

        // Get token
        $paymentToken = $response->paySubscriptionCreateReply->subscriptionID;

        // Return token
        return $paymentToken;
    }

    public function createPaymentProfileFromData($data)
    {
        Mage::log('createPaymentProfileFromData called.', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        // Build request
        $request = $this->buildSubscriptionCreateServiceRequestFromData($data);
        // Send request
        $response = $this->sendRequest($request);

        // Check response
        $validXml = property_exists($response, 'paySubscriptionCreateReply') && property_exists($response->paySubscriptionCreateReply,
                'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create payment profile!', $response);
        }

        // Get token
        $paymentToken = $response->paySubscriptionCreateReply->subscriptionID;

        // Return token
        return $paymentToken;
    }

    public function retrievePaymentProfileAsData($customerId, $paymentToken)
    {
        Mage::log('retrievePaymentProfileAsData called.', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        // Get profile data
        $paymentProfile = $this->retrievePaymentProfile($customerId, $paymentToken);

        // Map xml object to array
        $data = array();
        $data['customer_cardnumber'] = (string)$paymentProfile->cardAccountNumber;
        $data['cc_exp_month'] = (string)$paymentProfile->cardExpirationMonth;
        $data['cc_exp_year'] = (string)$paymentProfile->cardExpirationYear;
        $data['cc_type'] = $this->mapCyberSourceCardTypeToMagento($paymentProfile->cardType);
        $data['customer_fname'] = $paymentProfile->firstName;
        $data['customer_lname'] = $paymentProfile->lastName;
        $data['street1'] = (string)$paymentProfile->street1;
        if (isset($paymentProfile->street2)) {
            $data['street2'] = (string)$paymentProfile->street2;
        }
        $data['city'] = (string)$paymentProfile->city;
        $data['region'] = (string)$paymentProfile->state;
        $data['postcode'] = (string)$paymentProfile->postalCode;
        $data['country_id'] = (string)$paymentProfile->country;
        $data['telephone'] = (string)$paymentProfile->phoneNumber;
        $data['email'] = (string)$paymentProfile->email;

        // Return data array
        return $data;
    }

    public function updatePaymentProfileFromData($paymentToken, $data)
    {
        Mage::log('updatePaymentProfileFromData called.', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        // Build request
        $request = $this->buildSubscriptionUpdateServiceRequestFromData($paymentToken, $data);
        // Send request
        $response = $this->sendRequest($request);

        // Check response
        $validXml = property_exists($response, 'paySubscriptionUpdateReply') && property_exists($response->paySubscriptionUpdateReply,
                'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create payment profile!', $response);
        }

        // Return
        return;
    }

    public function createAuthAndCaptureTransactionFromPayment(Varien_Object $payment, $amount)
    {
        // Get info from $payment
        $paymentToken = $payment->getAdditionalInformation('payment_token');
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();

        // Create new request object
        $request = $this->createRequest();

        // Generate unique id for this payment profile
        $request->merchantReferenceCode = 'ORD-' . $order->getIncrementId();

        $ccAuthService = new stdClass();
        $ccAuthService->run = 'true';
        $request->ccAuthService = $ccAuthService;
        $ccCaptureService = new stdClass();
        $ccCaptureService->run = 'true';
        $request->ccCaptureService = $ccCaptureService;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $order->getData('base_currency_code');
        $purchaseTotals->grandTotalAmount = $amount;
        $request->purchaseTotals = $purchaseTotals;

        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->subscriptionID = $paymentToken;
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        // Add AVS setting from config
        $businessRules = new stdClass();
        if ($this->getMethodConfig('ignore_avs') == '1') {
            $businessRules->ignoreAVSResult = 'true';
        }
        else {
            $businessRules->ignoreAVSResult = 'false';
        }
        if (strlen($this->getMethodConfig('decline_avs_flags'))) {
            $businessRules->declineAVSFlags = $this->getMethodConfig('decline_avs_flags');
        }
        $request->businessRules = $businessRules;

        // Add CV code if available
        $card = new stdClass();
        if (strlen($payment->getData('cc_cid'))) {
            $card->cvIndicator = '1';
            $card->cvNumber = $payment->getData('cc_cid');
        }
        else {
            $card->cvIndicator = '0';
        }
        $request->card = $card;

        // Add order detail
        $this->addOrderDetailToRequest($request, $order);

        Mage::dispatchEvent('sfc_cybersource_before_auth_and_capture_request',
            array('payment' => $payment, 'request' => $request));

        // Send request
        $response = $this->sendRequest($request);

        Mage::dispatchEvent('sfc_cybersource_after_auth_and_capture_request',
            array('payment' => $payment, 'request' => $request, 'response' => $response));

        // Check response
        $validXml = property_exists($response, 'ccAuthReply') && property_exists($response->ccAuthReply, 'reasonCode') &&
            property_exists($response, 'ccCaptureReply') && property_exists($response->ccCaptureReply, 'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create transaction!', $response);
        }

        return $response;
    }

    public function createAuthOnlyTransactionFromPayment(Varien_Object $payment, $amount)
    {
        // Get info from $payment
        $paymentToken = $payment->getAdditionalInformation('payment_token');
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();

        // Create new request object
        $request = $this->createRequest();

        // Generate unique id for this payment profile
        $request->merchantReferenceCode = 'ORD-' . $order->getIncrementId() . '-AUTH';

        $ccAuthService = new stdClass();
        $ccAuthService->run = 'true';
        $request->ccAuthService = $ccAuthService;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $order->getData('base_currency_code');
        $purchaseTotals->grandTotalAmount = $amount;
        $request->purchaseTotals = $purchaseTotals;

        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->subscriptionID = $paymentToken;
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        // Add AVS setting from config
        $businessRules = new stdClass();
        if ($this->getMethodConfig('ignore_avs') == '1') {
            $businessRules->ignoreAVSResult = 'true';
        }
        else {
            $businessRules->ignoreAVSResult = 'false';
        }
        if (strlen($this->getMethodConfig('decline_avs_flags'))) {
            $businessRules->declineAVSFlags = $this->getMethodConfig('decline_avs_flags');
        }
        $request->businessRules = $businessRules;

        // Add CV code if available
        $card = new stdClass();
        if (strlen($payment->getData('cc_cid'))) {
            $card->cvIndicator = '1';
            $card->cvNumber = $payment->getData('cc_cid');
        }
        else {
            $card->cvIndicator = '0';
        }
        $request->card = $card;

        // Add order detail
        $this->addOrderDetailToRequest($request, $order);

        Mage::dispatchEvent('sfc_cybersource_before_auth_only_request',
            array('payment' => $payment, 'request' => $request));

        // Send request
        $response = $this->sendRequest($request);

        Mage::dispatchEvent('sfc_cybersource_after_auth_only_request',
            array('payment' => $payment, 'request' => $request, 'response' => $response));

        // Check response
        $validXml = property_exists($response, 'ccAuthReply') && property_exists($response->ccAuthReply, 'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create transaction!', $response);
        }

        return $response;
    }

    public function createPriorAuthCaptureTransactionFromPayment(Varien_Object $payment, $amount)
    {
        // Get info from $payment
        $paymentToken = $payment->getAdditionalInformation('payment_token');
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();

        // Create new request object
        $request = $this->createRequest();

        // Generate unique id for this payment profile
        $request->merchantReferenceCode = 'ORD-' . $order->getIncrementId() . '-CAPTURE';

        $ccCaptureService = new stdClass();
        $ccCaptureService->run = 'true';
        $ccCaptureService->authRequestID = $payment->getCcTransId();
        $request->ccCaptureService = $ccCaptureService;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $order->getData('base_currency_code');
        $purchaseTotals->grandTotalAmount = $amount;
        $request->purchaseTotals = $purchaseTotals;

        // Add order detail
        $this->addOrderDetailToRequest($request, $order);

        Mage::dispatchEvent('sfc_cybersource_before_prior_auth_capture_request',
            array('payment' => $payment, 'request' => $request));

        // Send request
        $response = $this->sendRequest($request);

        Mage::dispatchEvent('sfc_cybersource_after_prior_auth_capture_request',
            array('payment' => $payment, 'request' => $request, 'response' => $response));

        // Check response
        $validXml = property_exists($response, 'ccCaptureReply') && property_exists($response->ccCaptureReply, 'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create transaction!', $response);
        }

        return $response;
    }

    public function createAuthReversalTransaction($requestId, $requestToken, $currencyCode, $amount)
    {
        // Create new request object
        $request = $this->createRequest();

        // Generate unique id for this payment profile
        $request->merchantReferenceCode = 'AUTH-REVERSE-' . $requestId;

        $ccAuthReversalService = new stdClass();
        $ccAuthReversalService->run = 'true';
        $ccAuthReversalService->authRequestToken = $requestToken;
        $request->ccAuthReversalService = $ccAuthReversalService;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $currencyCode;
        $purchaseTotals->grandTotalAmount = $amount;
        $request->purchaseTotals = $purchaseTotals;

        // Send request
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
        $validXml = property_exists($response, 'ccAuthReversalReply') && property_exists($response->ccAuthReversalReply, 'reasonCode') && ($response->reasonCode == 100 || $response->reasonCode == 243);
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create auth reversal transaction!', $response);
        }
        if($response->reasonCode == 243) {
            Mage::log("CyberSource responded 243, which means the transaction was already reversed. Order has been canceled.", Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        }

        return $response;
    }

    public function createCreditTransaction($requestId, $requestToken, $currencyCode, $amount)
    {
        // Create new request object
        $request = $this->createRequest();

        // Generate unique id for this payment profile
        $request->merchantReferenceCode = 'CREDIT-' . $requestId;

        $ccCreditService = new stdClass();
        $ccCreditService->run = 'true';
        $ccCreditService->captureRequestID = $requestId;
        $ccCreditService->captureRequestToken = $requestToken;
        $request->ccCreditService = $ccCreditService;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $currencyCode;
        $purchaseTotals->grandTotalAmount = $amount;
        $request->purchaseTotals = $purchaseTotals;

        // Send request
        $response = $this->sendRequest($request);

        // Check response
        $validXml = property_exists($response, 'ccCreditReply') && property_exists($response->ccCreditReply, 'reasonCode');
        if (!$validXml) {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Failed to create credit transaction!', $response);
        }

        return $response;
    }

    protected function buildSubscriptionRequestFromData($data)
    {
        // Create new request object
        $request = $this->createRequest();

        // Generate unique id for this payment profile
        $request->merchantReferenceCode = 'CUST-' . $data['customer_id'] . '-PROF-' . uniqid();

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $this->getMethodConfig('currency');
        $request->purchaseTotals = $purchaseTotals;

        $billTo = new stdClass();
        $billTo->customerID = $data['customer_id'];
        $billTo->ipAddress = $data['ip_address'];
        $billTo->firstName = $this->cleanPersonName($data['customer_fname']);
        $billTo->lastName = $this->cleanPersonName($data['customer_lname']);
        $billTo->street1 = $data['street1'];
        $billTo->street2 = $data['street2'];
        $billTo->city = $data['city'];
        $billTo->state = $data['region'];
        $billTo->postalCode = $data['postcode'];
        $billTo->country = $data['country_id'];
        $billTo->email = $data['email'];
        $billTo->phoneNumber = $this->cleanPhoneNumber($data['telephone']);
        $request->billTo = $billTo;

        $card = new stdClass();
        if (false === strpos($data['customer_cardnumber'], SFC_CyberSource_Helper_Gateway::CC_MASK)) {
            $card->accountNumber = $data['customer_cardnumber'];
        }
        $card->expirationMonth = $data['cc_exp_month'];
        $card->expirationYear = $data['cc_exp_year'];
        if (isset($data['cc_cid'])) {
            $card->cvIndicator = '1';
            $card->cvNumber = $data['cc_cid'];
        }
        else {
            $card->cvIndicator = '0';
        }
        $card->cardType = $this->mapMagentoCardTypeToCyberSource($data['cc_type']);
        $request->card = $card;

        $subscription = new stdClass();
        $subscription->title =
            'Magento Customer Id # ' . $data['customer_id'] . ' Saved Card (' . substr($data['customer_cardnumber'], -4) . ')';
        $subscription->paymentMethod = 'credit card';
        $request->subscription = $subscription;

        return $request;
    }

    protected function buildSubscriptionCreateServiceRequestFromData($data)
    {
        // Create new request object and populate create / update common details
        $request = $this->buildSubscriptionRequestFromData($data);

        $paySubscriptionCreateService = new stdClass();
        $paySubscriptionCreateService->run = 'true';
        $request->paySubscriptionCreateService = $paySubscriptionCreateService;

        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->frequency = 'on-demand';
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        // Add AVS setting from config
        $businessRules = new stdClass();
        if ($this->getMethodConfig('ignore_avs') == '1') {
            $businessRules->ignoreAVSResult = 'true';
        }
        else {
            $businessRules->ignoreAVSResult = 'false';
        }
        if (strlen($this->getMethodConfig('decline_avs_flags'))) {
            $businessRules->declineAVSFlags = $this->getMethodConfig('decline_avs_flags');
        }
        $request->businessRules = $businessRules;

        return $request;
    }

    protected function buildSubscriptionUpdateServiceRequestFromData($paymentToken, $data)
    {
        // Create new request object and populate create / update common details
        $request = $this->buildSubscriptionRequestFromData($data);

        $paySubscriptionUpdateService = new stdClass();
        $paySubscriptionUpdateService->run = 'true';
        $request->paySubscriptionUpdateService = $paySubscriptionUpdateService;

        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->subscriptionID = $paymentToken;
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        // Add AVS setting from config
        $businessRules = new stdClass();
        if ($this->getMethodConfig('ignore_avs') == '1') {
            $businessRules->ignoreAVSResult = 'true';
        }
        else {
            $businessRules->ignoreAVSResult = 'false';
        }
        if (strlen($this->getMethodConfig('decline_avs_flags'))) {
            $businessRules->declineAVSFlags = $this->getMethodConfig('decline_avs_flags');
        }
        $request->businessRules = $businessRules;

        return $request;
    }

    protected function buildSubscriptionRequestFromPayment(Varien_Object $payment)
    {
        // Get order, etc from $payment
        /** @var Mage_Sales_Model_Order $order */
        $order = $payment->getOrder();
        /** @var Mage_Customer_Model_Customer $customer */
        $customer = $order->getCustomer();
        $billingAddress = $order->getBillingAddress();

        // Create new request object
        $request = $this->createRequest();

        // Generate unique id for this payment profile
        $request->merchantReferenceCode = 'CUST-' . $customer->getId() . '-PROF-' . uniqid();

        $paySubscriptionCreateService = new stdClass();
        $paySubscriptionCreateService->run = 'true';
        $request->paySubscriptionCreateService = $paySubscriptionCreateService;

        $recurringSubscriptionInfo = new stdClass();
        $recurringSubscriptionInfo->frequency = 'on-demand';
        $request->recurringSubscriptionInfo = $recurringSubscriptionInfo;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = $this->getMethodConfig('currency');
        $request->purchaseTotals = $purchaseTotals;

        $billTo = new stdClass();
        $billTo->customerID = $customer->getId();
        $billTo->ipAddress = $order->getRemoteIp();
        $billTo->firstName = $this->cleanPersonName($billingAddress->getFirstname());
        $billTo->lastName = $this->cleanPersonName($billingAddress->getLastname());
        $billTo->street1 = $billingAddress->getStreet1();
        $billTo->street2 = $billingAddress->getStreet2();
        $billTo->city = $billingAddress->getCity();
        $billTo->state = $billingAddress->getRegion();
        $billTo->postalCode = $billingAddress->getPostcode();
        $billTo->country = $billingAddress->getCountryId();
        // Get customer email address from order
        // We know this will work in all situations: guest checkout, registering customer when checkout and already registered customer
        $billTo->email = $order->getCustomerEmail();
        $billTo->phoneNumber = $this->cleanPhoneNumber($billingAddress->getTelephone());
        $request->billTo = $billTo;

        $card = new stdClass();
        $card->accountNumber = $payment->getData('cc_number');
        $card->expirationMonth = $payment->getData('cc_exp_month');
        $card->expirationYear = $payment->getData('cc_exp_year');
        if (strlen($payment->getData('cc_cid'))) {
            $card->cvIndicator = '1';
            $card->cvNumber = $payment->getData('cc_cid');
        }
        else {
            $card->cvIndicator = '0';
        }
        $card->cardType = $this->mapMagentoCardTypeToCyberSource($payment->getData('cc_type'));
        $request->card = $card;

        $subscription = new stdClass();
        $subscription->title =
            'Magento Customer Id # ' . $customer->getId() . ' Saved Card (' . substr($payment->getData('cc_number'), -4) . ')';
        $subscription->paymentMethod = 'credit card';
        $request->subscription = $subscription;

        // Add AVS setting from config
        $businessRules = new stdClass();
        if ($this->getMethodConfig('ignore_avs') == '1') {
            $businessRules->ignoreAVSResult = 'true';
        }
        else {
            $businessRules->ignoreAVSResult = 'false';
        }
        if (strlen($this->getMethodConfig('decline_avs_flags'))) {
            $businessRules->declineAVSFlags = $this->getMethodConfig('decline_avs_flags');
        }
        $request->businessRules = $businessRules;

        return $request;
    }

    protected function addOrderDetailToRequest($request, Mage_Sales_Model_Order $order)
    {
        // Add ship to address if appropriate
        if(!$order->getIsVirtual()) {
            $shippingAddress = $order->getShippingAddress();
            $this->addShipToToRequest($request, $order->getCustomerId(), $shippingAddress);
        }
        // Create order items field
        $request->item = array();
        // Add order items
        // Add line item details to transaction
        // Is there a limit like there is with Authorize.Net CIM?
        $lineItemCount = 0;
        /** @var Mage_Sales_Model_Order_Item $curOrderItem */
        foreach ($order->getAllVisibleItems() as $curOrderItem) {
            // Create new line item on transaction
            $lineItem = new \stdClass();
            $lineItem->id = $lineItemCount;
            $lineItem->productCode = 'default';
            $lineItem->productName = substr($curOrderItem->getName(), 0, 255);
            $lineItem->productSKU = substr($curOrderItem->getSku(), 0, 255);
            $lineItem->unitPrice = ($curOrderItem->getPrice() > 0.0 ? $curOrderItem->getPrice() : '0.0');
            $lineItem->taxAmount = ($curOrderItem->getTaxAmount() > 0.0 ? $curOrderItem->getTaxAmount() : '0.0');
            $lineItem->quantity = $curOrderItem->getQtyOrdered();

            // Add this item
            $request->item[] = $lineItem;

            // Increment item count
            $lineItemCount++;
        }
        // Add shipping amount to order details, if > 0.0
        if ($order->getShippingAmount() > 0.0) {
            $shippingLineItem = new \stdClass();
            $shippingLineItem->id = $lineItemCount;
            $shippingLineItem->productCode = 'shipping_and_handling';
            $shippingLineItem->unitPrice = ($order->getShippingAmount() > 0.0 ? $order->getShippingAmount() : '0.0');
            // Add this item
            $request->item[] = $shippingLineItem;
            // Increment item count
            $lineItemCount++;
        }
        // Add device fingerprint id (which is our session id), for fraud prevention
        // This session id will match that which is passed to tracking pixel in checkout
        /** @var SFC_CyberSource_Model_Session $cybersourceSession */
        $cybersourceSession = Mage::getSingleton('sfc_cybersource/session');
        $request->deviceFingerprintID = $cybersourceSession->getSessionId();
    }

    protected function addShipToToRequest($request, $customerId, Mage_Customer_Model_Address_Abstract $customerAddress)
    {
        $shipTo = new stdClass();
        $shipTo->customerID = $customerId;
        $shipTo->firstName = $this->cleanPersonName($customerAddress->getFirstname());
        $shipTo->lastName = $this->cleanPersonName($customerAddress->getLastname());
        $shipTo->street1 = $customerAddress->getStreet1();
        $shipTo->street2 = $customerAddress->getStreet2();
        $shipTo->city = $customerAddress->getCity();
        $shipTo->state = $customerAddress->getRegion();
        $shipTo->postalCode = $customerAddress->getPostcode();
        $shipTo->country = $customerAddress->getCountryId();
        $shipTo->email = $customerAddress->getEmail();
        $shipTo->phoneNumber = $this->cleanPhoneNumber($customerAddress->getTelephone());
        $request->shipTo = $shipTo;
    }

    public function mapMagentoCardTypeToCyberSource($type)
    {
        // Map of card types
        $cardTypes = array(
            'VI' => '001',
            'MC' => '002',
            'AE' => '003',
            'DI' => '004',
            'JCB' => '007',
        );

        if (isset($cardTypes[$type])) {
            return $cardTypes[$type];
        }
        else {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Invalid credit card type: ' . $type);
        }
    }

    public function mapCyberSourceCardTypeToMagento($type)
    {
        // Map of card types
        $cardTypes = array(
            '001' => 'VI',
            '002' => 'MC',
            '003' => 'AE',
            '004' => 'DI',
            '007' => 'JCB',
        );

        if (isset($cardTypes[$type])) {
            return $cardTypes[$type];
        }
        else {
            throw new SFC_CyberSource_Helper_Gateway_Exception('Invalid credit card type: ' . $type);
        }
    }

}
