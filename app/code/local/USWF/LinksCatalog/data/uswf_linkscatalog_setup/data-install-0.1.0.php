<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

try{
    Mage::getResourceSingleton('catalog/category_flat')->reindexAll();
} catch (Exception $ex) {
    Mage::logException($ex);
}

$installer->endSetup();