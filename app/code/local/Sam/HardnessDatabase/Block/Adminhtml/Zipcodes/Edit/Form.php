<?php

class Sam_HardnessDatabase_Block_Adminhtml_Zipcodes_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    
    public function __construct()
    {
        parent::__construct();
        $this->setId('hardness_form');
        $this->setTitle(Mage::helper('hardness')->__('Zip information'));
    }
    
    protected function _prepareForm()
    {
        $model = Mage::registry('hardness_zip');
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('hardness_id' => $this->getRequest()->getParam('hardness_id'))),
                'method' => 'post'
            )
        );
        
        $form->setHtmmlIdPrefix('hardness_');
        
        $fieldset = $form->addFieldset('base_fieldset',
            array(
                'legend' => Mage::helper('hardness')->__('General Information'),
                'class' => 'fieldset-wide')
        );
        
        if ($model->getHardnessId()) {
            $fieldset->addField('hardness_id', 'hidden', array(
                'name' => 'hardness_id',
            ));
        }
        
        $fieldset->addField('zip_code', 'text', array(
            'name' => 'zip_code',
            'label' => Mage::helper('hardness')->__('Zip Code(XXXXX)'),
            'title' => Mage::helper('hardness')->__('Zip Code(XXXXX)'),
            'required' => true,
            'class' => 'validate-length maximum-length-5 minimum-length-5 validate-digits',
        ));
        
        $fieldset->addField('hardness_range', 'text', array(
            'name' => 'hardness_range',
            'label' => Mage::helper('hardness')->__('Range of Hardness'),
            'title' => Mage::helper('hardness')->__('Range of Hardness'),
            'required' => true,
        ));
        
        $fieldset->addField('primary_city', 'text', array(
            'name' => 'primary_city',
            'label' => Mage::helper('hardness')->__('Primary City'),
            'title' => Mage::helper('hardness')->__('Primary City'),
            'required' => true,
        ));
        
        $fieldset->addField('secondary_cities', 'text', array(
            'name' => 'secondary_cities',
            'label' => Mage::helper('hardness')->__('Secondary Cities'),
            'title' => Mage::helper('hardness')->__('Secondary Cities'),
            'required' => false,
        ));
        
        $fieldset->addField('state', 'text', array(
            'name' => 'state',
            'label' => Mage::helper('hardness')->__('State'),
            'title' => Mage::helper('hardness')->__('State'),
            'required' => true,
        ));
        
        $fieldset->addField('county', 'text', array(
            'name' => 'county',
            'label' => Mage::helper('hardness')->__('County'),
            'title' => Mage::helper('hardness')->__('County'),
            'required' => true,
        ));
        
        $fieldset->addField('country', 'text', array(
            'name' => 'country',
            'label' => Mage::helper('hardness')->__('Country'),
            'title' => Mage::helper('hardness')->__('Country'),
            'required' => true,
        ));
    
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
    
}