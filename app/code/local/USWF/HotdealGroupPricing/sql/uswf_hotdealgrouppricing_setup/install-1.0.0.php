<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
	->addColumn('catalog_product_entity_group_price', 'isfixed', array(
		'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		'unsigned' => true,
		'nullable' => false,
		'default' => '1',
		'comment' => 'Pricing Type',
	));

$table = $installer->getConnection()
	->addColumn('catalog_product_entity_tier_price', 'isfixed', array(
		'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		'unsigned' => true,
		'nullable' => false,
		'default' => '1',
		'comment' => 'Pricing Type',
	));

$installer->endSetup();