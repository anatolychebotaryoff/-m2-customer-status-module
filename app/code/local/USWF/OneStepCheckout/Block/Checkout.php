<?php
/**
 * Checkout.php
 *
 * @category    USWF
 * @package     USWF_OneStepCheckout
 * @copyright
 * @author
 */
class USWF_OneStepCheckout_Block_Checkout extends Idev_OneStepCheckout_Block_Checkout
{

    private function verifyCaptcha($captcha_data)
    {

        if (!$captcha_data) {
            return false;
        }
        
        if ( Mage::getStoreConfig('onestepcheckout/google_recaptcha/google_recaptcha_validateip') &&
             ( !array_key_exists("REMOTE_ADDR", $_SERVER) || !$_SERVER["REMOTE_ADDR"] ) ) {
            return false;
        }

        $url = Mage::getStoreConfig('onestepcheckout/google_recaptcha/google_recaptcha_url');
        $fields = array(
            'secret' => Mage::getStoreConfig('onestepcheckout/google_recaptcha/google_recaptcha_secret'),
            'response' => $captcha_data,
            'remoteip' => $_SERVER["REMOTE_ADDR"],
        );

        if ( Mage::getStoreConfig('onestepcheckout/google_recaptcha/google_recaptcha_validateip')) {
            $fields["remoteip"] = $_SERVER["REMOTE_ADDR"];
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, sizeof($fields));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($curl);

        curl_close($curl);

        return $result;

    }

