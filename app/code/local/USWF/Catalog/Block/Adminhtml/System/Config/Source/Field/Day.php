<?php
/**
 * HTML select element block
 * Class USWF_Catalog_Block_Adminhtml_System_Config_Source_Field_Day
 */

class USWF_Catalog_Block_Adminhtml_System_Config_Source_Field_Day
    extends Mage_Core_Block_Html_Select
{

    /**
     * Render HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        foreach ($this->getDayOptions() as $option) {
            $this->addOption($option['value'], $option['label']);
        }
        return parent::_toHtml();
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }

    public function getDayOptions()
    {
        return array(
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Sunday')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Monday')),
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Tuesday')),
            array('value' => 3, 'label' => Mage::helper('adminhtml')->__('Wednesday')),
            array('value' => 4, 'label' => Mage::helper('adminhtml')->__('Thursday')),
            array('value' => 5, 'label' => Mage::helper('adminhtml')->__('Friday')),
            array('value' => 6, 'label' => Mage::helper('adminhtml')->__('Saturday')),

        );
    }
}