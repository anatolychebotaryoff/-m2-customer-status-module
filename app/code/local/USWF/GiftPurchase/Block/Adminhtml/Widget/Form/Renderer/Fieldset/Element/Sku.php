<?php
/**
 * Sku element renderer
 */
class USWF_GiftPurchase_Block_Adminhtml_Widget_Form_Renderer_Fieldset_Element_Sku extends Mage_Adminhtml_Block_Template
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element;

    protected function _construct()
    {
        $this->setTemplate('uswf/giftpurchase/gift/widget/form/renderer/fieldset/element/sku.phtml');
    }

    public function getElement()
    {
        return $this->_element;
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->_element = $element;
        return $this->toHtml();
    }
}
