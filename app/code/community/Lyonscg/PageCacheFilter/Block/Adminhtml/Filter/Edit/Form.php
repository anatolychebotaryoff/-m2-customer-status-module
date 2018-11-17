<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Block_Adminhtml_Filter_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form for display
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('lyonscg_pagecachefilter_filter');
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post'
            )
        );

        $fieldset = $form->addFieldset(
            'general_fieldset',
            array('legend' => Mage::helper('lyonscg_pagecachefilter')->__('Filter Configuration'))
        );

        //add id field
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('enabled', 'select', array(
            'label' => Mage::helper('lyonscg_pagecachefilter')->__('Status'),
            'title' => Mage::helper('lyonscg_pagecachefilter')->__('Status'),
            'name' => 'enabled',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('lyonscg_pagecachefilter')->__('Enabled'),
                '0' => Mage::helper('lyonscg_pagecachefilter')->__('Disabled'),
            ),
        ));
        if (!$model->getId()) {
            $model->setData('enabled', '1');
        }

        $fieldset->addField('target', 'select', array(
            'label' => Mage::helper('lyonscg_pagecachefilter')->__('Filter Level'),
            'title' => Mage::helper('lyonscg_pagecachefilter')->__('Filter Level'),
            'name' => 'target',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('lyonscg_pagecachefilter')->__('Application'),
                '0' => Mage::helper('lyonscg_pagecachefilter')->__('Full Page Cache Only'),
            ),
        ));

        $fieldset->addField("param", 'text', array(
            'name' => "param",
            'label' => Mage::helper('lyonscg_pagecachefilter')->__('URL Parameter'),
            'title' => Mage::helper('lyonscg_pagecachefilter')->__('URL Parameter'),
            'required' => true,
        ));

        $fieldset->addField("description", 'text', array(
            'name' => "description",
            'label' => Mage::helper('lyonscg_pagecachefilter')->__('Description'),
            'title' => Mage::helper('lyonscg_pagecachefilter')->__('Description'),
            'required' => true,
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}