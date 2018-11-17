<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     SWF_CrossCart
 * @copyright
 * @author
 */
class USWF_CrossCart_Model_Observer
{
    /**
     * Renew cookie for persistent quote id
     *
     * @param Varien_Event_Observer $observer
     * @return USWF_CrossCart_Model_Observer
     */
    public function renewCookie($observer) {
        Mage::helper('uswf_crosscart')->renewPersistentQuoteId();
        return $this;
    }

    public function arbitrary($observer) {

        Mage::log("arbitrary function called");

    }

    public function activateCart($observer) {

        $autoCoupon = Mage::app()->getRequest()->getParam('coupon_code');
        $redirectUrl = Mage::app()->getRequest()->getParam('redirect_to') ?: 'checkout/cart';
        $cart_id = Mage::app()->getRequest()->getParam('cart_id');


        $session = Mage::getSingleton('core/session', array('name' => 'frontend'));

        $cart = Mage::getModel('checkout/cart');

        $mergeQuote = Mage::getModel('sales/quote')->load($cart_id);

        if (!$mergeQuote) {

            $session->addError('Unable to get your previous cart.');
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl($redirectUrl));
            return;
        }

        if (!$cart->getItemsCount()) {
            $cart->init();
            $cart->setQuote(Mage::getModel('sales/quote')->load($cart_id));
            $cart->setCouponCode($autoCoupon);
            $cart->getQuote()->setTotalsCollectedFlag(false)->setReservedOrderId(null)->save();
            $session->setCartWasUpdated(true);
            $cart->save();

            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::helper('core/url')->getCurrentUrl() . "&_cartactivated=1" );
            return;

        }

        $cartactivated = Mage::app()->getRequest()->getParam('_cartactivated');

        $cart_id = Mage::app()->getRequest()->getParam('cart_id');
        $quote = $cart->getQuote();

        if ($quote && !$cartactivated) {

            $mergeQuote->setReservedOrderId(null)->save();

	    $quote->merge($mergeQuote);
            $quote->setCouponCode($autoCoupon);
            $quote->setReservedOrderId(null);
            $quote->collectTotals()->save();
            // from Asana: Persistent Cart Token - Remove deletion of cart if token is used.
            // no longer delete old cart
            //$mergeQuote->delete();

        }

        Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl($redirectUrl));

    }


}
