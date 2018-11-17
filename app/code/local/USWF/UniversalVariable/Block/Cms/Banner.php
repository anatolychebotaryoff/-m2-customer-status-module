<?php
/**
 * Hotdeal callout banner
 *
 * @category    USWF
 * @package     USWF_UniversalVariable
 * @copyright
 * @author
 */

class USWF_UniversalVariable_Block_Cms_Banner extends Mage_Core_Block_Abstract
{
    /**
     * Prepare Content HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        $blockId = $this->getBlockId();
        $html = '';
        if ($blockId) {
            try{
                $product = $currentProduct = Mage::registry('current_product');
                if(Mage::helper('uswf_hotdealgrouppricing')->isHotdealAssociated($product)){
                    $block = Mage::getModel('cms/block')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->load($blockId);
                    if ($block->getIsActive()) {
                        /* @var $helper Mage_Cms_Helper_Data */
                        $helper = Mage::helper('cms');
                        $processor = $helper->getBlockTemplateProcessor();
                        $html = $processor->filter($block->getContent());
                        $this->addModelTags($block);
                    }
                }
            }catch (Exception $ex){
                Mage::logException($ex);
            }
        }
        return $html;
    }

}