<?php
/**
 * Tabs.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Tabs extends Mage_Core_Block_Template
{
    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/widget/compare/tabs.phtml');
        $tabs = Mage::helper('uswf_comparedto')->getEnabledTabs($this->getWidget());
        $i = 0;
        foreach ($tabs as $tab) {
            $this->insert(
                $this->getLayout()
                    ->createBlock(
                        $tab,
                        'USWF_ComparedTo_Block_Product_Widget_Tabs' . $i++,
                        array('widget' => $this->getWidget())
                    ),
                '',
                true
            );
        }
        return parent::_prepareLayout();
    }
}