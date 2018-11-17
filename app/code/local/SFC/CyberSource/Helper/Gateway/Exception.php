<?php
/**
 * StoreFront CyberSource Tokenized Payment Extension for Magento
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of StoreFront Consulting, Inc.
 *
 * @category  SFC
 * @package   SFC_CyberSource
 * @author    Garth Brantley <garth@storefrontconsulting.com>
 * @copyright 2009-2013 StoreFront Consulting, Inc. All Rights Reserved.
 * @license   http://www.storefrontconsulting.com/media/downloads/ExtensionLicense.pdf StoreFront Consulting Commercial License
 * @link      http://www.storefrontconsulting.com/cybersource-saved-credit-cards-extension-for-magento/
 *
 */

class SFC_CyberSource_Helper_Gateway_Exception extends Mage_Core_Exception
{
    /**
     * @var null|stdClass
     */
    private $_response = null;

    /**
     * @param string $message
     * @param null|stdClass $response
     */
    public function __construct($message, $response = null)
    {
        // Save response object with full output from gateway API
        $this->_response = $response;
        // Call parent constructor
        parent::__construct($message, 0);
    }

    /**
     * @param stdClass $response
     */
    public function setResponse(stdClass $response)
    {
        $this->_response = $response;
    }

    /**
     * @return stdClass|null
     */
    public function getResponse()
    {
        return $this->_response;
    }

}
