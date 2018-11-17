<?php

$installer = $this;
$installer->startSetup();

$sfWebsite = Mage::getModel('core/website')->load('sf');
$configList = array(
    'onestepcheckout/general/rewrite_checkout_links' => 1
);
foreach ($configList as $path => $value) {
    Mage::getConfig()->saveConfig($path, $value, 'websites', $sfWebsite->getId());
}

$installer->endSetup();