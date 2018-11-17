<?php

class USWF_ComparedTo_Model_System_Config_Source_CheckmarksTier1
{
    public function toOptionArray()
    {
        return array(
            array('value' => '0', 'label' => 'Disabled'),
            array('value' => '1', 'label' => 'Show 3 checkmarks'),
            array('value' => '2', 'label' => 'Show 5 checkmarks'),
        );
    }
}
