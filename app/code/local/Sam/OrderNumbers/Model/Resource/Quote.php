<?php

class Sam_OrderNumbers_Model_Resource_Quote extends Mage_Sales_Model_Resource_Quote
{

    /**
     * Check is order increment id use in sales/order table
     *
     * @param int $orderIncrementId
     * @return boolean
     */
    public function isOrderIncrementIdUsed($orderIncrementId)
    {
        Mage::log($orderIncrementId,null, 'order_ids.log');
        $adapter   = $this->_getReadAdapter();
        $bind      = array(':increment_id' => $orderIncrementId);
        $select    = $adapter->select();
        $select->from($this->getTable('sales/order'), 'entity_id')
            ->where('increment_id = :increment_id');
        $entity_id = $adapter->fetchOne($select, $bind);
        if ($entity_id > 0) {
            Mage::log($orderIncrementId,null, 'order_ids_fail.log');
            return true;
        }

        return false;
    }

}