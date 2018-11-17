<?php

class Sam_HardnessDatabase_Block_Adminhtml_Zipcodes_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    
    public function __construct()
    {
        $this->_objectId = 'hardness_id';
        $this->_controller = 'adminhtml_zipcodes';
        $this->_blockGroup = 'hardness';
        
        parent::__construct();
        
        $this->_updateButton('save', 'label', Mage::helper('hardness')->__('Save Data'));
        $this->_updateButton('delete', 'label', Mage::helper('hardness')->__('Delete Data'));
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    
    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('hardness_zip')->getId()) {
            return Mage::helper('hardness')->__("Edit Zip '%s'", $this->escapeHtml(Mage::registry('hardness_zip')->getZipCode()));
        } else {
            return Mage::helper('hardness')->__('New Zip');
        }
    }
    
}