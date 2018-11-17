<?php
/**
 * Add column to sales_flat_quote and sales_flat_order table for hotdeals
 *
 * @category  Lyons
 * @package   Lyonscg_Hotdeal
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), 'hotdeal', 'INT(1) NULL default NULL');
$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'hotdeal', 'INT(1) NULL default NULL');

$installer->endSetup();
