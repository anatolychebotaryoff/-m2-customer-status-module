<?php

/**
 * Product:       Xtento_TwoFactorAuth (1.0.8)
 * ID:            ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=
 * Packaged:      2016-07-20T14:39:11+00:00
 * Last Modified: 2012-01-02T16:40:11+01:00
 * File:          app/code/local/Xtento/TwoFactorAuth/Model/System/Config/Backend/Servername.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TwoFactorAuth_Model_System_Config_Backend_Servername extends Mage_Core_Model_Config_Data
{
    const MODULE_MESSAGE = 'The Two-Factor Authentication extension couldn\'t be enabled. Please make sure you are using a valid license key.';

    public function afterLoad()
    {
        $sName1 = Mage::getModel('twofactorauth/system_config_backend_server')->getFirstName();
        $sName2 = Mage::getModel('twofactorauth/system_config_backend_server')->getSecondName();
        if ($sName1 !== $sName2) {
            $this->setValue(sprintf('%s (Main: %s)', $sName1, $sName2));
        } else {
            $this->setValue(sprintf('%s', $sName1));
        }
    }
}
