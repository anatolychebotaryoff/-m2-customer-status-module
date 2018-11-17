<?php

class USWF_ComparePage_Model_Resource_Compare_Widget_Store extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('uswf_comparepage/compare_widget_store', 'compare_widget_id');
    }

}