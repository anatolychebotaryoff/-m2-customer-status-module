<?php
/**
 * Controller Class to push the canceled orders to Netsuite
 */

class Celigo_Connectorplus_Adminhtml_PortcancelController extends Mage_Adminhtml_Controller_Action {
    public function indexAction() {
        $this->_redirect('adminhtml/sales_order');
    }
    /**
     * Push the selected order to NetSuite if not pushed
     */
    public function pushorderAction() {
        if (Mage::helper('connectorplus')->hasConnectorModuleInstalled()) {
            try {
                $orderId = $this->getRequest()->getParam('order_id', array());
                $params = Mage::app()->getRequest()->getParams();
                unset($params['key']);
                $order = Mage::getModel('sales/order')->load($orderId);
                $storeId = $order->getStoreId();
                if (!Mage::helper('connector')->getIsConnectorModuleEnabled($storeId)) {
                    $this->_redirect('adminhtml/sales_order');
                }
                $itemCanceled = false;
                $items = $order->getAllItems();
                
                foreach ($items as $itemId => $item) {
                    if ($item->getQtyCanceled() > 0) {
                        $itemCanceled = true;
                        break;
                    }
                }
                if ($order->getId()) {
                    if (($order->getStatus() == Mage_Sales_Model_Order::STATE_CANCELED || $itemCanceled) && !$order->getCancelledInNetsuite()) {
                        $result = Mage::getModel('connectorplus/sales_order_cancel')->pushCancelledOrderToNS($order->getId());
                        if ($result === true) {
                            $this->_getSession()->addSuccess($this->__('The Order (%s) has been Canceled in NetSuite.', $order->getIncrementId()));
                        } else {
                            $this->_getSession()->addError($this->__('Error (Order#  ' . $order->getIncrementId() . ') : ' . $result));
                        }
                    } else {
                        $this->_getSession()->addError($this->__('This Order (%s) was already Canceled in NetSuite', $order->getIncrementId()));
                    }
                }
            }
            catch(Exception $e) {
                Mage::helper('connector')->addErrorMessageToLog($e->getMessage() , Zend_Log::ERR, '', '');
            }
            $this->_redirect('adminhtml/sales_order/view', $params);
        }
        $this->_redirect('adminhtml/sales_order');
    }
}
