<?php

class USWF_LogBacktrace_Block_Adminhtml_Version extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    public function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        return "<strong>" . (string)Mage::helper('uswf_logbacktrace')->getExtensionVersion() . "</strong>";
    }

}
