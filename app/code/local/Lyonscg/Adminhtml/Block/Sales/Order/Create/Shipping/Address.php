<?php
/**
 * Lyonscg_Adminhtml
 *
 * @category    Lyonscg
 * @package     Lyonscg_Adminhtml
 * @copyright   Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 * @author      Eugene Nazarov (enazarov@lyonscg.com)
 */
class Lyonscg_Adminhtml_Block_Sales_Order_Create_Shipping_Address
    extends Mage_Adminhtml_Block_Sales_Order_Create_Shipping_Address
{

    /**
     * Prepare Form and add elements to form
     *
     * @return Lyonscg_Adminhtml_Block_Sales_Order_Create_Shipping_Address
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();

        $this->_form->getElement('postcode')->setPattern('[0-9]*');

        return $this;
    }
}
