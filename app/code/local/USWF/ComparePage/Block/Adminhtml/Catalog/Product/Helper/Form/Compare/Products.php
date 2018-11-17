<?php

class USWF_ComparePage_Block_Adminhtml_Catalog_Product_Helper_Form_Compare_Products extends Varien_Data_Form_Element_Abstract
{

    public function getElementHtml()
    {
        $html = $this->getContentHtml();
        //$html.= $this->getAfterElementHtml();
        return $html;
    }

    /**
     * Prepares content block
     *
     * @return string
     */
    public function getContentHtml()
    {
        $content = Mage::getSingleton('core/layout')->getBlock('catalog.product.edit.tab.compare.products.container');
        if ($content) {
            $compareProductsBlock = $content->getChild('catalog.product.edit.tab.compare.products');
            if ($compareProductsBlock) {
                $compareProductsBlock->setElement($this);
            }
            return $content->toHtml();
        }
    }
}
