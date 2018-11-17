<?php

class USWF_PayPal_Model_Observer
{

    /**
     * fix Orders without an email address(PayPal)
     *
     * @param Varien_Event_Observer $observer
     */
    public function salesOrderLoadAfter(Varien_Event_Observer $observer)
    {
        $_order = $observer->getOrder();
        if (!$_order->getCustomerEmail()) {
            $payment = $_order->getPayment();
            switch ($payment->getMethod()) {
                case 'amazon_payments':
                    $_order->setCustomerEmail($payment->getAdditionalInformation('amazon_payer_email'));
                    break;
                case 'paypal_express':
                    $_order->setCustomerEmail($payment->getAdditionalInformation('paypal_payer_email'));
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * fix Orders without an email address(Amazon)
     *
     * @param Varien_Event_Observer $observer
     */
    public function salesQuotePaymentImportDataBefore(Varien_Event_Observer $observer)
    {
        $_data = $observer->getInput();
        if ($_data->getMethod() == 'amazon_payments') {
            $email = Mage::getSingleton('customer/session')->getCustomer()->getEmail();
            $additionalInformation = $_data->getAdditionalInformation();
            $additionalInformation['amazon_payer_email'] = $email;
            $_data->setAdditionalInformation($additionalInformation);
        }
    }

    /**
     * fix Orders without an email address(Amazon)
     *
     * @param Varien_Event_Observer $observer
     */
    public function paymentInfoBlockPrepareSpecificInformation(Varien_Event_Observer $observer)
    {
        $_transport = $observer->getTransport();
        $_payment = $observer->getPayment();
        if ($_payment->getMethod() == 'amazon_payments' && $_payment->getAdditionalInformation('amazon_payer_email')) {
            $_transport->addData(array(Mage::helper('paypal')->__('Payer Email') => $_payment->getAdditionalInformation('amazon_payer_email')));
        }
    }

}
