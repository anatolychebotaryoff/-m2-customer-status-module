<?php
/**
 * Subscribe Pro - Subscriptions Management Extension
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of SUBSCRIBE PRO INC.
 *
 * @category  SFC
 * @package   SFC_Autoship
 * @author    Garth Brantley <garth@subscribepro.com>
 * @copyright 2009-2016 SUBSCRIBE PRO INC. All Rights Reserved.
 * @license   http://www.subscribepro.com/terms-of-service/ Subscribe Pro Terms of Service
 * @link      http://www.subscribepro.com/
 *
 */

/**
 * Class SFC_Autoship
 *      Static methods for logging, used throughout the module.
 */
class SFC_Autoship
{

    public static function log($message, $level = Zend_Log::INFO, $file = SFC_Autoship_Helper_Data::LOG_FILE, $forceLog = false)
    {
        if ($level <= Mage::getStoreConfig('autoship_general/platform_api/log_level')) {
            Mage::log($message, $level, $file, $forceLog);
        }
    }

    public static function logException(Exception $e)
    {
        Mage::logException($e);
    }

    /**
     * Output the current call stack as string to module log file
     */
    public static function logCallStack()
    {
        $exception = new Exception;
        self::logGeneral("Current call stack:\n" . $exception->getTraceAsString(), Zend_Log::DEBUG);
    }

    public static function logApi($message, $level = null)
    {
        self::log($message, $level, SFC_Autoship_Helper_Data::API_LOG_FILE);
    }

    public static function logGeneral($message, $level = null)
    {
        self::log($message, $level, SFC_Autoship_Helper_Data::LOG_FILE);
    }

}
