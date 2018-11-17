<?php
/**
 * USWF Parameter Dispatch Event
 *
 * @category    USWF
 * @package     USWF_ParameterDispatch
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_ParameterDispatch_Block_Adminhtml_ParameterDispatch_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form for display
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('uswf_parameterdispatch_event');
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post'
            )
        );

        $fieldset = $form->addFieldset(
            'general_fieldset',
            array('legend' => Mage::helper('uswf_parameterdispatch')->__('Parameter Dispatch Configuration'))
        );

        //add id field
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('enabled', 'select', array(
            'label' => Mage::helper('uswf_parameterdispatch')->__('Status'),
            'title' => Mage::helper('uswf_parameterdispatch')->__('Status'),
            'name' => 'enabled',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('uswf_parameterdispatch')->__('Enabled'),
                '0' => Mage::helper('uswf_parameterdispatch')->__('Disabled'),
            ),
        ));
        if (!$model->getId()) {
            $model->setData('enabled', '1');
        }

        $fieldset->addField("param", 'text', array(
            'name' => "param",
            'label' => Mage::helper('uswf_parameterdispatch')->__('URL Parameter'),
            'title' => Mage::helper('uswf_parameterdispatch')->__('URL Parameter'),
            'required' => true,
        ));

        $fieldset->addField("event", 'text', array(
            'name' => "event",
            'label' => Mage::helper('uswf_parameterdispatch')->__('Event'),
            'title' => Mage::helper('uswf_parameterdispatch')->__('Event'),
            'required' => true,
        ));

        $fieldset->addField("description", 'text', array(
            'name' => "description",
            'label' => Mage::helper('uswf_parameterdispatch')->__('Description'),
            'title' => Mage::helper('uswf_parameterdispatch')->__('Description'),
            'required' => true,
        ));

        $fieldset->addField("priority", 'text', array(
            'name' => "priority",
            'label' => Mage::helper('uswf_parameterdispatch')->__('Priority'),
            'title' => Mage::helper('uswf_parameterdispatch')->__('Priority'),
            'required' => true,
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
