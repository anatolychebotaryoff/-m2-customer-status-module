<?php
/**
 * Category for filter finder on discount store
 *
 * @category     Lyonscg
 * @package      Lyonscg_FilterFinder
 * @copyright    Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author       Ashutosh Potdar (apotdar@lyonsg.com)
 */
$installer = $this;
$installer->startSetup();
// Create the table lyonscg_filterfinder
$table = $installer->getConnection()
        ->newTable($installer->getTable('lyonscg_filterfinder'))
        ->addColumn('filterfinder_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
                ), 'Id')
        ->addColumn('product_entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => false,
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
                ), 'PRODUCT ENTITY ID')
        ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => false,
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
                ), 'WEBSITE ID')
        ->addColumn('filter_finder_brand', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => false,
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
                ), 'Brand')
        ->addColumn('filter_finder_style', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => false,
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
                ), 'Style')
        ->addColumn('filter_finder_location', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => false,
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
                ), 'Location')
        ->addColumn('filter_finder_removal', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => false,
            'unsigned' => true,
            'nullable' => false,
            'primary' => false,
        ), 'Removal');
$installer->getConnection()->createTable($table);
$installer->endSetup();
