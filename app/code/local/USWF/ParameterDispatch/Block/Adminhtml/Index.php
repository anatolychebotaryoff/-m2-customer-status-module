<?php

class USWF_ParameterDispatch_Block_Adminhtml_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{


    public function __construct()
    {
        $this->_blockGroup = 'uswf_parameterdispatch';
        $this->_controller = 'adminhtml_parameterdispatch';
        $this->_headerText = Mage::helper('uswf_parameterdispatch')->__('Parameter Dispatch - Events');
 
        parent::__construct();
    }

}
