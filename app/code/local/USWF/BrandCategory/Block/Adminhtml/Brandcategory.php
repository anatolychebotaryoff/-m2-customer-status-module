<?php
/**
 * USWF Brand Category Records
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Block_Adminhtml_BrandCategory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Render grid, add buttons
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_brandcategory';
        $this->_blockGroup = 'uswf_brandcategory';
        $this->_headerText = Mage::helper('uswf_brandcategory')->__('Brand Category Records');
        //$this->_addButtonLabel = Mage::helper('uswf_brandcategory')->__('Add New Brand Category Record');

        parent::__construct();
        $this->_removeButton('add');
    }
}
