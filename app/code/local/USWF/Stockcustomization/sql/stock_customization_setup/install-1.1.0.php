<?php
 
$installer = $this;
 
$installer->startSetup();
 
$table = $installer->getConnection()
->addColumn($installer->getTable('cataloginventory/stock_item'),'expected_ship_interval', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => true,
    'length'    => 255,
    'after'     => null, // column name to insert new column after
    'comment'   => 'Expected Ship Date'
    ));

$installer->endSetup();
