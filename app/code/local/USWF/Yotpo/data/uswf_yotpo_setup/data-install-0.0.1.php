<?php

$installer = $this;
$installer->startSetup();

$path = 'advanced/modules_disable_output/Mage_Review';
Mage::getConfig()->saveConfig($path, 1, 'default');

$installer->endSetup();


