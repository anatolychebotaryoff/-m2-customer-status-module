<?php

class USWF_ComparePage_Block_Adminhtml_Cms_Block_Widget_Chooser extends Mage_Adminhtml_Block_Cms_Block_Widget_Chooser
{

    /**
     * Prepare chooser element HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        //$uniqId = Mage::helper('core')->uniqHash($element->getId());
        $uniqId = 'chooser_'.$element->getId();
        $sourceUrl = $this->getUrl('*/cms_block_widget/chooser', array('uniq_id' => $uniqId));

        $chooser = $this->getLayout()->createBlock('uswf_comparepage/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        $blockId = $element->getForm()->getDataObject()->getData($element->getHtmlId());
        if ($blockId) {
            $block = Mage::getModel('cms/block')->load($blockId);
            if ($block->getId()) {
                $element->getForm()->getDataObject()->unsetData($element->getHtmlId());
                $chooser->setLabel($block->getTitle());
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }
}
