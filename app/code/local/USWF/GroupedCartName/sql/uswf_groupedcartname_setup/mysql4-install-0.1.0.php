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

$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), 'nfs_item', 'INT(1) NULL default NULL');
$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'nfs_item', 'INT(1) NULL default NULL');

$installer = $this;

if (!$installer->getAttributeId('catalog_product', 'nfs_product')) {
    $installer->addAttribute('catalog_product', 'nfs_product', array(
        'group' => 'General',
        'label' => 'NFS Product Cart Display',
        'type' => 'int',
        'input' => 'boolean',
        'default' => '0',
        'class' => '',
        'backend' => '',
        'frontend' => '',
        'source' => 'eav/entity_attribute_source_boolean',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible' => true,
        'required' => false,
        'apply_to' => 'grouped',
        'user_defined' => false,
        'searchable' => false,
        'filterable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'visible_in_advanced_search' => false,
        'unique' => false
    ));
}

$installer->endSetup();

