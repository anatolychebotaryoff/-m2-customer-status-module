<?php
/**
 * Faq.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Tabs_Faq extends Mage_Core_Block_Template
{
    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/widget/compare/tabs/faq.phtml');
        $this->setLabel('Frequently Asked Questions');
        return parent::_prepareLayout();
    }
}