    public function _handlePostData()
    {
        $this->formErrors = array(
            'billing_errors' => array(),
            'shipping_errors' => array(),
        );

        $post = $this->getRequest()->getPost();

        if(!$post) return;

        // Save billing information
        if( !$this->_isLoggedInWithAddresses() && false) {
            // 392151 - Logging in at one step will cause the initial attempt to buy to fail
            // because logging in will not set up quote addresses, and then when it tries to check for valid
            // shipping methods, it will fail, since there are no addresses to check.
            // force OneStep to go through this logic in order to set up the addresses and such properly.
        }
        else {

            if (Mage::getStoreConfig('onestepcheckout/google_recaptcha/google_recaptcha_enable')) {

                $captcha_data = $this->getRequest()->getPost('g-recaptcha-response');
                $captcha_verify = $this->verifyCaptcha($captcha_data);


                if (!$captcha_verify) {
                    $this->formErrors['captcha_error'] = 'You must complete the reCAPTCHA to place an order';
                    return;
                }

            }

            $checkoutHelper = Mage::helper('onestepcheckout/checkout');

            $payment_data = $this->getRequest()->getPost('payment');

            $billing_data = $this->getRequest()->getPost('billing', array());
            $shipping_data = $this->getRequest()->getPost('shipping', array());

            $billing_data = $checkoutHelper->load_exclude_data($billing_data);
            $shipping_data = $checkoutHelper->load_exclude_data($shipping_data);

            if(!empty($billing_data)){
                $this->getQuote()->getBillingAddress()->addData($billing_data)->implodeStreetAddress();
            }

            if($this->differentShippingAvailable()) {
                $this->getQuote()->getShippingAddress()->setCountryId($shipping_data['country_id'])->setCollectShippingRates(true);
            }

            //handle comments and feedback
            $enableComments = Mage::getStoreConfig('onestepcheckout/exclude_fields/enable_comments');
            $enableCommentsDefault = Mage::getStoreConfig('onestepcheckout/exclude_fields/enable_comments_default');
            $orderComment = $this->getRequest()->getPost('onestepcheckout_comments');
            $orderComment = trim($orderComment);
            if($enableComments && !$enableCommentsDefault) {
                if ($orderComment != ""){
                    $this->getQuote()->setOnestepcheckoutCustomercomment(Mage::helper('core')->escapeHtml($orderComment));
                }
            }

            $enableFeedback = Mage::getStoreConfig('onestepcheckout/feedback/enable_feedback');
            if($enableFeedback){
                $feedbackValues = unserialize(Mage::getStoreConfig('onestepcheckout/feedback/feedback_values'));
                $feedbackValue = $this->getRequest()->getPost('onestepcheckout-feedback');
                $feedbackValueFreetext = $this->getRequest()->getPost('onestepcheckout-feedback-freetext');
                if(!empty($feedbackValue)){
                    if($feedbackValue!='freetext'){
                        $feedbackValue = $feedbackValues[$feedbackValue]['value'];
                    } else {
                        $feedbackValue = $feedbackValueFreetext;
                    }
                    $this->getQuote()->setOnestepcheckoutCustomerfeedback(Mage::helper('core')->escapeHtml($feedbackValue));
                }
            }
            //handle comments and feedback end

            if(isset($billing_data['email']))   {
                $this->email = $billing_data['email'];
            }

            if(!$this->_isLoggedIn()){
                $registration_mode = $this->settings['registration_mode'];
                if($registration_mode == 'auto_generate_account')   {
                    // Modify billing data to contain password also
                    $password = Mage::helper('onestepcheckout/checkout')->generatePassword();
                    $billing_data['customer_password'] = $password;
                    $billing_data['confirm_password'] = $password;
                    $this->getQuote()->getCustomer()->setData('password', $password);
                    $this->getQuote()->setData('password_hash',Mage::getModel('customer/customer')->encryptPassword($password));

                }

                if($registration_mode == 'require_registration' || $registration_mode == 'allow_guest')   {
                    if(!empty($billing_data['customer_password']) && !empty($billing_data['confirm_password']) && ($billing_data['customer_password'] == $billing_data['confirm_password'])){
                        $password = $billing_data['customer_password'];
                        $this->getQuote()->setCheckoutMethod('register');
                        $this->getQuote()->setCustomerId(0);
                        $this->getQuote()->getCustomer()->setData('password', $password);
                        $this->getQuote()->setData('password_hash',Mage::getModel('customer/customer')->encryptPassword($password));
                    }
                }

            }

            if($this->_isLoggedIn() || $registration_mode == 'require_registration' || $registration_mode == 'auto_generate_account' || (!empty($billing_data['customer_password']) && !empty($billing_data['confirm_password']))){
                //handle this as Magento handles subscriptions for registered users (no confirmation ever)
                $subscribe_newsletter = $this->getRequest()->getPost('subscribe_newsletter');
                if(!empty($subscribe_newsletter)){
                    $this->getQuote()->getCustomer()->setIsSubscribed(1);
                }
            }

            $billingAddressId = $this->getRequest()->getPost('billing_address_id');
            $customerAddressId = (!empty($billingAddressId)) ? $billingAddressId : false ;

            if($this->_isLoggedIn()){
                $this->getQuote()->getBillingAddress()->setSaveInAddressBook(empty($billing_data['save_in_address_book']) ? 0 : 1);
                $this->getQuote()->getShippingAddress()->setSaveInAddressBook(empty($shipping_data['save_in_address_book']) ? 0 : 1);
            }

            $result = $this->getOnepage()->saveBilling($billing_data, $customerAddressId);

            if(!empty($billing_data['customer_password']) && !empty($billing_data['confirm_password']))   {
                // Trick to allow saving of
                $this->getOnepage()->saveCheckoutMethod('register');
                $this->getQuote()->setCustomerId(0);
                $customerData = '';
                $tmpBilling = $billing_data;

                if(!empty($tmpBilling['street']) && is_array($tmpBilling['street'])){
                    $tmpBilling ['street'] = '';
                }
                $tmpBData = array();
                foreach($this->getQuote()->getBillingAddress()->implodeStreetAddress()->getData() as $k=>$v){
                    if(!empty($v) && !is_array($v)){
                        $tmpBData[$k]=$v;
                    }
                }
                $customerData= array_intersect($tmpBilling, $tmpBData);

                if(!empty($customerData)){
                    $this->getQuote()->getCustomer()->addData($customerData);
                    foreach($customerData as $key => $value){
                        $this->getQuote()->setData('customer_'.$key, $value);
                    }
                }
            }

            $customerSession = Mage::getSingleton('customer/session');

            if (!empty($billing_data['dob']) && !$customerSession->isLoggedIn()) {
                $dob = Mage::app()->getLocale()->date($billing_data['dob'], null, null, false)->toString('yyyy-MM-dd');
                $this->getQuote()->setCustomerDob($dob);
                $this->getQuote()->setDob($dob);
                $this->getQuote()->getBillingAddress()->setDob($dob);
            }

            if($customerSession->isLoggedIn() && !empty($billing_data['dob'])){
                $dob = Mage::app()->getLocale()->date($billing_data['dob'], null, null, false)->toString('yyyy-MM-dd');
                $customerSession->getCustomer()
                    ->setId($customerSession->getId())
                    ->setWebsiteId($customerSession->getCustomer()->getWebsiteId())
                    ->setEmail($customerSession->getCustomer()->getEmail())
                    ->setDob($dob)
                    ->save()
                ;
            }

            // set customer tax/vat number for further usage
            $taxid = '';
            if(!empty($billing_data['taxvat'])){
                $taxid = $billing_data['taxvat'];
            } else if(!empty($billing_data['vat_id'])){
                $taxid = $billing_data['vat_id'];
            }
            if (!empty($taxid)) {
                $this->getQuote()->setCustomerTaxvat($taxid);
                $this->getQuote()->setTaxvat($taxid);
                $this->getQuote()->getBillingAddress()->setTaxvat($taxid);
                $this->getQuote()->getBillingAddress()->setTaxId($taxid);
                $this->getQuote()->getBillingAddress()->setVatId($taxid);
            }

            if($customerSession->isLoggedIn() && !empty($billing_data['taxvat'])){
                $customerSession->getCustomer()
                    ->setTaxId($billing_data['taxvat'])
                    ->setTaxvat($billing_data['taxvat'])
                    ->setVatId($billing_data['taxvat'])
                    ->save()
                ;
            }

            if(isset($result['error'])) {
                $this->formErrors['billing_error'] = true;
                $this->formErrors['billing_errors'] = $checkoutHelper->_getAddressError($result, $billing_data);
                $this->log[] = 'Error saving billing details: ' . implode(', ', $this->formErrors['billing_errors']);
            } elseif (
                !$this->differentShippingAvailable() ||  
                (isset($billing_data['use_for_shipping']) && $billing_data['use_for_shipping'] == '1')
            ) {
                    $billingAdress = $this->getOnePage()->getQuote()->getBillingAddress();
                    $regionId = $billingAdress->getRegionId();
                    $countryCode = $billingAdress->getCountry();
                    if (Mage::helper('directory')->isRegionRequired($countryCode)) {
                        $result = Mage::helper('lyonscg_checkout')->checkItems($regionId);
                        if (isset($result['error'])) {
                            $this->formErrors['billing_errors'][] = 'region';
                        }
                    }
            }

            // Validate stuff that saveBilling doesn't handle
            if(!$this->_isLoggedIn())   {
                $validator = new Zend_Validate_EmailAddress();
                if(!$billing_data['email'] || $billing_data['email'] == '' || !$validator->isValid($billing_data['email'])) {

                    if(is_array($this->formErrors['billing_errors']))   {
                        $this->formErrors['billing_errors'][] = 'email';
                    }
                    else    {
                        $this->formErrors['billing_errors'] = array('email');
                    }

                    $this->formErrors['billing_error'] = true;

                }
                else    {


                    $allow_guest_create_account_validation = false;

                    if($this->settings['registration_mode'] == 'allow_guest')   {
                        if(isset($_POST['create_account']) && $_POST['create_account'] == '1')  {
                            $allow_guest_create_account_validation = true;
                        }
                    }


                    if($this->settings['registration_mode'] == 'require_registration' || $this->settings['registration_mode'] == 'auto_generate_account' || $allow_guest_create_account_validation)  {
                        if($this->_customerEmailExists($billing_data['email'], Mage::app()->getWebsite()->getId()))   {

                            $allow_without_password = $this->settings['registration_order_without_password'];



                            if(!$allow_without_password)    {
                                if(is_array($this->formErrors['billing_errors']))   {
                                    $this->formErrors['billing_errors'][] = 'email';
                                    $this->formErrors['billing_errors'][] = 'email_registered';
                                }
                                else    {
                                    $this->formErrors['billing_errors'] = array('email','email_registered');
                                }
                            }
                            else    {
                            }
                        }
                        else    {

                            $password_errors = array();

                            if(!isset($billing_data['customer_password']) || $billing_data['customer_password'] == '')    {
                                $password_errors[] = 'password';
                            }

                            if(!isset($billing_data['confirm_password']) || $billing_data['confirm_password'] == '')    {
                                $password_errors[] = 'confirm_password';
                            }
                            else    {
                                if($billing_data['confirm_password'] !== $billing_data['customer_password']) {
                                    $password_errors[] = 'password';
                                    $password_errors[] = 'confirm_password';
                                }
                            }

                            if(count($password_errors) > 0) {
                                if(is_array($this->formErrors['billing_errors']))   {
                                    foreach($password_errors as $error) {
                                        $this->formErrors['billing_errors'][] = $error;
                                    }
                                }
                                else    {
                                    $this->formErrors['billing_errors'] = $password_errors;
                                }
                            }
                        }
                    }


                }
            }

            if($this->settings['enable_terms']) {
                if(!isset($post['accept_terms']) || $post['accept_terms'] != '1')   {
                    $this->formErrors['terms_error'] = true;
                }
            }


            if ($this->settings['enable_default_terms'] && $requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    //$this->formErrors['terms_error'] = $this->__('Please agree to all the terms and conditions before placing the order.');
                    $this->formErrors['agreements_error'] = true;
                }
            }

            $shippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);

