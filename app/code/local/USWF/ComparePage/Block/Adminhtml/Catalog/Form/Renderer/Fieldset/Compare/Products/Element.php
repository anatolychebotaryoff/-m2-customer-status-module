<?php
/**
 * Fieldset ComparedProducts element renderer
 */
class USWF_ComparePage_Block_Adminhtml_Catalog_Form_Renderer_Fieldset_Compare_Products_Element
    extends USWF_ComparePage_Block_Adminhtml_Catalog_Form_Renderer_Fieldset_Compare_Element
{
    /**
     * Initialize block template
     */
    protected function _construct()
    {
        $this->setTemplate('uswf/comparepage/catalog/form/renderer/fieldset/compare/products/element.phtml');
    }

    /**
     * Retrieve label scope
     *
     * GLOBAL | STORE
     *
     * @return string
     */
    public function getScopeLabel()
    {
        $html = '';
        if (Mage::app()->isSingleStoreMode()) {
            return $html;
        }
        $obj = $this->getDataObject();
        $curStore = $obj->getCurStore();
        if ($curStore) {
            $html .= Mage::helper('adminhtml')->__('[STORE VIEW]');
        } else {
            $html .= Mage::helper('adminhtml')->__('[GLOBAL]');
        }
        return $html;
    }
}
