<?php
/**
 * Cart observer on add to cart
 *
 * @category   Lyons
 * @package    Lyonscg_Checkout
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */

class Lyonscg_Checkout_Model_Observer
{
    /**
     * Observer to check item added to cart and display message if customer address matches ship_no_<location> attribute
     */
    public function checkoutCartProductAddAfter($observer)
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $shipping = Mage::getSingleton('customer/session')->getCustomer()->getDefaultShipping();
            $regionId = Mage::getModel('customer/address')->load($shipping)->getRegionId();

            if (empty($regionId)) {
                $billing = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling();
                $regionId = Mage::getModel('customer/address')->load($billing)->getRegionId();
            }

            if ($regionId) {
                $result = Mage::helper('lyonscg_checkout')->checkItems($regionId, $observer->getProduct());
            }

            if (isset($result['error'])) {
                foreach($result['message'] as $message) {
                    Mage::getSingleton('checkout/session')->addNotice($message);
                }
            }
        }
    }

    /**
     * Check if order has email address set and throw error if not set
     *
     * @param $observer
     */
    public function checkEmail($observer)
    {
        $order = $observer->getEvent()->getOrder();

        $customerEmail = $order->getCustomerEmail();

        if (empty($customerEmail)) {
            Mage::throwException(Mage::helper('lyonscg_checkout')->__('Email address is not set.'));
        }
    }
}