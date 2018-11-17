<?php

/**
 * Product:       Xtento_CustomTrackers (1.6.0)
 * ID:            RlVX2Xvr9DxGADvNaSvfd1jQoZge9YZz7qN69i5SEG0=
 * Packaged:      2015-05-05T19:38:19+00:00
 * Last Modified: 2012-02-10T00:36:52+01:00
 * File:          app/code/local/Xtento/CustomTrackers/Model/Shipping/Carrier/Tracker1.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_CustomTrackers_Model_Shipping_Carrier_Tracker1 extends Xtento_CustomTrackers_Model_Shipping_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'tracker1';

    public function getAllowedMethods()
    {
        return array($this->_code => $this->getConfigData('name'));
    }

    public function isTrackingAvailable()
    {
        return parent::isTrackingAvailable();
    }
}