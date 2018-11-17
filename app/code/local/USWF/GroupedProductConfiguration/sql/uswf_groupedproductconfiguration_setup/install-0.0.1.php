<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
/*$priceIndexerTables =  array(
    'catalog/product_price_indexer_option_aggregate_idx',
    'catalog/product_price_indexer_option_aggregate_tmp',
    'catalog/product_price_indexer_option_idx',
    'catalog/product_price_indexer_option_tmp',
    'catalog/product_price_indexer_idx',
    'catalog/product_price_indexer_tmp',
    'catalog/product_price_indexer_cfg_option_aggregate_idx',
    'catalog/product_price_indexer_cfg_option_aggregate_tmp',
    'catalog/product_price_indexer_cfg_option_idx',
    'catalog/product_price_indexer_cfg_option_tmp',
    'catalog/product_index_price',
    'catalog/product_price_indexer_final_idx',
    'catalog/product_price_indexer_final_tmp'
);*/
$priceIndexerTables =  array(
    'catalog/product_index_price',
    'catalog/product_price_indexer_idx',
    'catalog/product_price_indexer_tmp',
    'bundle/price_indexer_idx',
    'bundle/price_indexer_tmp',
    'catalog/product_price_indexer_final_idx',
    'catalog/product_price_indexer_final_tmp'
);

foreach ($priceIndexerTables as $table) {
    //$installer->getConnection()->dropColumn($installer->getTable($table), 'min_unit_price');
    $installer->getConnection()->addColumn($installer->getTable($table), 'min_unit_price', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_DECIMAL,
        'length'    => '12,4',
        'comment'   => 'Minimal unit price',
    ));
}

$installer->endSetup();