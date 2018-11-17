<?php
/**
 * Catalog price rules
 */

class USWF_GiftPurchase_Block_Adminhtml_Gift_Quote extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_addButton('apply_rules', array(
            'label'     => Mage::helper('catalogrule')->__('Apply Rules'),
            'onclick'   => "location.href='".$this->getUrl('*/*/applyRules')."'",
            'class'     => '',
        ));

        $this->_controller = 'adminhtml_gift_quote';
        $this->_blockGroup = 'uswf_giftpurchase';
        $this->_headerText = Mage::helper('uswf_giftpurchase')->__('Gift with Purchase');
        $this->_addButtonLabel = Mage::helper('uswf_giftpurchase')->__('Add New Rule');
        parent::__construct();
    }

}
