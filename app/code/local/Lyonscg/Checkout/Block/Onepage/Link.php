<?php
/**
 * Override Mage_Checkout_Block_Onepage_Link for 'proceed to checkout' button to save form and then go to checkout page
 *
 * @category   Lyons
 * @package    Lyonscg_Checkout
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class Lyonscg_Checkout_Block_Onepage_Link extends Mage_Checkout_Block_Onepage_Link
{
    /**
     * Get Checkout Url
     *
     * @return string
     */
    public function getCheckoutUrl()
    {
        if(!Mage::helper('onestepcheckout')->isRewriteCheckoutLinksEnabled()) {
            return $this->getUrl('checkout/onepage', array('_secure'=>true));
        } else {
            return $this->getUrl('onestepcheckout', array('_secure'=>true));
        }
    }

    /**
     * Get update checkout url
     *
     * @return string
     */
    public function getCheckoutSaveSubmitUrl()
    {
        return $this->getUrl('checkout/cart/updateCheckoutPost');
    }
}
