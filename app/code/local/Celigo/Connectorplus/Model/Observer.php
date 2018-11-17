<?php

class Celigo_Connectorplus_Model_Observer extends Mage_Core_Model_Abstract {
    /**
     *	Listen to order_cancel_after event
     *	Function to push the canceled order to NetSuite
     */
    public function orderCancelAfter($observer) {
        if (Mage::helper('connectorplus')->hasConnectorModuleInstalled()) {
            $order = $observer->getEvent()->getOrder();
            $storeId = $order->getStoreId();
            try {
                if (Mage::helper('connector')->getIsConnectorModuleEnabled($order->getStoreId())) {
                    if ($order->getCancelledInNetsuite() !== 1) {
                        // Push to NetSuite
                        $result = Mage::getModel('connectorplus/sales_order_cancel')->pushCancelledOrderToNS($order->getId());
                    }
                }
            }
            catch(Exception $e) {
                Mage::helper('connector')->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, $storeId, '');
            }
        }
    }
}
