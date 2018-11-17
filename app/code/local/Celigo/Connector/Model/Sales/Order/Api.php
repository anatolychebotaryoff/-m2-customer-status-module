<?php

class Celigo_Connector_Model_Sales_Order_Api extends Mage_Sales_Model_Order_Api
//Mage_Api_Model_Resource_Abstract
{
    /**
     * Initialize basic order model
     *
     * @param mixed $orderIncrementId
     * @return Mage_Sales_Model_Order
     */
    protected function _initOrder($orderIncrementId) {
        $order = Mage::getModel('sales/order');
        /* @var $order Mage_Sales_Model_Order */
        $order->loadByIncrementId($orderIncrementId);
        if (!$order->getId()) {
            $this->_fault('not_exists');
        }
        
        return $order;
    }
    /**
     * Update Order information
     *
     * @param string $orderIncrementId
     * @param array order data
     * @return string
     */
    public function update($orderIncrementId, $data) {
        if (!is_array($data)) {
            $this->_fault('order_data_invalid', 'Order data must be an array.');
        }
        $notAllowedAttributes = array(
            'grand_total',
        );
        $order = $this->_initOrder($orderIncrementId);
        try {
            
            foreach ($data as $key => $value) {
                if (in_array($key, $notAllowedAttributes, true)) {
                    unset($data[$key]);
                } else {
                    $order->setData($key, $value);
                }
            }
            $pushedOrderStatus = Mage::helper('connector')->getPushedOrderStatus($order->getStoreId());
            if (trim($pushedOrderStatus) != "") {
                $order->addStatusToHistory($pushedOrderStatus, "", false);
            } elseif (count($data) == 0) {
                throw new Exception('Order data should not blank.');
            }
            $order->save();
        }
        catch(Mage_Core_Exception $e) {
            $this->_fault('order_data_invalid', $e->getMessage());
        }
        
        return true;
    }
}
?>