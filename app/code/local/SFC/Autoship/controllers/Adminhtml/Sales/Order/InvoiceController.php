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

require_once "Mage/Adminhtml/controllers/Sales/Order/InvoiceController.php";

class SFC_Autoship_Adminhtml_Sales_Order_InvoiceController extends Mage_Adminhtml_Sales_Order_InvoiceController
{

    /**
     * Override - Save invoice
     */
    public function saveAction()
    {
        // Call the parent saveAction()
        parent::saveAction();

        // Lookup order
        $orderId = $this->getRequest()->getParam('order_id');
        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order')->load($orderId);
        $payment = $order->getPayment();

        // Check if automatic reauth of partial capture is turned on?
        if (Mage::getStoreConfig('payment/subscribe_pro/reauthorize_partial_capture', $order->getStore()) == '1') {
            // Check for SP pay method
            if (0 === strpos($payment->getMethod(), SFC_Autoship_Helper_Platform::PAY_METHOD_CODE_SUBSCRIBE_PRO_VAULT)) {
                // Only process for authorize only orders
                /** @var SFC_Autoship_Model_Payment_Method $methodInstance */
                $methodInstance = $payment->getMethodInstance();
                // Check if this order / payment eligible for reauth
                if ($methodInstance->canReauthorize($order->getPayment())) {
                    // Now reauthorize this order
                    Mage::helper('autoship/payment')->reauthorizeOrder($order);
                }
            }
        }
    }

}
