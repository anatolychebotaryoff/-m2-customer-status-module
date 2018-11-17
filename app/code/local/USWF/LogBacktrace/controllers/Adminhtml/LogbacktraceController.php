<?php


class USWF_LogBacktrace_Adminhtml_LogbacktraceController extends Mage_Adminhtml_Controller_Action
{

    public function downloadAction()
    {
        $logDir = Mage::getBaseDir('var') . DS . 'log';
        $logFile = $logDir . DS . USWF_LogBacktrace_Model_Log_Writer_Stream::FILE_NAME_LOGBACKTRACE;

        if (file_exists($logFile)) {
            $this->_prepareDownloadResponse(USWF_LogBacktrace_Model_Log_Writer_Stream::FILE_NAME_LOGBACKTRACE, array('type' => 'filename', 'value' => $logFile));
        } else {
            $this->_redirect("adminhtml/system_config/edit/section/uswf_logbacktrace");
        }
    }

    public function cleanAction()
    {
        $logDir = Mage::getBaseDir('var') . DS . 'log';
        $logFile = $logDir . DS . USWF_LogBacktrace_Model_Log_Writer_Stream::FILE_NAME_LOGBACKTRACE;

        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
        }
    }

}