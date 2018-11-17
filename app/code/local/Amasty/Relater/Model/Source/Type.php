<?php
/**
 * @copyright   Copyright (c) 2011 Amasty (http://www.amasty.com)
 */ 
class Amasty_Relater_Model_Source_Type
{
    public function toOptionArray()
    {
        $options = array(
            array('value'=> 0, 'label' => Mage::helper('amrelater')->__('Default')),
            array('value'=> 1, 'label' => Mage::helper('amrelater')->__('2 Way')),
            array('value'=> 2, 'label' => Mage::helper('amrelater')->__('Multi Way')),
        );
        
        return $options;
    }
}