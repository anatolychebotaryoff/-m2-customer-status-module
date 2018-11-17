<?php

/**
 * Product:       Xtento_TwoFactorAuth (1.0.8)
 * ID:            ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=
 * Packaged:      2016-07-20T14:39:11+00:00
 * Last Modified: 2014-07-27T12:53:54+02:00
 * File:          app/code/local/Xtento/TwoFactorAuth/Model/System/Config/Backend/Server.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TwoFactorAuth_Model_System_Config_Backend_Server extends Mage_Core_Model_Config_Data
{
    const VERSION = 'ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=';

    public function afterLoad()
    {
        $extId = 'Xtento_Tfa198733';
        $sPath = 'twofactorauth/general/';
        $sName1 = $this->getFirstName();
        $sName2 = $this->getSecondName();
        $this->setValue(base64_encode(base64_encode(base64_encode($extId . ';' . trim(Mage::getModel('core/config_data')->load($sPath . 'serial', 'path')->getValue()) . ';' . $sName2 . ';' . Mage::getUrl() . ';' . Mage::getSingleton('admin/session')->getUser()->getEmail() . ';' . Mage::getSingleton('admin/session')->getUser()->getName() . ';' . @$_SERVER['SERVER_ADDR'] . ';' . $sName1 . ';' . self::VERSION . ';' . Mage::getModel('core/config_data')->load($sPath . 'enabled', 'path')->getValue() . ';' . (string)Mage::getConfig()->getNode()->modules->Xtento_TwoFactorAuth->version))));
    }

    static function isEnabled()
    {
        $extId = 'Xtento_Tfa198733';
        $sPath = 'twofactorauth/general/';
        $sName = Mage::getModel('twofactorauth/system_config_backend_server')->getFirstName();
        $sName2 = Mage::getModel('twofactorauth/system_config_backend_server')->getSecondName();
        $s = Mage::getModel('core/config_data')->load($sPath . 'serial', 'path')->getValue();
        if (($s !== sha1(sha1($extId . '_' . $sName))) && $s !== sha1(sha1($extId . '_' . $sName2))) {
            Mage::getConfig()->saveConfig($sPath . 'enabled', 0);
            Mage::getConfig()->cleanCache();
            Mage::getSingleton('adminhtml/session')->addError(Xtento_TwoFactorAuth_Model_System_Config_Backend_Servername::MODULE_MESSAGE);
            return false;
        } else {
            return true;
        }
    }

    public function getFirstName()
    {
        $table = Mage::getModel('core/config_data')->getResource()->getMainTable();
        $readConn = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $readConn->select()->from($table, array('value'))->where('path = ?', 'web/unsecure/base_url')->where('scope_id = ?', 0)->where('scope = ?', 'default');
        $url = str_replace(array('http://', 'https://', 'www.'), '', $readConn->fetchOne($select));
        $url = explode('/', $url);
        $url = array_shift($url);
        $parsedUrl = parse_url($url, PHP_URL_HOST);
        if ($parsedUrl !== null) {
            return $parsedUrl;
        }
        return $url;
    }

    public function getSecondName()
    {
        $url = str_replace(array('http://', 'https://', 'www.'), '', @$_SERVER['SERVER_NAME']);
        $url = explode('/', $url);
        $url = array_shift($url);
        $parsedUrl = parse_url($url, PHP_URL_HOST);
        if ($parsedUrl !== null) {
            return $parsedUrl;
        }
        return $url;
    }
}
