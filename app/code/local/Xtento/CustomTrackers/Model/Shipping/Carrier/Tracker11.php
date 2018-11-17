<?php

/**
 * Product:       Xtento_CustomTrackers (1.6.0)
 * ID:            RlVX2Xvr9DxGADvNaSvfd1jQoZge9YZz7qN69i5SEG0=
 * Packaged:      2015-05-05T19:38:19+00:00
 * Last Modified: 2014-08-20T12:40:35+02:00
 * File:          app/code/local/Xtento/CustomTrackers/Model/Shipping/Carrier/Tracker11.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_CustomTrackers_Model_Shipping_Carrier_Tracker11 extends Xtento_CustomTrackers_Model_Shipping_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'tracker11';

    public function getAllowedMethods()
    {
        return array($this->_code => $this->getConfigData('name'));
    }

    public function isTrackingAvailable()
    {
        return parent::isTrackingAvailable();
    }
}