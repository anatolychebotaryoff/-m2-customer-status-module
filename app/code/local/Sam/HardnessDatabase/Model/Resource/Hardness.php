<?php

class Sam_HardnessDatabase_Model_Resource_Hardness extends Mage_Core_Model_Resource_Db_Abstract
{
    
    protected function _construct()
    {
        $this->_init('hardness/table_zipcodes', 'hardness_id');
    }
    
}