<?php
/**
 * Gift of Product Tab
 */

class USWF_GiftPurchase_Block_Adminhtml_Gift_Quote_Edit_Tab_Giftproduct
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare content for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('uswf_giftpurchase')->__('Gift Product');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('uswf_giftpurchase')->__('Gift Product');
    }

    /**
     * Returns status flag about this tab can be showed or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('current_giftpurchase_rule');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('rule_');

        $renderer = Mage::getBlockSingleton('adminhtml/widget_form_renderer_fieldset')
            ->setTemplate('uswf/giftpurchase/gift/widget/form/renderer/fieldset.phtml');
        $fieldset = $form->addFieldset('giftproduct_fieldset_sku',
            array('legend '=> Mage::helper('uswf_giftpurchase')->__('Gift sku Information'))
        )->setRenderer($renderer);
        $renderer = Mage::getBlockSingleton('uswf_giftpurchase/adminhtml_widget_form_renderer_fieldset_element_sku');
        $fieldset->addField('gift_product_sku', 'text', array(
            'name' => 'gift_product_sku',
            'label' => Mage::helper('uswf_giftpurchase')->__('Product Sku'),
            'title' => Mage::helper('uswf_giftpurchase')->__('Product Sku'),
            'required' => false,
            'class' => 'element-value-changer input-text',
            'after_element_html' => ''
        ))->setRenderer($renderer);

        $fieldsetQty = $form->addFieldset('giftproduct_fieldset',
            array('legend '=> Mage::helper('uswf_giftpurchase')->__('Gift Qty Information'))
        );
        $fieldsetQty->addField('gift_product_qty', 'text', array(
            'name' => 'gift_product_qty',
            'label' => Mage::helper('uswf_giftpurchase')->__('Qty'),
            'title' => Mage::helper('uswf_giftpurchase')->__('Qty'),
            'required' => false,
            'class' => ' validate-number validate-not-negative-number'
        ));


        $form->setValues($model->getData());

        if ($model->isReadonly()) {
            foreach ($fieldset->getElements() as $element) {
                $element->setReadonly(true, true);
            }
        }

        $this->setForm($form);

        Mage::dispatchEvent('adminhtml_gift_quote_edit_tab_giftproduct_prepare_form', array('form' => $form));

        return parent::_prepareForm();
    }
}
