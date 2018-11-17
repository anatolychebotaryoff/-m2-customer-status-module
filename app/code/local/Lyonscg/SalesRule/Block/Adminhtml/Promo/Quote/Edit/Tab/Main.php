<?php
/**
 * Overwrite Mage_Adminhtml_Block_Promo_Quote_Edit_Tab_Main to add custom field
 *
 * @category  Lyons
 * @package   Lyonscg_SalesRule
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_SalesRule_Block_Adminhtml_Promo_Quote_Edit_Tab_Main extends Mage_Adminhtml_Block_Promo_Quote_Edit_Tab_Main
{
    /**
     * Rewrite to add new field to sales rule
     *
     * @return Mage_Adminhtml_Block_Widget_Form|void
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();

        $form = $this->getForm();

        $fieldSet = $form->getElement('base_fieldset');

        $fieldSet->addField('terms_and_conditions', 'textarea', array(
            'name' => 'terms_and_conditions',
            'label' => Mage::helper('salesrule')->__('Terms and Conditions'),
            'title' => Mage::helper('salesrule')->__('Terms and Conditions'),
            'style' => 'height: 100px;',
        ), 'description');

        $model = Mage::registry('current_promo_quote_rule');

        if ($model->getId()) {
            $form->setValues($model->getData());
        }


    }
}
