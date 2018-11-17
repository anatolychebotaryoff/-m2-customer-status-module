<?php
/**
 * Lyonscg_PersistentCookie Module to override the default behaviour of not allowing Guest checkout in persistent mode.
 *
 * @category  Lyonscg
 * @package   Lyonscg_Logorderdetails
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author    Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * This observer enables "Guest Checkout" in persistent mode.
 *
 * @category Lyons
 * @package  Lyonscg_Logorderdetails
 */
class Lyonscg_PersistentCookie_Model_Observer extends Mage_Persistent_Model_Observer
{
    /**
     * Enable guest checkout if we are in persistent mode and no subscription products exist in quote
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function disableGuestCheckout($observer)
    {
        // Get data from $observer
        /** @var Mage_Sales_Model_Quote $quote */
        $quote  = $observer->getEvent()->getQuote();
        $result = $observer->getEvent()->getResult();

        if (Mage::getStoreConfig('autoship_general/general/enabled') == '1') {
            // Get quote helper
            /** @var SFC_Autoship_Helper_Quote $quoteHelper */
            $quoteHelper = Mage::helper('autoship/quote');
            // Check if quote has any subscriptions in it
            if($quoteHelper->hasProductsToCreateNewSubscription($quote)) {
                // Quote has subscriptions, disable guest checkout
                $result->setIsAllowed(false);
            } else {
                $result->setIsAllowed(true);
            }
        } else {
            $result->setIsAllowed(true);
        }
    }
}
