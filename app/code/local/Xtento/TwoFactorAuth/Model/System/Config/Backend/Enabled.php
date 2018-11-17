<?php

/**
 * Product:       Xtento_TwoFactorAuth (1.0.8)
 * ID:            ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=
 * Packaged:      2016-07-20T14:39:11+00:00
 * Last Modified: 2012-01-02T16:23:17+01:00
 * File:          app/code/local/Xtento/TwoFactorAuth/Model/System/Config/Backend/Enabled.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TwoFactorAuth_Model_System_Config_Backend_Enabled extends Mage_Core_Model_Config_Data
{
    protected function _beforeSave()
    {
        Mage::register('tfa_modify_event', true, true);
        parent::_beforeSave();
    }

    public function has_value_for_configuration_changed($observer)
    {
        if (Mage::registry('tfa_modify_event') == true) {
            Mage::unregister('tfa_modify_event');
            Xtento_TwoFactorAuth_Model_System_Config_Backend_Server::isEnabled();
        }
    }
}
