<?php
/**
 * Adds tab to the catalog product edit in the admin
 *
 * @category   Lyons
 * @package    Lyonscg_ReplacedBy
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_ReplacedBy_Block_Adminhtml_Catalog_Product_Edit_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs
{
    /**
     * Prepare Layout for adding new tab
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $ret = parent::_prepareLayout();

        $product = $this->getProduct();

        if (!($setId = $product->getAttributeSetId())) {
            $setId = $this->getRequest()->getParam('set', null);
        }

        if ($setId) {
            $this->addTabAfter('replaced', array(
                'label' => Mage::helper('catalog')->__('Replaced By'),
                'url' => $this->getUrl('*/*/replaced', array('_current' => true)),
                'class' => 'ajax',
            ), 'crosssell');
        }

        return $ret;
    }

}

?>