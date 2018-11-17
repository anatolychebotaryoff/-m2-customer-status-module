<?php
/**
 * Override Inchoo_LoginAsCustomer_Model_Observer to open new window when 'Login is as Customer' button is clicked
 *
 * @category  Lyons
 * @package   Lyonscg_LoginAsCustomer
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_LoginAsCustomer_Model_Observer extends Inchoo_LoginAsCustomer_Model_Observer
{
    /**
     * Override to open a new window instead of using the current window
     *
     * @param $observer
     */
    public function injectLoginAsCustomerButton($observer)
    {
        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Mage_Adminhtml_Block_Customer_Edit) {
            if ($this->getCustomer() && $this->getCustomer()->getId()) {
                $block->addButton('loginAsCustomer', array(
                    'label' => Mage::helper('customer')->__('Login as Customer'),
                    'onclick' => 'window.open(\'' . $this->getLoginAsCustomerUrl() . '\', \'_blank\')',
                    'class' => 'loginAsCustomer',
                ), 0);
            }
        }
    }
}
