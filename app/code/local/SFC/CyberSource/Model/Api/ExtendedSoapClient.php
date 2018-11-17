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

class SFC_CyberSource_Model_Api_ExtendedSoapClient extends SoapClient
{
    /**
     * Members to hold credentials
     */
    protected $user;
    protected $password;

    /**
     * XPaths that should be replaced in debug with '***'
     *
     * @var array
     */
    protected $_debugReplacePrivateDataXPaths = array(
        '//*[contains(name(),\'merchantID\')]/text()',
        '//*[contains(name(),\'card\')]/*/text()',
        '//*[contains(name(),\'UsernameToken\')]/*/text()'
    );

    public function __construct($wsdl, $options, $user, $password)
    {
        // Save credentials
        $this->user = $user;
        $this->password = $password;
        // Call parent construction
        parent::__construct($wsdl, $options);
    }

    public function __doRequest($request, $location, $action, $version, $oneWay = 0)
    {
        // Build header
        $user = $this->user;
        $password = $this->password;
        $soapHeader =
            "<SOAP-ENV:Header xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\"><wsse:Security SOAP-ENV:mustUnderstand=\"1\"><wsse:UsernameToken><wsse:Username>$user</wsse:Username><wsse:Password Type=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText\">$password</wsse:Password></wsse:UsernameToken></wsse:Security></SOAP-ENV:Header>";

        // Build request XML
        $requestDOM = new DOMDocument('1.0');
        $soapHeaderDOM = new DOMDocument('1.0');
        $requestDOM->loadXML($request);
        $soapHeaderDOM->loadXML($soapHeader);
        $node = $requestDOM->importNode($soapHeaderDOM->firstChild, true);
        $requestDOM->firstChild->insertBefore($node, $requestDOM->firstChild->firstChild);
        $request = $requestDOM->saveXML();

        // Build sanitized XML for logging
        $requestDOMXPath = new DOMXPath($requestDOM);
        foreach ($this->_debugReplacePrivateDataXPaths as $xPath) {
            foreach ($requestDOMXPath->query($xPath) as $element) {
                $element->data = '***';
            }
        }
        // Log
        Mage::log('XML request: ', Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);
        Mage::log($requestDOM->saveXML(), Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        try {
            // Now issue request
            $response = parent::__doRequest($request, $location, $action, $version, $oneWay);
        }
        catch (Exception $e) {
            Mage::log('Exception caught while issuing SOAP request!', Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);
            Mage::log('Error: ' . $e->getMessage(), Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);
            throw $e;
        }

        return $response;
    }
}
