<?php
/**
 * Subscribe Pro - Subscriptions Management Extension
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of SUBSCRIBE PRO INC.
 *
 * @category  SFC
 * @package   SFC_Autoship
 * @author    Garth Brantley <garth@subscribepro.com>
 * @copyright 2009-2016 SUBSCRIBE PRO INC. All Rights Reserved.
 * @license   http://www.subscribepro.com/terms-of-service/ Subscribe Pro Terms of Service
 * @link      http://www.subscribepro.com/
 *
 */

/**
 * Observer class to handle all event observers for subscriptions module Adminhtml area
 */
class SFC_Autoship_Model_Adminhtml_Observer
{

    public function adminhtmlWidgetContainerHtmlBefore($event)
    {
        $block = $event->getBlock();

        // Add Reauthorize button to View Order
        if ($block instanceof Mage_Adminhtml_Block_Sales_Order_View) {
            // Cur order
            /** @var Mage_Sales_Model_Order $order */
            $order = Mage::registry('current_order');
            // Check for SP pay method
            if (0 === strpos($order->getPayment()->getMethod(), SFC_Autoship_Helper_Platform::PAY_METHOD_CODE_SUBSCRIBE_PRO_VAULT)) {
                // Only show for authorize only orders
                /** @var SFC_Autoship_Model_Payment_Method $methodInstance */
                $methodInstance = $order->getPayment()->getMethodInstance();
                if ($methodInstance->canReauthorize($order->getPayment())) {
                    // Only show when the order used a
                    $message = Mage::helper('autoship')->__('Are you sure you want to create a new authorization for this order?');
                    $block->addButton('reauthorize_order_payment', array(
                        'label' => Mage::helper('autoship')->__('Reauthorize'),
                        'onclick' => "confirmSetLocation('{$message}', '{$block->getUrl('adminhtml/sporderpayment/reauthorize')}')",
                        'class' => 'go'
                    ));
                }
            }
        }
    }

}
