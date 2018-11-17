<?php
/**
 * Lyonscg Persistent Guest Checkout
 *
 * @category    Lyonscg
 * @package     Lyonscg_PersistentGuestCheckout
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (http://www.lyonscg.com)
 * @author      Nick Hughart (nhughart@lyonscg.com)
 */

class Lyonscg_PersistentGuestCheckout_Model_Observer
{
    function beforeSaveMethod(Varien_Event_Observer $observer)
    {
        // Check for persistent session
        if (!Mage::helper('persistent/session')->isPersistent()) {
            return;
        }

        /** @var Mage_Core_Controller_Varien_Action $controller */
        $controller = $observer->getControllerAction();
        $method = $controller->getRequest()->getParam('method');
        if (!$method || ($method != 'guest')) {
            return;
        }

        // Check for valid quote
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if (!$quote || !$quote->getId()) {
            return;
        }

        /** @var Mage_Customer_Model_Customer $customer */
        $customer = Mage::helper('persistent/session')->getCustomer();

        // Delete persistent session along with it's cookie
        Mage::helper('persistent/session')->getSession()->delete();

        // Clear customer information from customer session.
        Mage::getSingleton('customer/session')->setCustomerId(null)->setCustomerGroupId(null);

        // Adjust quote so that it's a guest quote instead of a customer quote.
        $quote
            ->setIsActive(true)
            ->setIsPersistent(false)
            ->setCustomer(Mage::getModel('customer/customer'))  // Have to use an empty customer, null causes error
            ->setCustomerId(null)
            ->setCustomerEmail($customer->getEmail())
            ->setCustomerFirstname($customer->getFirstname())
            ->setCustomerLastname($customer->getLastname())
            ->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID)
            ->removeAllAddresses()
            ->save();

        // Update checkout session with the new quote.
        $quoteId = $quote->getId();
        Mage::getSingleton('checkout/session')->clear();
        Mage::getSingleton('checkout/session')->setCustomer(null);
        Mage::getSingleton('checkout/session')->setQuoteId($quoteId);
    }
}