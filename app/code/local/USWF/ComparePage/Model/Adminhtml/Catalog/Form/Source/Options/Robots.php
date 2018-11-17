<?php

class USWF_ComparePage_Model_Adminhtml_Catalog_Form_Source_Options_Robots
{

    public function toOptionArray()
    {
        return array(
                array('value' => 'INDEX, FOLLOW', 'label' => 'INDEX, FOLLOW'),
                array('value' => 'INDEX, NOFOLLOW', 'label' => 'INDEX, NOFOLLOW'),
                array('value' => 'NOINDEX, FOLLOW', 'label' => 'NOINDEX, FOLLOW'),
                array('value' => 'NOINDEX, NOFOLLOW', 'label' => 'NOINDEX, NOFOLLOW'),
                array('value' => 'INDEX, FOLLOW, NOARCHIVE', 'label' => 'INDEX, FOLLOW, NOARCHIVE'),
                array('value' => 'INDEX, NOFOLLOW, NOARCHIVE', 'label' => 'INDEX, NOFOLLOW, NOARCHIVE'),
                array('value' => 'NOINDEX, NOFOLLOW, NOARCHIVE', 'label' => 'NOINDEX, NOFOLLOW, NOARCHIVE'),
            );
    }

    public function toOptionDefault()
    {
        return 'NOINDEX, NOFOLLOW';
    }

}