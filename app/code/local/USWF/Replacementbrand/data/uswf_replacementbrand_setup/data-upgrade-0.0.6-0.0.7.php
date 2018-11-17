<?php

$installer = $this;
$installer->startSetup();

$rbWebsite = Mage::getModel('core/website')->load('rb');
$configList = array(
    'design/footer/copyright' => '© 2015 ReplacementBrand.com. All Rights Reserved  Worldwide.',
);
foreach ($configList as $path => $value) {
    Mage::getConfig()->saveConfig($path, $value, 'websites', $rbWebsite->getId());
}

$installer->endSetup();
