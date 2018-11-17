<?php

/**
 * Storelocator Resource Collection Model
 * 
 * @category 	USWF
 * @package 	USWF_Storelocator
 * @author  	USWF Developer
 */
class USWF_Storelocator_Model_Mysql4_Storelocator_Collection extends Magestore_Storelocator_Model_Mysql4_Storelocator_Collection {
    
    //use for multi store
    public function addFieldToFilter($field, $condition = null) {
        $attributes = array(
            'name',
            'status',
            'description',
            'address',
            'city',
            'sort',
        );
        $storeId = $this->getStoreId();
        if (in_array($field, $attributes) && $storeId) {
            if (!in_array($field, $this->_addedTable)) {
                $this->getSelect()
                        ->joinLeft(array($field => $this->getTable('storelocator/storevalue')), "main_table.storelocator_id = $field.storelocator_id" .
                                " AND $field.store_id = $storeId" .
                                " AND $field.attribute_code = '$field'", array()
                );
                $this->_addedTable[] = $field;
            }
            
            $expression = "IF($field.value IS NULL, main_table.$field, $field.value)";
            $_condition = $this->_getConditionSql($expression, $condition);
            $this->getSelect()->where($_condition);
            return $this;
        }
        if ($field == 'store_id') {
            $field = 'main_table.storelocator_id';
        }
        return parent::addFieldToFilter($field, $condition);
    }

}
