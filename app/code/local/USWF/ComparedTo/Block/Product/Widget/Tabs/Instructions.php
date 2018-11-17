<?php
/**
 * Instructions.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Tabs_Instructions extends Mage_Core_Block_Template
{
    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/widget/compare/tabs/instructions.phtml');
        $this->setLabel('Instructions');
        return parent::_prepareLayout();
    }
}