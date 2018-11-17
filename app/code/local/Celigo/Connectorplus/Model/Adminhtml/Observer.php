<?php

class Celigo_Connectorplus_Model_Adminhtml_Observer extends Mage_Adminhtml_Block_Widget_Form_Container
//extends Mage_Core_Model_Abstract
{
    /**
     * Add Cancel in NetSuite button in order view page
     * @param Varien_Event_Observer $observer
     */
    public function addMassAction($observer) {
        if (Mage::helper('connectorplus')->hasConnectorModuleInstalled()) {
            $storeId = '';
            $params = Mage::app()->getRequest()->getParams();
            unset($params['key']);
            $block = $observer->getEvent()->getBlock();
            if (!($block->getRequest()->getControllerName() == 'sales_order' || $block->getRequest()->getControllerName() == 'adminhtml_sales_order')) {
                
                return;
            }
            // Order View Page Cancel in NS button
            if (get_class($block) == 'Mage_Adminhtml_Block_Sales_Order_View') {
                $params = Mage::app()->getRequest()->getParams();
                unset($params['key']);
                if (isset($params['order_id']) && $params['order_id'] != '') {
                    $configUrl = $this->getUrl('connectorplus/adminhtml_portcancel/pushorder', $params);
                    $order = Mage::getModel('sales/order')->load($params['order_id']);
                    $storeId = $order->getStoreId();
                    /** If the Push to NetSuite setting was set to No then return false */
                    if (!Mage::helper('connector')->getIsConnectorModuleEnabled($storeId) || $order->getCancelledInNetsuite() == 1) {
                        
                        return;
                    }
                    /** Get all the order statuses from setting that need to be synced to NetSuite */
                    $status = Mage::helper('connector')->getOrderStatusArray($storeId);
                    if (count($status) == 0) {
                        
                        return;
                    }
                    $itemCanceled = false;
                    $items = $order->getAllItems();
                    
                    foreach ($items as $itemId => $item) {
                        if ($item->getQtyCanceled() > 0) {
                            $itemCanceled = true;
                            break;
                        }
                    }
                    /** Check if the current order status is allowed to be synced to NetSuite */
                    if (($order->getStatus() == Mage_Sales_Model_Order::STATE_CANCELED || $itemCanceled)) {
                        $block->addButton('cancelinns', array(
                            'label' => 'Cancel in NetSuite',
                            'onclick' => 'setLocation(\'' . $configUrl . '\')',
                            'class' => 'go'
                        ));
                    }
                }
            }
        }
    }
}
