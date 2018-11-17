<?php
/**
 * Subscribe Pro - Subscriptions Management Extension
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of SUBSCRIBE PRO INC.
 *
 * @category  SFC
 * @package   SFC_Autoship
 * @author    Garth Brantley <garth@subscribepro.com>
 * @copyright 2009-2014 SUBSCRIBE PRO INC. All Rights Reserved.
 * @license   http://www.subscribepro.com/terms-of-service/ Subscribe Pro Terms of Service
 * @link      http://www.subscribepro.com/
 *
 */
/**
 * Shopping cart api for payment
 *
 * Override this class and handle passing existing payment tokens to various payment methods.
 *
 */

class SFC_Autoship_Model_Checkout_Cart_Payment_Api extends Mage_Checkout_Model_Cart_Payment_Api
{
    /**
     * @param  $quoteId
     * @param  $paymentData
     * @param  $store
     * @return bool
     */
    public function setPaymentMethod($quoteId, $paymentData, $store = null)
    {
        // Get quote
        $quote = $this->_getQuote($quoteId, $store);
        if (empty($store)) {
            $store = $quote->getStoreId();
        }

        // Check config to see if extension functionality is enabled
        if (Mage::getStoreConfig('autoship_general/general/enabled', $store) != '1') {
            return parent::setPaymentMethod($quoteId, $paymentData, $store);
        }

        // Handle payment token for Paradox Transarmor payment method
        if($paymentData['method'] == SFC_Autoship_Helper_Platform::PAY_METHOD_CODE_PARADOX_TRANSARMOR) {
            if(isset($paymentData['payment_id'])) {
                $paymentToken = $paymentData['payment_id'];
            }
            else if(isset($paymentData['payment_token'])) {
                $paymentToken = $paymentData['payment_token'];
            }
            // Lookup profile id in Mage DB from token
            $paymentProfile = Mage::getModel('transarmor/card')->getCollection()
                ->addFieldToFilter('trans_id', $paymentToken)
                ->getFirstItem();
            if (!strlen($paymentProfile->getId())) {
                Mage::throwException('Failed to find First Data TransArmor profile with token: ' . $paymentToken);
            }
            // Set payment data field on quote
            $quote->getPayment()->setData('cybersource_token', $paymentProfile->getId());
            $quote->getPayment()->save();
        }

        // Call parent method after adjusting $paymentData array
        return parent::setPaymentMethod($quoteId, $paymentData, $store);
    }

}
