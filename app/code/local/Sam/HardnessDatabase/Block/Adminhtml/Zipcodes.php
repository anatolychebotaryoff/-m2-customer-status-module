<?php

class Sam_HardnessDatabase_Block_Adminhtml_Zipcodes
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_zipcodes';
        $this->_blockGroup = 'hardness';
        $this->_headerText = Mage::helper('hardness')->__('Hardness of water');
        $this->_addButtonLabel = Mage::helper('hardness')->__('Add new ZIP code');
        $this->addButton('hardness_import', array(
            'label'     => Mage::helper("hardness")->__("Import from File"),
            'class'     => "hardness-import-button",
            'onclick'   => "setLocation('" . Mage::helper("adminhtml")->getUrl("*/*/import") . "')",
        ));
        parent::__construct();
    }
    
}