            if($this->differentShippingAvailable()) {
                if(!isset($billing_data['use_for_shipping']) || $billing_data['use_for_shipping'] != '1')   {
                    //$shipping_result = $this->getOnepage()->saveShipping($shipping_data, $shippingAddressId);
                    $shipping_result = Mage::helper('onestepcheckout/checkout')->saveShipping($shipping_data, $shippingAddressId);

                    if (!isset($shipping_result['error']))    {
                        $this->formErrors['shipping_error'] = true;
                        $this->formErrors['shipping_errors'] = $checkoutHelper->_getAddressError($shipping_result, $shipping_data, 'shipping');
                        
                        $shippingAddress = $this->getOnePage()->getQuote()->getShippingAddress();
                        $regionId = $shippingAddress->getRegionId();
                        $countryCode = $shippingAddress->getCountry();

                        if (Mage::helper('directory')->isRegionRequired($countryCode)) {
                            $result = Mage::helper('lyonscg_checkout')->checkItems($regionId);
                            if (isset($result['error'])) {
                                $this->formErrors['shipping_errors'][] = 'region';
                            }
                        }
                    }
                }
                else    {
                    //$shipping_result = $this->getOnepage()->saveShipping($billing_data, $shippingAddressId);
                    $shipping_result = Mage::helper('onestepcheckout/checkout')->saveShipping($billing_data, $customerAddressId);
                }
            }
        }

        // Save shipping method
        $shipping_method = $this->getRequest()->getPost('shipping_method', '');

        if(!$this->isVirtual()){
            //additional checks if the rate is indeed available for chosen shippin address
            $availableRates = $this->getAvailableRates($this->getOnepage()->getQuote()->getShippingAddress()->getGroupedAllShippingRates());
            if(empty($shipping_method) || !in_array($shipping_method,$availableRates['codes'])){
                $this->formErrors['shipping_method'] = true;
            } else if (!$this->getOnepage()->getQuote()->getShippingAddress()->getShippingDescription()) {
                if(!empty($availableRates['rates'][$shipping_method])){
                    $rate = $availableRates['rates'][$shipping_method];
                    $shippingDescription = $rate->getCarrierTitle() . ' - ' . $rate->getMethodTitle();
                    $this->getOnepage()->getQuote()->getShippingAddress()->setShippingDescription(trim($shippingDescription, ' -'));
                }
            }
        }

        if(!$this->isVirtual() )  {
            //$result = $this->getOnepage()->saveShippingMethod($shipping_method);
            $result = Mage::helper('onestepcheckout/checkout')->saveShippingMethod($shipping_method);
            if(isset($result['error']))    {
                $this->formErrors['shipping_method'] = true;
            }
            else    {
                Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method', array('request'=>$this->getRequest(), 'quote'=>$this->getOnepage()->getQuote()));
            }
        }




        // Save payment method
        $payment = $this->getRequest()->getPost('payment', array());
        $paymentRedirect = false;

        $payment = $this->filterPaymentData($payment);

        //echo '<pre>' . print_r($_POST,1) . '</pre>';
        //echo '<pre>' . print_r($payment,1) . '</pre>';

        try {
            if(!empty($payment['method']) && $payment['method'] == 'free' && $this->getOnepage()->getQuote()->getGrandTotal() > 0){

                $instance = Mage::helper('payment')->getMethodInstance('free');
                if ($instance->isAvailable($this->getOnepage()->getQuote())) {
                    $instance->setInfoInstance($this->getOnepage()->getQuote()->getPayment());
                    $this->getOnepage()->getQuote()->getPayment()->setMethodInstance($instance);
                }
            }
            //$result = $this->getOnepage()->savePayment($payment);
            $result = Mage::helper('onestepcheckout/checkout')->savePayment($payment);
            $paymentRedirect = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();

        }
        catch (Mage_Payment_Exception $e) {
            if ($e->getFields()) {
                $result['fields'] = $e->getFields();
            }
            $result['error'] = $e->getMessage();
        }
        catch (Exception $e) {
            $result['error'] = $e->getMessage();
        }

        if(isset($result['error'])) {

            if($result['error'] == 'Can not retrieve payment method instance')  {
                $this->formErrors['payment_method'] = true;
            }
            else    {
                $this->formErrors['payment_method_error']  = $result['error'];
            }
        }


        if(!$this->hasFormErrors()) {

            if($this->settings['enable_newsletter']) {
                // Handle newsletter
                $subscribe_newsletter = $this->getRequest()->getPost('subscribe_newsletter');
                $registration_mode = $this->settings['registration_mode'];
                if(!empty($subscribe_newsletter) && ($registration_mode != 'require_registration' && $registration_mode != 'auto_generate_account') && !$this->getRequest()->getPost('create_account'))  {
                    $model = Mage::getModel('newsletter/subscriber');
                    $model->loadByEmail($this->email);
                    if(!$model->isSubscribed()){
                        $model->subscribe($this->email);
                    }
                }
            }

            if($paymentRedirect && $paymentRedirect != '')  {
                $response = Mage::app()->getResponse();
                return $response->setRedirect($paymentRedirect);
            }

            if( $this->_isLoggedIn() )  {
                // User is logged in
                // Place order as registered customer

                $this->_saveOrder();
                $this->log[] = 'Saving order as a logged in customer';

            }
            else    {

                if( $this->_isEmailRegistered() )   {

                    $registration_mode = $this->settings['registration_mode'];
                    $allow_without_password = $this->settings['registration_order_without_password'];

                    if($registration_mode == 'require_registration' || $registration_mode == 'auto_generate_account')   {

                        if($allow_without_password) {

                            // Place order on the emails account without the password
                            $this->setCustomerAfterPlace($this->_getCustomer());

                            $this->getOnepage()->saveCheckoutMethod('guest');
                            $this->_saveOrder();

                        }
                        else    {
                            // This should not happen, because validation should handle it
                            die('Validation did not handle it');
                        }
                    } elseif ($registration_mode == 'allow_guest') {
                        $this->setCustomerAfterPlace($this->_getCustomer());
                        $this->getOnepage()->saveCheckoutMethod('guest');
                        $this->_saveOrder();
                    } else {
                        $this->getOnepage()->saveCheckoutMethod('guest');
                        $this->_saveOrder();
                    }


                    // Place order as customer with same e-mail address
                    $this->log[] = 'Save order on existing account with email address';

                } else {

                    if($this->settings['registration_mode'] == 'require_registration')  {

                        // Save as register
                        $this->log[] = 'Save order as REGISTER';
                        $this->getOnepage()->saveCheckoutMethod('register');
                        $this->getQuote()->setCustomerId(0);
                        $this->_saveOrder();
                    }
                    elseif($this->settings['registration_mode'] == 'allow_guest')   {
                        if(isset($_POST['create_account']) && $_POST['create_account'] == '1')  {
                            $this->getOnepage()->saveCheckoutMethod('register');
                            $this->getQuote()->setCustomerId(0);
                            $this->_saveOrder();
                        }
                        else    {
                            $this->getOnepage()->saveCheckoutMethod('guest');
                            $this->_saveOrder();
                        }
                    }
                    else    {


                        $registration_mode = $this->settings['registration_mode'];

                        if($registration_mode == 'auto_generate_account')   {
                            $this->getOnepage()->saveCheckoutMethod('register');
                            $this->getQuote()->setCustomerId(0);
                            $this->_saveOrder();
                        }
                        else    {
                            $this->getOnepage()->saveCheckoutMethod('guest');
                            $this->_saveOrder();
                        }
                    }
                }
            }
        }
    }

    public function getAddressesHtmlSelect($type)
    {
        if ($this->isCustomerLoggedIn()) {
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value'=>$address->getId(),
                    'label'=>$address->format('oneline')
                );
            }

            $addressId = '';
            if (empty($addressId)) {
                if ($type=='billing') {
                    $address = $this->getCustomer()->getDefaultBillingAddress();
                } else {
                    $address = $this->getCustomer()->getDefaultShippingAddress();
                }
                if ($address) {
                    $addressId = $address->getId();
                }
            }

            if ($type=='billing') {
                $address = $this->getQuote()->getBillingAddress();
            } else {
                $address = $this->getQuote()->getShippingAddress();
            }
            if ($address) {
                $addressIde = $address->getCustomerAddressId();
                if($addressIde){
                    $addressId = $addressIde;
                }
            }

            $select = $this->getLayout()->createBlock('core/html_select')
                ->setName($type.'_address_id')
                ->setId($type.'-address-select')
                ->setClass('address-select validate-region-in-' . $type . '-address')
                ->setExtraParams('onchange="'.$type.'.newAddress(!this.value)"')
                ->setValue($addressId)
                ->setOptions($options);

            $select->addOption('', Mage::helper('checkout')->__('New Address'));

            $isPost = $this->getRequest()->getPost();
            $isPost = (!empty($isPost));
            $selectedValue = $this->getRequest()->getPost('billing_address_id', false);


            if($this->getNewAddressSelectValueOnError($type)){
                $select->setValue('');
            }

            return $select->getHtml();
        }
        return '';
    }
}
