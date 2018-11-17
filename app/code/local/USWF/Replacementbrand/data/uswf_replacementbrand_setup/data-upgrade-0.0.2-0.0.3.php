<?php

$installer = $this;
$installer->startSetup();

$rbWebsite = Mage::getModel('core/website')->load('rb');
$configList = array(
    'design/header/logo_src' => 'images/logo.png',
    'design/header/logo_alt' => 'ReplacementBrand.com',
    'design/header/welcome' => ''
);
foreach ($configList as $path => $value) {
    Mage::getConfig()->saveConfig($path, $value, 'websites', $rbWebsite->getId());
}

$installer->endSetup();
