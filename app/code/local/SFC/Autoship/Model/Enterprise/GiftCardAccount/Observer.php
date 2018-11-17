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
 * @copyright 2009-2016 SUBSCRIBE PRO INC. All Rights Reserved.
 * @license   http://www.subscribepro.com/terms-of-service/ Subscribe Pro Terms of Service
 * @link      http://www.subscribepro.com/
 *
 */

/**
 */
class SFC_Autoship_Model_Enterprise_GiftCardAccount_Observer extends Enterprise_GiftCardAccount_Model_Observer
{

    /**
     * Override Enterprise_GiftCardAccount implementation of this method.  Allow SP Vault payment method
     * in this situation when there is a subscription in cart.
     *
     * Force Zero Subtotal Checkout if the grand total is completely covered by SC and/or GC
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function togglePaymentMethods($observer)
    {
        /** @var SFC_Autoship_Helper_Quote $quoteHelper */
        $quoteHelper = Mage::helper('autoship/quote');

        $quote = $observer->getEvent()->getQuote();
        if (!$quote) {
            return;
        }
        // check if giftcard applied and then try to use free method
        if (!$quote->getGiftCardAccountApplied()) {
            return;
        }
        // disable all payment methods and enable only Zero Subtotal Checkout
        if ($quote->getBaseGrandTotal() == 0 && (float)$quote->getGiftCardsAmountUsed()) {
            $paymentMethod = $observer->getEvent()->getMethodInstance()->getCode();
            $result = $observer->getEvent()->getResult();
            // Don't do this extra check in the case where payment method is SP Vault and subscription is in cart
            if (($quoteHelper->hasProductsToCreateNewSubscription($quote)
                || !$quoteHelper->hasSubscriptionReorderProduct($quote))
                && 0 === strpos($paymentMethod, SFC_Autoship_Helper_Platform::PAY_METHOD_CODE_SUBSCRIBE_PRO_VAULT)
            ) {
                // Don't do extra check
            }
            else {
                // allow customer to place order if grand total is zero
                $result->isAvailable = $paymentMethod === 'free' && empty($result->isDeniedInConfig);
            }
        }
    }

}
