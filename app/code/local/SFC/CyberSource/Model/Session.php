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

class SFC_CyberSource_Model_Session extends Mage_Core_Model_Session_Abstract
{

    public function __construct()
    {
        $namespace = 'sfc_cybersource_session_data';

        $this->init($namespace);
        Mage::dispatchEvent('sfc_cybersource_session_init', array('sfc_cybersource_session' => $this));
    }

    public function getSessionId()
    {
        // Check if extension-specific session ID already created for this customer session
        if (!strlen($this->getData('sfc_cybersource_session_id'))) {
            // It wasn't already created, lets create a "extension-specific session ID" by doing an MD5 hash
            $sessionId = md5(rand(0, 100000) . '-' . microtime());
            // Now save extension-specific session ID in Magento / PHP session
            $this->setData('sfc_cybersource_session_id', $sessionId);
        }

        // Return extension-specific session ID
        return $this->getData('sfc_cybersource_session_id');
    }

}
