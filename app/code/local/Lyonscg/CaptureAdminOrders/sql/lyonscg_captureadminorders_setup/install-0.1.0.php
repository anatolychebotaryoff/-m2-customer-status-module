<?php
/**
 * USWF New Admin Attributes Installer
 *
 * @category    Lyonscg
 * @package     Lyonscg_CaptureAdminOrders
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author      Ashutosh Potdar (apotdar@lyonscg.com)
 */

/* @var $installer Mage_Customer_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

// Add columns to the sales_flat_quote and sales_flat_order tables.
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote'),
    'admin_username', 'varchar(50) default null');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote'),
    'admin_userid', 'varchar(20) default null');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_order'),
    'admin_username', 'varchar(50) default null');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_order'),
    'admin_userid', 'varchar(20) default null');

/* save the setup */
$installer->endSetup();