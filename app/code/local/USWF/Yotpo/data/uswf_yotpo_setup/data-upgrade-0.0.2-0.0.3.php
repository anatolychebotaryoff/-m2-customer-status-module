<?php

$installer = $this;
$installer->startSetup();

$configList = array(
    'yotpo/yotpo_general_group/disable_default_widget_position' => 1
);
foreach ($configList as $path => $value) {
    foreach (Mage::app()->getStores() as $store) {
        Mage::getConfig()->saveConfig($path, $value, 'stores', $store->getId());
    }
}

$installer->endSetup();
