<?php
/**
 * Rewrite SFC_Autoship_Block_Checkout_Onepage_Payment_Methods
 *
 * @category  Lyons
 * @package   Lyonscg_Autoship
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_Autoship_Block_Checkout_Onepage_Payment_Methods extends SFC_Autoship_Block_Checkout_Onepage_Payment_Methods
{
    /**
     * @var bool Variable to store if products have subscription products
     */
    protected $_hasProductsToCreateNewSubscription = true;

    /**
     * Check and prepare payment method model
     *
     * @param $method
     * @return bool
     */
    protected function _canUseMethod($method)
    {
        // Check config to see if extension functionality is enabled
        if (Mage::getStoreConfig('autoship_general/general/enabled') != '1') {
            return Mage_Checkout_Block_Onepage_Payment_Methods::_canUseMethod($method);
        }

        // Check if New Subscription page is enabled, or if we should create subscriptions in checkout
        if(Mage::getStoreConfig('autoship_subscription/subscription/use_new_subscription_page') == '1') {
            return Mage_Checkout_Block_Onepage_Payment_Methods::_canUseMethod($method);
        }
        else {
            // We should create subs during checkout, and we are checking a payment method other than Authorize.Net CIM
            // If other payment method being used, only allow this when there are no subscriptions to create
            // Get quote helper
            /** @var SFC_Autoship_Helper_Quote $quoteHelper */
            $quoteHelper = Mage::helper('autoship/quote');
            // Check if quote has any subscriptions in it
            if(!$this->_hasProductsToCreateNewSubscription || !$quoteHelper->hasProductsToCreateNewSubscription()) {
                $this->_hasProductsToCreateNewSubscription = false;
                // Quote has no subscriptions, go through normal qualification process for payment methods
                return Mage_Checkout_Block_Onepage_Payment_Methods::_canUseMethod($method);
            }
            else {
                // Quote has subscriptions, only allow payment methods compatible with subscriptions
                // Get helper
                /** @var SFC_Autoship_Helper_Platform $platformHelper */
                $platformHelper = Mage::helper('autoship/platform');
                // Lookup payment method code based on SP config
                $configuredMethodCode = $platformHelper->getConfiguredPaymentMethodCode();
                // Check for configured payment method code
                if(0 === strpos($method->getCode(), $configuredMethodCode)) {
                    // This is the pay method which is allowed by Subscribe Pro config
                    // Run normal check
                    return Mage_Checkout_Block_Onepage_Payment_Methods::_canUseMethod($method);
                }
                else {
                    // This is some other payment method, not allowed when checking out and creating subscriptions
                    return false;
                }

            }
        }
    }
}
