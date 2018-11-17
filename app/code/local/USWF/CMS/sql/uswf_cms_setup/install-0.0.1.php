<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn(
    $installer->getTable('cms/page'), 
    'show_cms_breadcrumbs', 
    "tinyint(1) NOT NULL DEFAULT 0"
);

$installer->endSetup();