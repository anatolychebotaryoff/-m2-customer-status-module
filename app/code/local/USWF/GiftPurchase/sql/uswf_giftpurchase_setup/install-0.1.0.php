<?php
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer->startSetup();

$connection                      = $installer->getConnection();
$rulesTable                      = $installer->getTable('uswf_giftpurchase/rule');
$rulesProductTable               = $installer->getTable('uswf_giftpurchase/rule_product');
$rulesWebsitesTable              = $installer->getTable('uswf_giftpurchase/website');
$rulesCustomerGroupsTable        = $installer->getTable('uswf_giftpurchase/customer_group');
$giftProductTable               = $installer->getTable('uswf_giftpurchase/gift_product');

$websitesTable       = $installer->getTable('core/website');
$customerGroupsTable = $installer->getTable('customer/customer_group');

/**
 * Create table 'uswf_giftpurchase/rule'
 */
if (!$connection->isTableExists($rulesTable)) {
    $table = $installer->getConnection()
        ->newTable($rulesTable)
        ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Rule Id')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Name')
        ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Description')
        ->addColumn('from_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'From Date')
        ->addColumn('to_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'To Date')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Is Active')
        ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        ), 'Conditions Serialized')
        ->addColumn('stop_rules_processing', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), 'Stop Rules Processing')
        ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'Sort Order')
        ->addColumn('gift_product_sku', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ),
            'Gift Product Sku'
        )
        ->addColumn('gift_product_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '1',
        ),
            'Gift Product Qty'
        )
        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule', array('is_active', 'sort_order', 'to_date', 'from_date')),
            array('is_active', 'sort_order', 'to_date', 'from_date'))
        ->setComment('Gift Purchase');
    $connection->createTable($table);
}

/**
 * Create table 'uswf_giftpurchase/rule_product'
 */
if (!$connection->isTableExists($rulesProductTable)) {
    $table = $installer->getConnection()
        ->newTable($rulesProductTable)
        ->addColumn('rule_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Rule Product Id')
        ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'Rule Id')
        ->addColumn('from_time', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'From Time')
        ->addColumn('to_time', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'To time')
        ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'Customer Group Id')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'Product Id')
        ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ), 'Sort Order')
        ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Website Id')

        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule_product', array('rule_id', 'from_time', 'to_time', 'website_id', 'customer_group_id', 'product_id', 'sort_order'), true),
            array('rule_id', 'from_time', 'to_time', 'website_id', 'customer_group_id', 'product_id', 'sort_order'), array('type' => 'unique'))

        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule_product', array('rule_id')),
            array('rule_id'))
        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule_product', array('customer_group_id')),
            array('customer_group_id'))
        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule_product', array('website_id')),
            array('website_id'))
        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule_product', array('from_time')),
            array('from_time'))
        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule_product', array('to_time')),
            array('to_time'))
        ->addIndex($installer->getIdxName('uswf_giftpurchase/rule_product', array('product_id')),
            array('product_id'))

        ->addForeignKey($installer->getFkName('uswf_giftpurchase/rule_product', 'product_id', 'catalog/product', 'entity_id'),
            'product_id', $installer->getTable('catalog/product'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->addForeignKey($installer->getFkName('uswf_giftpurchase/rule_product', 'customer_group_id', 'customer/customer_group', 'customer_group_id'),
            'customer_group_id', $installer->getTable('customer/customer_group'), 'customer_group_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->addForeignKey($installer->getFkName('uswf_giftpurchase/rule_product', 'rule_id', 'uswf_giftpurchase/rule', 'rule_id'),
            'rule_id', $installer->getTable('uswf_giftpurchase/rule'), 'rule_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->addForeignKey($installer->getFkName('uswf_giftpurchase/rule_product', 'website_id', 'core/website', 'website_id'),
            'website_id', $installer->getTable('core/website'), 'website_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->setComment('Gift Purchase Product');

    $connection->createTable($table);
}

/**
 * Create table 'uswf_giftpurchase/website' if not exists. This table will be used instead of
 * column website_ids of main catalog rules table
 */
if (!$connection->isTableExists($rulesWebsitesTable)) {
    $table = $connection->newTable($rulesWebsitesTable)
        ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
        ),
            'Rule Id'
        )
        ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
        ),
            'Website Id'
        )
        ->addIndex(
            $installer->getIdxName('uswf_giftpurchase/website', array('rule_id')),
            array('rule_id')
        )
        ->addIndex(
            $installer->getIdxName('uswf_giftpurchase/website', array('website_id')),
            array('website_id')
        )
        ->addForeignKey($installer->getFkName('uswf_giftpurchase/website', 'rule_id', 'uswf_giftpurchase/rule', 'rule_id'),
            'rule_id', $rulesTable, 'rule_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->addForeignKey($installer->getFkName('uswf_giftpurchase/website', 'website_id', 'core/website', 'website_id'),
            'website_id', $websitesTable, 'website_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Gift Purchase To Websites Relations');

    $connection->createTable($table);
}

/**
 * Create table 'uswf_giftpurchase/customer_group' if not exists. This table will be used instead of
 * column customer_group_ids of main catalog rules table
 */
if (!$connection->isTableExists($rulesCustomerGroupsTable)) {
    $table = $connection->newTable($rulesCustomerGroupsTable)
        ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
        ),
            'Rule Id'
        )
        ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
        ),
            'Customer Group Id'
        )
        ->addIndex(
            $installer->getIdxName('uswf_giftpurchase/customer_group', array('rule_id')),
            array('rule_id')
        )
        ->addIndex(
            $installer->getIdxName('uswf_giftpurchase/customer_group', array('customer_group_id')),
            array('customer_group_id')
        )
        ->addForeignKey($installer->getFkName('uswf_giftpurchase/customer_group', 'rule_id', 'uswf_giftpurchase/rule', 'rule_id'),
            'rule_id', $rulesTable, 'rule_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->addForeignKey(
            $installer->getFkName('uswf_giftpurchase/customer_group', 'customer_group_id',
                'customer/customer_group', 'customer_group_id'
            ),
            'customer_group_id', $customerGroupsTable, 'customer_group_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Gift Purchase To Customer Groups Relations');

    $connection->createTable($table);
}


$installer->endSetup();
