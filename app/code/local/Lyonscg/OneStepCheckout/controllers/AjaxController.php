<?php
/**
 * Rewrite Idev_OneStepCheckout_AjaxController for coupon code messaging
 *
 * @category  Lyons
 * @package   Lyonscg_OneStepCheckout
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */
require_once 'Idev/OneStepCheckout/controllers/AjaxController.php';

class Lyonscg_OneStepCheckout_AjaxController extends Idev_OneStepCheckout_AjaxController
{
    /**
     * Rewrite to add all ERROR messages to output message
     */
    public function add_couponAction()
    {
        $quote = $this->_getOnepage()->getQuote();
        $couponCode = (string)$this->getRequest()->getParam('code');

        if ($this->getRequest()->getParam('remove') == 1) {
            $couponCode = '';
        }

        $response = array(
            'success' => false,
            'error'=> false,
            'message' => false,
        );

        try {

            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setCouponCode(strlen($couponCode) ? $couponCode : '')
                ->collectTotals()
                ->save();

            if ($couponCode) {
                if ($couponCode == $quote->getCouponCode()) {
                    $response['success'] = true;
                    $response['message'] = $this->__('Coupon code "%s" was applied successfully.', Mage::helper('core')->escapeHtml($couponCode));
                }
                else {
                    $response['success'] = false;
                    $response['error'] = true;

                    // ADDED ALL ERROR MESSAGES TO BE OUTPUT
                    $errorMessages = array();
                    $errorMessages[] = $this->__('Coupon code "%s" is not valid.', Mage::helper('core')->escapeHtml($couponCode));
                    $session = Mage::getSingleton('checkout/session');
                    foreach ($session->getMessages()->getErrors() as $error) {
                        $errorMessages[] = '<br />' . $error->getText();
                    }
                    $response['message'] = implode('', $errorMessages);
                    $session->getMessages()->clear();
                }
            } else {
                $response['success'] = true;
                $response['message'] = $this->__('Coupon code was canceled successfully.');
            }
        }
        catch (Mage_Core_Exception $e) {
            $response['success'] = false;
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }
        catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = true;
            $response['message'] = $this->__('Can not apply coupon code.');
        }

        $html = $this->getLayout()
            ->createBlock('checkout/onepage_shipping_method_available')
            ->setTemplate('onestepcheckout/shipping_method.phtml')
            ->toHtml();

        $response['shipping_method'] = $html;

        $html = $this->getLayout()
            ->createBlock('checkout/onepage_payment_methods','choose-payment-method')
            ->setTemplate('onestepcheckout/payment_method.phtml');

        if(Mage::helper('onestepcheckout')->isEnterprise() && Mage::helper('customer')->isLoggedIn()){

            if (Mage::helper('onestepcheckout')->hasEeCustomerbalanace()) {
                $customerBalanceBlock = $this->getLayout()->createBlock('enterprise_customerbalance/checkout_onepage_payment_additional', 'customerbalance', array(
                    'template' => 'onestepcheckout/customerbalance/payment/additional.phtml'
                ));
                $customerBalanceBlockScripts = $this->getLayout()->createBlock('enterprise_customerbalance/checkout_onepage_payment_additional', 'customerbalance_scripts', array(
                    'template' => 'onestepcheckout/customerbalance/payment/scripts.phtml'
                ));
                $this->getLayout()
                    ->getBlock('choose-payment-method')
                    ->append($customerBalanceBlock)
                    ->append($customerBalanceBlockScripts);
            }

            if (Mage::helper('onestepcheckout')->hasEeRewards()) {
                $rewardPointsBlock = $this->getLayout()->createBlock('enterprise_reward/checkout_payment_additional', 'reward.points', array(
                    'template' => 'onestepcheckout/reward/payment/additional.phtml',
                    'before' => '-'
                ));
                $rewardPointsBlockScripts = $this->getLayout()->createBlock('enterprise_reward/checkout_payment_additional', 'reward.scripts', array(
                    'template' => 'onestepcheckout/reward/payment/scripts.phtml',
                    'after' => '-'
                ));
                $this->getLayout()
                    ->getBlock('choose-payment-method')
                    ->append($rewardPointsBlock)
                    ->append($rewardPointsBlockScripts);
            }

        }

        if (Mage::helper('onestepcheckout')->isEnterprise() && Mage::helper('onestepcheckout')->hasEeGiftcards()) {
            $giftcardScripts = $this->getLayout()->createBlock('enterprise_giftcardaccount/checkout_onepage_payment_additional', 'giftcardaccount_scripts', array(
                'template' => 'onestepcheckout/giftcardaccount/onepage/payment/scripts.phtml'
            ));
            $html->append($giftcardScripts);
        }

        $response['payment_method'] = $html->toHtml();

        // Add updated totals HTML to the output
        $html = $this->getLayout()
            ->createBlock('onestepcheckout/summary')
            ->setTemplate('onestepcheckout/summary.phtml')
            ->toHtml();

        $response['summary'] = $html;

        $this->getResponse()->setBody(Zend_Json::encode($response));
    }
}
