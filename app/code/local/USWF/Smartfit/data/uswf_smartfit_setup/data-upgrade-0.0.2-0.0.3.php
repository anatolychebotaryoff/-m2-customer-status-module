<?php

$installer = $this;
$installer->startSetup();

Mage::getConfig()->saveConfig('megamenu/mainmenu/enabled', 0);

$sfWebsite = Mage::getModel('core/website')->load('sf');
$configList = array(
    'design/header/logo_src' => 'images/smartfit_Logo-01.png',
    'design/header/logo_alt' => 'SmartFIT.com',
    'design/header/welcome' => '',
    'megamenu/mainmenu/enabled' => 1
);
foreach ($configList as $path => $value) {
    Mage::getConfig()->saveConfig($path, $value, 'websites', $sfWebsite->getId());
}

$installer->endSetup();
