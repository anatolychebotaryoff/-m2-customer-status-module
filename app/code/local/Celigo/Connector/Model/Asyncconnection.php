<?php

class Celigo_Connector_Model_Asyncconnection extends Mage_Core_Model_Abstract {
    /** @var Celigo_Connector_Helper_Data */
    protected $_helper;
    const XML_PATH_ASYNC_SLEEP_TIME = 'connector/othersettings/async_sleep_time';
    /**
     * Initialize Helper
     */
    public function _construct() {
        $this->_helper = Mage::helper('connector');
    }
    private function fwriteWithRetry($sock, &$data) {
        $bytes_to_write = strlen($data);
        $bytes_written = 0;
        
        while ($bytes_written < $bytes_to_write) {
            if ($bytes_written == 0) {
                $rv = fwrite($sock, $data);
            } else {
                $rv = fwrite($sock, substr($data, $bytes_written));
            }
            if ($rv === false || $rv == 0) {
                
                return ($bytes_written == 0 ? false : $bytes_written);
            }
            $bytes_written+= $rv;
        }
        
        return $bytes_written;
    }
    public function makeAsyncCall($url, $params) {
        if (!function_exists("fsockopen")) {
            $this->_helper->addErrorMessageToLog("fsockopen function doesn't exist", Zend_Log::ERR, '', '');
            
            return false;
        }
        $numOfMaxTries = 2;
        $isAllowed = true;
        
        while ($isAllowed) {
            $isAllowed = false;
            $numOfMaxTries--;
            try {
                $returnVal = false;
                $post_string = http_build_query($params);
                $parts = parse_url($url);
                $host = $parts['host'];
                if (!isset($parts['port'])) {
                    if (isset($parts['scheme']) && $parts['scheme'] == 'https') {
                        $parts['port'] = 443;
                        $parts['host'] = "ssl://" . $parts['host'];
                    } else {
                        $parts['port'] = 80;
                    }
                }
                $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30); // Here 30 is The connection timeout, in seconds.
                if (!$fp) {
                    //Perform a synchronous call when the fsockopen function not supported / return error by the server
                    $this->_helper->addErrorMessageToLog("fsockopen {$errno}: {$errstr}", Zend_Log::ERR, '', '');
                } else {
                    $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
                    $out.= "Host: " . $host . "\r\n";
                    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
                    $out.= "Content-Length: " . strlen($post_string) . "\r\n";
                    $out.= "Connection: Close\r\n\r\n";
                    if (isset($post_string)) {
                        $out.= $post_string;
                    }
                    $rv = $this->fwriteWithRetry($fp, $out);
                    if (!$rv) {
                        fclose($fp); // Forcefully close the persistant connection
                        throw new Exception('Unable to write data to socket');
                    }
                    if ($rv != strlen($out)) {
                        fclose($fp); // Forcefully close the persistant connection
                        throw new Exception('Unable to write full data to socket');
                    }
                    $sleepTime = $this->_helper->getConfigValue(self::XML_PATH_ASYNC_SLEEP_TIME, '', '');
                    if (isset($sleepTime) && $sleepTime > 0) {
                        usleep($sleepTime);
                    }
                    fclose($fp);
                    if (isset($params['orderId'])) {
                        Mage::getSingleton('core/session')->setPaymentDetails('');
                    }
                }
                $returnVal = true;
            }
            catch(Exception $e) {
                if ($numOfMaxTries > 0) {
                    $isAllowed = true;
                    continue;
                }
                $this->_helper->addErrorMessageToLog("makeAsyncCall::Exception " . $e->getMessage() , Zend_Log::ERR, '', '');
            }
        }
        
        return $returnVal;
    }
    public function makePersistantAsyncCall($url, $params) {
        if (!function_exists("pfsockopen")) {
            $this->_helper->addErrorMessageToLog("pfsockopen function doesn't exist", Zend_Log::ERR, '', '');
            
            return false;
        }
        $numOfMaxTries = 2;
        $isAllowed = true;
        
        while ($isAllowed) {
            $isAllowed = false;
            $numOfMaxTries--;
            try {
                $returnVal = false;
                $post_string = http_build_query($params);
                $parts = parse_url($url);
                $host = $parts['host'];
                if (!isset($parts['port'])) {
                    if (isset($parts['scheme']) && $parts['scheme'] == 'https') {
                        $parts['port'] = 443;
                        $parts['host'] = "ssl://" . $parts['host'];
                    } else {
                        $parts['port'] = 80;
                    }
                }
                $fp = pfsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30); // Here 30 is The connection timeout, in seconds.
                if (!$fp) {
                    //Perform a synchronous call when the pfsockopen function not supported / return error by the server
                    $this->_helper->addErrorMessageToLog("pfsockopen {$errno}: {$errstr}", Zend_Log::ERR, '', '');
                } else {
                    $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
                    $out.= "Host: " . $host . "\r\n";
                    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
                    $out.= "Content-Length: " . strlen($post_string) . "\r\n";
                    //$out .= "Connection: Close\r\n\r\n";
                    $out.= "\r\n";
                    if (isset($post_string)) {
                        $out.= $post_string;
                    }
                    $rv = $this->fwriteWithRetry($fp, $out);
                    if (!$rv) {
                        fclose($fp); // Forcefully close the persistant connection
                        throw new Exception('Unable to write data to socket');
                    }
                    if ($rv != strlen($out)) {
                        fclose($fp); // Forcefully close the persistant connection
                        throw new Exception('Unable to write full data to socket');
                    }
                    $sleepTime = $this->_helper->getConfigValue(self::XML_PATH_ASYNC_SLEEP_TIME, '', '');
                    if (isset($sleepTime) && $sleepTime > 0) {
                        usleep($sleepTime);
                    }
                    if (isset($params['orderId'])) {
                        Mage::getSingleton('core/session')->setPaymentDetails('');
                    }
                }
                $returnVal = true;
            }
            catch(Exception $e) {
                if ($numOfMaxTries > 0) {
                    $isAllowed = true;
                    continue;
                }
                $this->_helper->addErrorMessageToLog("makeAsyncCall::Exception " . $e->getMessage() , Zend_Log::ERR, '', '');
            }
        }
        
        return $returnVal;
    }
    public function makeAsyncCurlCall($url, $params) {
        try {
            $sleepTime = $this->_helper->getConfigValue(self::XML_PATH_ASYNC_SLEEP_TIME, '', '');
            if (isset($sleepTime) && $sleepTime > 0) {
                $sleepTime = $sleepTime / 1000; // Convert micro seconds to milli seconds
                
            } else {
                $sleepTime = 1;
            }
            $encoded = http_build_query($params);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, $sleepTime);
            $output = curl_exec($ch);
            $error = curl_error($ch);
            $info = (object)curl_getinfo($ch);
            curl_close($ch);
            if ($info->http_code != 200) {
                $this->_helper->addErrorMessageToLog("makeAsyncCurlCall::Error " . $error, Zend_Log::ERR, '', '');
                
                return false;
            }
            if (isset($params['orderId'])) {
                Mage::getSingleton('core/session')->setPaymentDetails('');
            }
        }
        catch(Exception $e) {
            $this->_helper->addErrorMessageToLog("makeAsyncCall::Exception " . $e->getMessage() , Zend_Log::ERR, '', '');
        }
        
        return true;
    }
}
