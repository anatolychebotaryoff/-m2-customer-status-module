<?php

/**
 * New cookie for persistent
 *
 * @category USWF
 * @package USWF_OneStepCheckout
 * @author
 */

class USWF_OneStepCheckout_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{

    public function match(Zend_Controller_Request_Http $request)
    {
        if (Mage::helper('persistent')->isEnabled()
            && !$this->_isPersistent()
            && !Mage::getSingleton('customer/session')->isLoggedIn()
            && Mage::getSingleton('checkout/session')->getQuoteId()) {
            $sPersistent = $this->_getPersistentHelper()->getSession();
            $customerEmail = Mage::getSingleton('checkout/session')->getQuote()->getCustomerEmail();
            $validator = new Zend_Validate_EmailAddress();
            if ($validator->isValid($customerEmail)) {
                $customer = Mage::getModel('customer/customer');
                $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
                $customer->loadByEmail($customerEmail);
                $sPersistent->loadByCustomerId($customer->getId());
                Mage::helper('persistent/session')->setSession($sPersistent);

                // Set new cookie
                $persistentLifeTime = Mage::helper('persistent')->getLifeTime();
                if ($sPersistent->getId()) {
                    Mage::getSingleton('core/cookie')->set(
                        Mage_Persistent_Model_Session::COOKIE_NAME,
                        $sPersistent->getKey(),
                        $persistentLifeTime
                    );
                }
            }
        }
    }

    /**
     * Retrieve persistent helper
     *
     * @return Mage_Persistent_Helper_Session
     */
    protected function _getPersistentHelper()
    {
        return Mage::helper('persistent/session');
    }

    /**
     * Check whether persistent mode is running
     *
     * @return bool
     */
    protected function _isPersistent()
    {
        return $this->_getPersistentHelper()->isPersistent();
    }

}