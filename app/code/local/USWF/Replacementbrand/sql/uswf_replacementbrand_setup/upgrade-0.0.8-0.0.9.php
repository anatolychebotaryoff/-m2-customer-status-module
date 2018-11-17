<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();

$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'manufacturer', 'is_filterable', 1);
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'manufacturer', 'is_filterable_in_search', 1);
$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'manufacturer', 'position', 11);

$installer->endSetup();
