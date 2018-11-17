<?php

class USWF_GiftPurchase_Block_Adminhtml_Gift_Quote_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('gift_quote_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('uswf_giftpurchase')->__('Gift with Purchase'));
    }
}
