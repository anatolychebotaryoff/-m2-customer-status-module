<?php

class USWF_BrandCategory_Block_Adminhtml_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{


    public function __construct()
    {
        $this->_blockGroup = 'uswf_brandcategory';
        $this->_controller = 'adminhtml_brandcategory';
        $this->_headerText = Mage::helper('uswf_brandcategory')->__('Brand Category - Records');

        parent::__construct();

    }

}
