<?php

class Sam_HardnessDatabase_Block_Adminhtml_Hardnessimport_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    
    public function __construct()
    {
        parent::__construct();
        $this->setId('hardness_import_form');
        $this->setTitle(Mage::helper('hardness')->__('Import data from file'));
    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/import'),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );
        
        $form->setHtmmlIdPrefix('hardness_import_');
        
        $fieldset = $form->addFieldset('base_fieldset',
            array(
                'legend' => Mage::helper('hardness')->__('File select'),
                'class' => 'fieldset-wide')
        );
        
        $fieldset->addField('hardness_file', 'file', array(
            'name' => 'hardness_file',
            'label' => Mage::helper('hardness')->__('Select file (CSV)'),
            'title' => Mage::helper('hardness')->__('Select file (CSV)'),
            'required' => true,
        ));
        
        $form->setUseContainer(true);
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
    
}