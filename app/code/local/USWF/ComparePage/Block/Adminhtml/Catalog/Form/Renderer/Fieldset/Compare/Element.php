<?php
/**
 * Compare fieldset element renderer
 */
class USWF_ComparePage_Block_Adminhtml_Catalog_Form_Renderer_Fieldset_Compare_Element
    extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    /**
     * Initialize block template
     */
    protected function _construct()
    {
        $this->setTemplate('uswf/comparepage/catalog/form/renderer/fieldset/compare/element.phtml');
    }

    /**
     * Retrieve data object related with form
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getDataObject()
    {
        return $this->getElement()->getForm()->getDataObject();
    }

    /**
     * Check "Use default" checkbox display availability
     *
     * @return bool
     */
    public function canDisplayUseDefault()
    {
        if ($this->getElement()->getNotScopeLabel() === true) {
            return false;
        }
        $storeId = (int)Mage::app()->getRequest()->getParam('store');
        return $storeId;
    }

    /**
     * Check don`t use scope label display availability
     *
     * @return bool
     */
    public function canDisplayScopeLabel()
    {
        $result = (int)$this->getElement()->getNotScopeLabel();
        $storeId = (int)Mage::app()->getRequest()->getParam('store');
        if ($storeId) {
            $result = false;
        }
        return !$result;
    }

    /**
     * Check default value usage fact
     *
     * @return bool
     */
    public function usedDefault()
    {
        $storeId = (int)Mage::app()->getRequest()->getParam('store');
        $id = $this->getElement()->getHtmlId();
        /** @var USWF_ComparePage_Model_Compare_Widget_Default $obj */
        $obj = $this->getDataObject()->getWidgetDefault();
        if ($storeId != $this->_getDefaultStoreId() &&
            ($obj->isEmpty() || $obj->getData($id))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Disable field in default value using case
     *
     * @return Mage_Adminhtml_Block_Catalog_Form_Renderer_Fieldset_Element
     */
    public function checkFieldDisable()
    {
        $disable = $this->getElement()->getFieldDisable();
        if ($disable || $this->canDisplayUseDefault() && $this->usedDefault()) {
            $this->getElement()->setDisabled(true);
        }
        return $this;
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
        if ($this->getElement()->getNotScopeLabel() === true) {
            return Mage::helper('adminhtml')->__('[STORE VIEW]');
        }
        $html = '';
        if (Mage::app()->isSingleStoreMode()) {
            return $html;
        }
        $id = $this->getElement()->getHtmlId();

        /** @var USWF_ComparePage_Model_Compare_Widget_Default $obj */
        $obj = $this->getDataObject()->getWidgetDefault();
        $count = Mage::helper('uswf_comparepage')->checkUseDefaultProductId($this->getDataObject()->getParentProductId(), $id);
        if (!$count || $obj->getData($id)) {
            $html .= Mage::helper('adminhtml')->__('[GLOBAL]');
        } else {
            $html .= Mage::helper('adminhtml')->__('[STORE VIEW]');
        }

        return $html;
    }

    /**
     * Retrieve element label html
     *
     * @return string
     */
    public function getElementLabelHtml()
    {
        $element = $this->getElement();
        $label = $element->getLabel();
        if (!empty($label)) {
            $element->setLabel($this->__($label));
        }
        return $element->getLabelHtml();
    }

    /**
     * Retrieve element html
     *
     * @return string
     */
    public function getElementHtml()
    {
        return $this->getElement()->getElementHtml();
    }

    /**
     * Default sore ID getter
     *
     * @return integer
     */
    protected function _getDefaultStoreId()
    {
        return Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID;
    }
}
