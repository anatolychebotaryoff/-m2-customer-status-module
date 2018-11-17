<?php
/**
 * StoreFront CyberSource Tokenized Payment Extension for Magento
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of StoreFront Consulting, Inc.
 *
 * @category  SFC
 * @package   SFC_CyberSource
 * @author    Garth Brantley <garth@storefrontconsulting.com>
 * @copyright 2009-2013 StoreFront Consulting, Inc. All Rights Reserved.
 * @license   http://www.storefrontconsulting.com/media/downloads/ExtensionLicense.pdf StoreFront Consulting Commercial License
 * @link      http://www.storefrontconsulting.com/cybersource-saved-credit-cards-extension-for-magento/
 *
 */

/**
 * Observer class to handle all event observers for module
 */
class SFC_CyberSource_Model_Observer
{

    public function onSalesConvertQuotePaymentToOrderPayment(Varien_Event_Observer $observer)
    {
        Mage::log('SFC_CyberSource_Model_Observer::onSalesConvertQuotePaymentToOrderPayment', Zend_Log::INFO,
            SFC_CyberSource_Helper_Data::LOG_FILE);

        // Get payments from observer
        /** @var Sales_Model_Order_Payment $orderPayment */
        $orderPayment = $observer->getData('order_payment');
        /** @var Sales_Model_Order_Payment $quotePayment */
        $quotePayment = $observer->getData('quote_payment');

        // Check payment method
        // For this payment method, check as normal
        if (0 === strpos($quotePayment->getData('method'), SFC_CyberSource_Model_Method::METHOD_CODE)) {
            // Set shortened method code on order payment record
            // We only need the extended version on quote payment
            $orderPayment->setData('method', SFC_CyberSource_Model_Method::METHOD_CODE);
        }

        // Manually copy over cybersource_token field, as this doesn't seem to propagate
        $orderPayment->setData('cybersource_token', $quotePayment->getData('cybersource_token'));

    }

}

