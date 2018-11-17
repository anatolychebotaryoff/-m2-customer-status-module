<?php
/**
 * Rewrite Mage_Checkout_OnepageController
 *
 * @category   Lyons
 * @package    Lyonscg_Checkout
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Lyonscg_Checkout_OnepageController extends Mage_Checkout_OnepageController
{
    /**
     * Overwritten to check if items can be shipped to current state
     *
     * Shipping address save action
     */
    public function saveShippingAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping', array());
            $customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);
            $result = $this->getOnepage()->saveShipping($data, $customerAddressId);

            // First check if the saveShipping passes then check item is allowed to ship to state
            if (!isset($result['error'])) {
                $regionId = $this->getOnePage()->getQuote()->getShippingAddress()->getRegionId();
                $regionId = $this->displayNotRequiredStateEnabled($regionId);
                $result = Mage::helper('lyonscg_checkout')->checkItems($regionId);

                // Append Google Analytics Step Call for enhanced Ecommerce
                $appendGA = <<<GACODE
<script type="text/javascript">
    try {
        ga('ec:setAction','checkout', {'step': 3});

        ga('send', 'pageview');
    } catch (e) {}

</script>
GACODE;
;

                if (!isset($result['error'])) {
                    $result['goto_section'] = 'shipping_method';
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml() . $appendGA
                    );
                }
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * save checkout billing address
     */
    public function saveBillingAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
//            $postData = $this->getRequest()->getPost('billing', array());
//            $data = $this->_filterPostData($postData);
            $data = $this->getRequest()->getPost('billing', array());
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

            if (isset($data['email'])) {
                $data['email'] = trim($data['email']);
            }

            $customerEmail = empty($data['email']) ? $this->getOnepage()->getQuote()->getCustomerEmail() : $data['email'];

            // Check if email address is set and throw error if not
            if (empty($customerEmail)) {
                $result = array('error' => -1, 'message' => Mage::helper('checkout')->__('Email address must be set.'));
            } else {
                $result = $this->getOnepage()->saveBilling($data, $customerAddressId);
            }

            if (!isset($result['error'])) {
                /* check quote for virtual */
                if ($this->getOnepage()->getQuote()->isVirtual()) {
                    $result['goto_section'] = 'payment';
                    $result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
                    );
                } elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
                    $regionId = $this->getOnePage()->getQuote()->getBillingAddress()->getRegionId();
                    $regionId = $this->displayNotRequiredStateEnabled($regionId);
                    $result = Mage::helper('lyonscg_checkout')->checkItems($regionId);

                    if (!isset($result['error'])) {

                        // Append Google Analytics Step Call for enhanced Ecommerce
                        $appendGA = <<<GACODE
<script type="text/javascript">
    try {
        ga('ec:setAction','checkout', {'step': 3});

        ga('send', 'pageview');
    } catch (e) {}
</script>
GACODE;
;

                        $result['goto_section'] = 'shipping_method';
                        $result['update_section'] = array(
                            'name' => 'shipping-method',
                            'html' => $this->_getShippingMethodsHtml() . $appendGA
                        );

                        $result['allow_sections'] = array('shipping');
                        $result['duplicateBillingInfo'] = 'true';
                    }
                } else {
                    $result['goto_section'] = 'shipping';
                }
            }

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * Shipping method save action
     */
    public function saveShippingMethodAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping_method', '');
            $result = $this->getOnepage()->saveShippingMethod($data);
            /*
            $result will have erro data if shipping method is empty
            */
            if(!$result) {
                Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
                    array('request'=>$this->getRequest(),
                        'quote'=>$this->getOnepage()->getQuote()));
                $this->getOnepage()->getQuote()->collectTotals();
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

                // Append Google Analytics Step Call for enhanced Ecommerce
                $appendGA = <<<GACODE
<script type="text/javascript">
    try {
        ga('ec:setAction','checkout', {'step': 4});

        ga('send', 'pageview');
    } catch (e) {}
</script>
GACODE;
;

                $result['goto_section'] = 'payment';
                $result['update_section'] = array(
                    'name' => 'payment-method',
                    'html' => $this->_getPaymentMethodsHtml() . $appendGA
                );
            }
            $this->getOnepage()->getQuote()->collectTotals()->save();
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * Save payment ajax action
     *
     * Sets either redirect or a JSON response
     */
    public function savePaymentAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        try {
            if (!$this->getRequest()->isPost()) {
                $this->_ajaxRedirectResponse();
                return;
            }

            // set payment to quote
            $result = array();
            $data = $this->getRequest()->getPost('payment', array());
            $result = $this->getOnepage()->savePayment($data);

            // get section and redirect data
            $redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();
            if (empty($result['error']) && !$redirectUrl) {

                // Append Google Analytics Step Call for enhanced Ecommerce
                $appendGA = <<<GACODE
<script type="text/javascript">
    try {
        ga('ec:setAction','checkout', {'step': 5});

        ga('send', 'pageview');
    } catch (e) {}
</script>
GACODE;
;

                $this->loadLayout('checkout_onepage_review');
                $result['goto_section'] = 'review';
                $result['update_section'] = array(
                    'name' => 'review',
                    'html' => $this->_getReviewHtml() . $appendGA
                );
            }
            if ($redirectUrl) {
                $result['redirect'] = $redirectUrl;
            }
        } catch (Mage_Payment_Exception $e) {
            if ($e->getFields()) {
                $result['fields'] = $e->getFields();
            }
            $result['error'] = $e->getMessage();
        } catch (Mage_Core_Exception $e) {
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            Mage::logException($e);
            $result['error'] = $this->__('Unable to set Payment Method.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * @param $regionId
     * @return int
     *
     * The function checks if state is not entered and whether general/region/display_all is enabled in store config
     * Depending from parameters above function can return $regionId(integer/null) or -1(not empty)
     *
     */
    public function displayNotRequiredStateEnabled($regionId){
        $configData = Mage::getStoreConfig('general/region/display_all');
        if(($regionId === null) && $configData){
            $regionId = -1;
        }
        return $regionId;
    }
}
