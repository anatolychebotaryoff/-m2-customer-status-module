<?php

class Sam_HardnessDatabase_Block_Adminhtml_Hardnessimport_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    
    public function __construct()
    {
        $this->_controller = 'adminhtml_hardnessimport';
        $this->_blockGroup = 'hardness';
        
        parent::__construct();
        
        $this->_updateButton('save', 'label', Mage::helper('hardness')->__('Save Data'));
        $this->_removeButton('delete');
    }
    
    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('hardness')->__('Import data from file');
    }
    
}