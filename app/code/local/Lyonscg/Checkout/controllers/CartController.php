<?php
/**
 * Override Mage_Checkout_CartController for adding a new action
 *
 * @category   Lyons
 * @package    Lyonscg_Checkout
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
require_once 'Mage/Checkout/controllers/CartController.php';

class Lyonscg_Checkout_CartController extends Mage_Checkout_CartController
{
    /**
     * On proceed to checkout button we need to update cart and then sent to checkout page
     */
    public function updateCheckoutPostAction()
    {
        $this->_updateShoppingCart();

        if(!Mage::helper('onestepcheckout')->isRewriteCheckoutLinksEnabled()) {
            $this->_redirect('checkout/onepage', array('_secure'=>true));
        } else {
            $this->_redirect('onestepcheckout', array('_secure'=>true));
        }

    }
}
