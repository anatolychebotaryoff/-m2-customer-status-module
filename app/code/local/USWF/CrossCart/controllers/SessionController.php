<?php

class USWF_CrossCart_SessionController extends Mage_Core_Controller_Front_Action {

    public function activatecartAction() {

        $autoCoupon = $this->getRequest()->getParam('coupon_code');
        $redirectUrl = $this->getRequest()->getParam('redirect_to') ?: 'checkout/cart';
        $cart_id = $this->getRequest()->getParam('cart_id');

        $session = Mage::getSingleton('core/session', array('name' => 'frontend'));

        $this->removeDisabledItemsFromQuote($cart_id);
        $cart = Mage::getModel('checkout/cart');


        $mergeQuote = Mage::getModel('sales/quote')->load($cart_id);


        if (!$mergeQuote) {

            $session->addError('Unable to get your previous cart.');
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl($redirectUrl))->sendResponse();

        }

        $cartactivated = $this->getRequest()->getParam('_cartactivated');

        if (!$cart->getItemsCount() && !$cartactivated) {
            $cart->init();

            $cart->setQuote(Mage::getModel('sales/quote')->load($cart_id));
            $cart->setCouponCode($autoCoupon);
            $cart->getQuote()->setTotalsCollectedFlag(false)->setReservedOrderId(null)->save();
            $session->setCartWasUpdated(true);
            $cart->save();
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl($redirectUrl) . "&_cartactivated=1" )->sendResponse();
            return;

        }


        $cart_id = $this->getRequest()->getParam('cart_id');
        $quote = $cart->getQuote();

        if ($quote && !$cartactivated) {

            $quote->merge($mergeQuote);
            $quote->setCouponCode($autoCoupon);
            $mergeQuote->setReservedOrderId(null)->save();
            $quote->setReservedOrderId(null);
            $quote->collectTotals()->save();
            // from Asana: Persistent Cart Token - Remove deletion of cart if token is used.
            // no longer delete old cart
            //$mergeQuote->delete();

        }

        Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl($redirectUrl))->sendResponse();

    }

    private function removeDisabledItemsFromQuote($cart_id) {

        $quote = Mage::getModel('sales/quote')->load($cart_id);

        $items = $quote->getAllItems();
        foreach ($items as $item) {

           $itemId = $item->getProductId();
           $itemName = $item->getName();

           $_prod = Mage::getModel('catalog/product');
           $_prod->load($item->getProductId());
           $visibility = $_prod->getVisibility();
           $not_for_sale = $_prod->getNotForSale();

           if ($visibility == 1 || $not_for_sale == 1) {
            $quote->removeItem($item->getId());
            Mage::log('Removed disabled item from cart: ProdID: ' . $itemId .', Visibility: ' . $visibility . ', not_for_sale: ' . $not_for_sale . ', ItemID: ' . $item->getId() , null, 'crosscart.log');
            $quote->collectTotals()->save();

          }

        }

    }

}
