<?php
/**
 * Session.php
 *
 * @category    USWF
 * @package     SWF_CrossCart
 * @copyright
 * @author
 */
class USWF_CrossCart_Model_Checkout_Session extends Mage_Checkout_Model_Session
{
    /**
     * Get checkout quote instance by current session
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {

        if ( Mage::app()->getRequest()->getPathInfo() == '/customer/account/logoutSuccess/' || 
            Mage::app()->getRequest()->getPathInfo() == '/checkout/onepage/success/' ) {
            $this->setQuoteId(null);
            Mage::helper('uswf_crosscart')->unsPersistentQuoteId();
            return Mage::getModel('sales/quote');
        }


        Mage::dispatchEvent('custom_quote_process', array('checkout_session' => $this));

        if ($this->_quote === null) {
            /** @var $quote Mage_Sales_Model_Quote */
            $quote = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore()->getId());
            /**  @var USWF_CrossCart_Helper_Data $helper */
            $helper = Mage::helper('uswf_crosscart');

            /**
             * Try to use persistent quote_id from cookie
             */
            $persistentQuoteId = $helper->getPersistentQuoteId();
            if (!$this->getQuoteId() && $persistentQuoteId) {
                $session = Mage::getSingleton('customer/session');
                $customerId = $session->setCustomerId(null);
                Mage::getModel('core/cookie')->delete('CUSTOMER');
                $this->_customer = null;
                $oldQuote = Mage::getModel('sales/quote')->load($persistentQuoteId);
                $quote->merge($oldQuote); 
                $quote->setCustomerId(null);
                $quote->collectTotals()->save();
                $this->setQuoteId($quote->getId());
            }
            
            if ($this->getQuoteId()) {
                if ($this->_loadInactive) {
                    $quote->load($this->getQuoteId());
                } else {
                    $quote->loadActive($this->getQuoteId());
                }
                if ($quote->getId()) {
                    /**
                     * If current currency code of quote is not equal current currency code of store,
                     * need recalculate totals of quote. It is possible if customer use currency switcher or
                     * store switcher.
                     */
                    if ($quote->getQuoteCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                        $quote->setStore(Mage::app()->getStore());
                        $quote->collectTotals()->save();
                        /*
                         * We mast to create new quote object, because collectTotals()
                         * can to create links with other objects.
                         */
                        $quote = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore()->getId());
                        $quote->load($this->getQuoteId());
                    }
                    /*
                     * If quote is present and has items, then set it to persistent cookie
                     */
                    if ($persistentQuoteId != $quote->getId() && $quote->hasItems()) {
                        $helper->setPersistentQuoteId($quote->getId());
                    }
                } else {
                    $this->setQuoteId(null);
                    $helper->unsPersistentQuoteId();
                }
            }

            $customerSession = Mage::getSingleton('customer/session');

            if (!$this->getQuoteId()) {
                if ($customerSession->isLoggedIn() || $this->_customer) {
                    $customer = ($this->_customer) ? $this->_customer : $customerSession->getCustomer();
                    $quote->loadByCustomer($customer);
                    $this->setQuoteId($quote->getId());
                    /*
                    * If quote is present and has items, then set it to persistent cookie
                    */
                    if ($persistentQuoteId != $quote->getId() && $quote->hasItems()) {
                        $helper->setPersistentQuoteId($quote->getId());
                    }
                } else {
                    $quote->setIsCheckoutCart(true);
                    Mage::dispatchEvent('checkout_quote_init', array('quote'=>$quote));
                }
            }

            if ($this->getQuoteId()) {
                if ($customerSession->isLoggedIn() || $this->_customer) {
                    $customer = ($this->_customer) ? $this->_customer : $customerSession->getCustomer();
                    $quote->setCustomer($customer);
                }
            }

            $quote->setStore(Mage::app()->getStore());
            $this->_quote = $quote;
        }

        if ($remoteAddr = Mage::helper('core/http')->getRemoteAddr()) {
            $this->_quote->setRemoteIp($remoteAddr);
            $xForwardIp = Mage::app()->getRequest()->getServer('HTTP_X_FORWARDED_FOR');
            $this->_quote->setXForwardedFor($xForwardIp);
        }
        return $this->_quote;
    }
}
