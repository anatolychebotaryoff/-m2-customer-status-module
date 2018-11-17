<?php

class USWF_LogBacktrace_Model_Log_Writer_Stream extends Zend_Log_Writer_Stream
{

    const FILE_NAME_LOGBACKTRACE = 'uswf_backtrace.log';

    protected $_stream_backtrace = null;

    protected $_backtrace_flag = null;

    const BACKTRACE_FORMAT = 'function: %function%, (%class%)%file%, line: %line% ';

    /**
     * Class Constructor
     *
     * @param  streamOrUrl     Stream or URL to open as a stream
     * @param  mode            Mode, only applicable if a URL is given
     */
    public function __construct($streamOrUrl, $mode = NULL)
    {
        parent::__construct($streamOrUrl, $mode = NULL);

        if ($this->isWriteBacktrace($streamOrUrl)) {
            $logDir = Mage::getBaseDir('var') . DS . 'log';
            $logFile = $logDir . DS . self::FILE_NAME_LOGBACKTRACE;
            if (!$this->_stream_backtrace = @fopen($logFile, 'a', false)) {
                #require_once 'Zend/Log/Exception.php';
                $msg = "\"$logFile\" cannot be opened with mode \"$mode\"";
                throw new Zend_Log_Exception($msg);
            }
        }
    }

    /**
     * Close the stream resource.
     *
     * @return void
     */
    public function shutdown()
    {
        parent::shutdown();

        if ($this->isWriteBacktrace() && is_resource($this->_stream_backtrace)) {
            fclose($this->_stream_backtrace);
        }
    }

    /**
     * Write a message to the log.
     *
     * @param  array $event event data
     * @return void
     */
    protected function _write($event)
    {
        parent::_write($event);

        if ($this->isWriteBacktrace()) {
            $currentUrl = Mage::helper('core/url')->getCurrentUrl();
            $line = $this->_formatter->format($event);

            $output = '';
            $debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $debug = array_slice($debug, 2);
            $formatter = new Zend_Log_Formatter_Simple(self::BACKTRACE_FORMAT . PHP_EOL);
            foreach ($debug as $index => $item) {
                $output .= "[$index] ";
                $output .= $formatter->format($item);
            }

            $message = '*****************************************' . PHP_EOL;
            $message .= $line;
            $message .= 'Current Url: '.$currentUrl . PHP_EOL;
            $message .= $output;
            $message .= '****************************************' . PHP_EOL . PHP_EOL;
            if (false === @fwrite($this->_stream_backtrace, $message)) {
                #require_once 'Zend/Log/Exception.php';
                throw new Zend_Log_Exception("Unable to write to stream");
            }
        }

    }

    /**
     * Write if file system.log
     *
     * @param null $streamOrUrl
     * @return bool|null
     */
    protected function isWriteBacktrace($streamOrUrl = null)
    {
        if (Mage::helper('uswf_logbacktrace')->isEnabled() && is_null($this->_backtrace_flag)) {
            $logDir = Mage::getBaseDir('var') . DS . 'log';
            $fileLogConfig = Mage::getStoreConfig('dev/log/file');
            $fileLogConfig = empty($fileLogConfig) ? 'system.log' : $fileLogConfig;
            $fileLogConfig = $logDir . DS . $fileLogConfig;

            ($streamOrUrl == $fileLogConfig) ? $this->_backtrace_flag = true : $this->_backtrace_flag = false;
        }

        return $this->_backtrace_flag;
    }
}
