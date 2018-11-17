<?php

class USWF_Catalog_Model_Catalog_Index_Action_Product_Flat_Refresh extends Enterprise_Catalog_Model_Index_Action_Product_Flat_Refresh {

    /**
     * The issue with move of Default Value into chart catalog_product_flat was fixed
     * if meaning of specific store view equally null
     *
     * Apply diff. between 0 store and current store to temporary flat table
     *
     * @param array $tables
     * @param array $changedIds
     *
     * @return Enterprise_Catalog_Model_Index_Action_Product_Flat_Refresh
     */
    protected function _updateTemporaryTableByStoreValues(array $tables, array $changedIds)
    {
        $flatColumns = $this->_productHelper->getFlatColumns();
        $temporaryFlatTableName = $this->_getTemporaryTableName(
            $this->_productHelper->getFlatTableName($this->_storeId)
        );

        foreach ($tables as $tableName => $columns) {
            foreach ($columns as $attribute) {
                $attributeCode = $attribute->getAttributeCode();
                if ($attribute->getBackend()->getType() != 'static') {
                    $joinCondition = 't.entity_id = e.entity_id'
                        . ' AND t.entity_type_id = ' . $attribute->getEntityTypeId()
                        . ' AND t.attribute_id=' . $attribute->getId()
                        . ' AND t.store_id = ' . $this->_storeId;
                        //old -> . ' AND t.value IS NOT NULL'

                    $select = $this->_connection->select()
                        ->joinInner(
                            array('t' => $tableName),
                            $joinCondition,
                            array($attributeCode => 't.value')
                        );
                    if (!empty($changedIds)) {
                        $select->where(
                            $this->_connection->quoteInto('e.entity_id IN (?)', $changedIds)
                        );
                    }
                    $sql = $select->crossUpdateFromSelect(array('e' => $temporaryFlatTableName));
                    $this->_connection->query($sql);
                }

                //Update not simple attributes (eg. dropdown)
                if (isset($flatColumns[$attributeCode . $this->_valueFieldSuffix])) {
                    $select = $this->_connection->select()
                        ->joinInner(
                            array('t' => $this->_productHelper->getTable('eav/attribute_option_value')),
                            't.option_id = e.' . $attributeCode . ' AND t.store_id=' . $this->_storeId,
                            array($attributeCode . $this->_valueFieldSuffix => 't.value')
                        );
                    if (!empty($changedIds)) {
                        $select->where(
                            $this->_connection->quoteInto('e.entity_id IN (?)', $changedIds)
                        );
                    }
                    $sql = $select->crossUpdateFromSelect(array('e' => $temporaryFlatTableName));
                    $this->_connection->query($sql);
                }
            }
        }

        return $this;
    }
}