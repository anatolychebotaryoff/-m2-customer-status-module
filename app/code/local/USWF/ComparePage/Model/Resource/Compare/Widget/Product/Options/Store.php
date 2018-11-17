<?php

class USWF_ComparePage_Model_Resource_Compare_Widget_Product_Options_Store extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('uswf_comparepage/compare_widget_product_options_store', 'compare_product_options_id');
    }

}