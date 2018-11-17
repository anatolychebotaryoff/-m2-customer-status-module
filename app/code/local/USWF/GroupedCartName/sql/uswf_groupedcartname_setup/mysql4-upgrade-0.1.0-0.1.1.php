<?php
/**
 *
 * @category  USWF
 * @package   GroupedCartName
 * @author    Kyle Waid
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), 'grouped_product_id', 'INT(12) NULL default NULL');
$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'grouped_product_id', 'INT(12) NULL default NULL');

$installer->endSetup();

