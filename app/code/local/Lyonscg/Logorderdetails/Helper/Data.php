<?php
/**
 * Lyonscg_Logorderdetails module logs specific customer info for further debugging.
 *
 * @category  Lyonscg
 * @package   Lyonscg_Logorderdetails
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author    Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Helper
 *
 * @category Lyons
 * @package  Lyonscg_Logorderdetails
 */
class Lyonscg_Logorderdetails_Helper_Data extends Mage_Core_Helper_Data
{

    /**
     * File name to log customer information.
     * 
     * @var string 
     */
    public $filename = 'lyonscg_logorderdetails_debug';

    /**
     * This method logs customer information which needs to be investigated.
     *
     * @param string $orderId
     * @return void
     */
    public function logOrderInfo($orderId)
    {
        try {
            $customerOrder = Mage::getModel('sales/order')->loadByIncrementId($orderId);
            $customerInfo = Mage::getModel('customer/group')->load($customerOrder->getCustomerGroupId());

            $this->filename .= '_' . date("Y-m") . '.log';

            Mage::log('*************************************************************' . PHP_EOL
                    . 'CUSTOMER NAME: ' . $customerOrder->getCustomerName() . PHP_EOL
                    . 'CUSTOMER EMAIL: ' . $customerOrder->getCustomerEmail() . PHP_EOL
                    . 'ORDER ID: ' . $orderId . PHP_EOL
                    . 'ORDER CREATED AT: ' . $customerOrder->getCreatedAt() . PHP_EOL
                    . 'CUSTOMER GROUP: ' . $customerInfo->getData('customer_group_code') . PHP_EOL
                    . '*************************************************************' . PHP_EOL,
                    null, $this->filename);

        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            echo $e->getTraceAsString();
        }
    }

}
