<?php

/**
 * Product:       Xtento_CustomTrackers (1.6.0)
 * ID:            RlVX2Xvr9DxGADvNaSvfd1jQoZge9YZz7qN69i5SEG0=
 * Packaged:      2015-05-05T19:38:19+00:00
 * Last Modified: 2012-01-23T13:22:41+01:00
 * File:          app/code/local/Xtento/CustomTrackers/Model/System/Config/Backend/Import/Enabled.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_CustomTrackers_Model_System_Config_Backend_Import_Enabled extends Mage_Core_Model_Config_Data
{
    protected function _beforeSave()
    {
        Mage::register('customtrackers_modify_event', true, true);
        parent::_beforeSave();
    }

    public function has_value_for_configuration_changed($observer)
    {
        if (Mage::registry('customtrackers_modify_event') == true) {
            Mage::unregister('customtrackers_modify_event');
            Xtento_CustomTrackers_Model_System_Config_Source_Order_Status::isEnabled();
        }
    }
}
