<?php

$installer = $this;
$installer->startSetup();

$rbWebsite = Mage::getModel('core/website')->load('rb');
$configList = array(
    'catalog/frontend/grid_per_page_values' => '9,15,30',
    'catalog/frontend/grid_per_page' => '9',
    'catalog/frontend/list_per_page_values' => '9,15,30',
    'catalog/frontend/list_per_page' => '9'
);
foreach ($configList as $path => $value) {
    Mage::getConfig()->saveConfig($path, $value, 'websites', $rbWebsite->getId());
}

$installer->endSetup();
