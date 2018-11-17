<?php

/**
 * Product:       Xtento_TwoFactorAuth (1.0.8)
 * ID:            ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=
 * Packaged:      2016-07-20T14:39:11+00:00
 * Last Modified: 2012-01-26T13:49:49+01:00
 * File:          app/code/local/Xtento/TwoFactorAuth/Helper/Data.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TwoFactorAuth_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getModuleEnabled()
    {
        if (!Mage::getStoreConfigFlag('twofactorauth/general/enabled')) {
            return false;
        }
        $moduleEnabled = Mage::getModel('core/config_data')->load('twofactorauth/general/' . str_rot13('frevny'), 'path')->getValue();
        if (empty($moduleEnabled) || !$moduleEnabled || (0x28 !== strlen(trim($moduleEnabled)))) {
            return false;
        }
        return true;
    }
}