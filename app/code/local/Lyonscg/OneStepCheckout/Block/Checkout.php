<?php

class Lyonscg_OneStepCheckout_Block_Checkout extends Idev_OneStepCheckout_Block_Checkout
{
    public function _handlePostData()
    {
        $post = $this->getRequest()->getPost();

        if (!$post) {
            return;
        }

        $this->_maybeClearPersistentSession();

        return parent::_handlePostData();
    }

    /**
     * If user has a persistent session ongoing, clear it and make it so it's like a guest session.  This prevents some
     * weird issues that arise when using OneStepCheckout with a persistent session.
     */
    protected function _maybeClearPersistentSession()
    {
        if (!Mage::helper('persistent/session')->isPersistent()) {
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