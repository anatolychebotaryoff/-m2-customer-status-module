<?php

class USWF_LogBacktrace_Block_Adminhtml_System_Config_Form_Button_Download extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'LogBacktrace_button',
                'label'     => $this->helper('adminhtml')->__('Log Backtrace'),
                'onclick'   => "setLocation('" . Mage::helper('adminhtml')->getUrl('adminhtml/adminhtml_logbacktrace/download'). "')",
            ));
        return $button->toHtml();
    }


}

