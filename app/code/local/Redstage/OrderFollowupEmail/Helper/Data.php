<?php

class Redstage_OrderFollowupEmail_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Log file for logs
     * @var string
     */
    protected $_logFile = 'orderfollowupemail.log';

    /**
     * Enabled Logging Variable
     * @var bool
     */
    protected $_loggingEnabled = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_loggingEnabled = Mage::getStoreConfig('orderfollowupemail/settings/log');
    }

    /**
     * Log function to log to file if logging is enabled
     *
     * @param $string
     */
    public function log( $string ){
		// write to log file
        if ($this->_loggingEnabled) {
            Mage::log($string, null, $this->_logFile);
        }
	}

}

?>