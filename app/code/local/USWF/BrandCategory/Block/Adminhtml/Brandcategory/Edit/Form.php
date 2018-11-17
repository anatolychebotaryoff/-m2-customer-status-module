<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Block_Adminhtml_BrandCategory_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form for display
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('uswf_brandcategory_record');

        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post'
            )
        );

        $fieldset = $form->addFieldset(
            'general_fieldset',
            array('legend' => Mage::helper('uswf_brandcategory')->__('Brand Category Configuration'))
        );

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'label' => $this->__('Store View'),
                'title' => $this->__('Store View'),
                'required' => true,
                'disabled' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')
                    ->getStoreValuesForForm(false, true),
            ));
        }
        else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
        }

        //add id field
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('enabled', 'select', array(
            'label' => Mage::helper('uswf_brandcategory')->__('Status'),
            'title' => Mage::helper('uswf_brandcategory')->__('Status'),
            'name' => 'enabled',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('uswf_brandcategory')->__('Enabled'),
                '0' => Mage::helper('uswf_brandcategory')->__('Disabled'),
            ),
        ));
        if (!$model->getId()) {
            $model->setData('enabled', '1');
        }

        $fieldset->addField("brand", 'select', array(
            'name' => "brand",
            'label' => Mage::helper('uswf_brandcategory')->__(' Brand'),
            'title' => Mage::helper('uswf_brandcategory')->__(' Brand'),
            'required' => true,
            'disabled' => true,
            'after_element_html' => '<p>This is not editable, one Brand entry for each store exists for every store view</p>',
            'values' => Mage::helper('uswf_brandcategory')->getAllBrandsArray(true)
        ));


        $fieldset->addField("record", 'select', array(
            'name' => "record",
            'label' => Mage::helper('uswf_brandcategory')->__('Category'),
            'title' => Mage::helper('uswf_brandcategory')->__('Category'),
            'required' => true,
            'after_element_html' => '<p>Select the category this brand should link to in product attribute list.</p>',
            'values' => Mage::helper('uswf_brandcategory')->getAllCategoriesArray(true, $model->getData('store_id'))
        ));

        $fieldset->addField("description", 'text', array(
            'name' => "description",
            'label' => Mage::helper('uswf_brandcategory')->__('Description'),
            'title' => Mage::helper('uswf_brandcategory')->__('Description'),
            'required' => false,
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
