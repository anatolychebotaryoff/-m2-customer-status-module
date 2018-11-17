<?php

class USWF_LogBacktrace_Block_Adminhtml_System_Config_Form_Size extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {

        return "<strong>" . $this->filesize() . "</strong>";
    }

    function filesize($decimals = 0) {
        $logDir = Mage::getBaseDir('var') . DS . 'log';
        $logFile = $logDir . DS . USWF_LogBacktrace_Model_Log_Writer_Stream::FILE_NAME_LOGBACKTRACE;

        if (file_exists($logFile)) {
            $bytes = filesize($logFile);
            $sz = 'BKMGTP';
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
        } else {
            return '0';
        }
     }
}
