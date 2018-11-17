<?php
/**
 * Catalog rule edit form block
 */

class USWF_GiftPurchase_Block_Adminhtml_Gift_Quote_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize form
     * Add standard buttons
     * Add "Save and Apply" button
     * Add "Save and Continue" button
     */
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'uswf_giftpurchase';
        $this->_controller = 'adminhtml_gift_quote';

        parent::__construct();

        $this->_addButton('save_apply', array(
            'class'   => 'save',
            'label'   => Mage::helper('uswf_giftpurchase')->__('Save and Apply'),
            'onclick' => "$('rule_auto_apply').value=1; editForm.submit()",
        ));

        $this->_addButton('save_and_continue_edit', array(
            'class'   => 'save',
            'label'   => Mage::helper('uswf_giftpurchase')->__('Save and Continue Edit'),
            'onclick' => 'editForm.submit($(\'edit_form\').action + \'back/edit/\')',
        ), 10);
    }

    /**
     * Getter for form header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        $rule = Mage::registry('current_giftpurchase_rule');
        if ($rule->getRuleId()) {
            return Mage::helper('uswf_giftpurchase')->__("Edit Rule '%s'", $this->escapeHtml($rule->getName()));
        }
        else {
            return Mage::helper('uswf_giftpurchase')->__('New Rule');
        }
    }

}
