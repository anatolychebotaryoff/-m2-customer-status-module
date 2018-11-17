<?php
/**
 * USWF Parameter Dispatch Events
 *
 * @category    USWF
 * @package     USWF_ParameterDispatch
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_ParameterDispatch_Block_Adminhtml_ParameterDispatch extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Render grid, add buttons
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_parameterdispatch';
        $this->_blockGroup = 'uswf_parameterdispatch';
        $this->_headerText = Mage::helper('uswf_parameterdispatch')->__('Parameter Dispatch Events');
        $this->_addButtonLabel = Mage::helper('uswf_parameterdispatch')->__('Add New Parameter Dispatch Event');

        parent::__construct();
    }
}
