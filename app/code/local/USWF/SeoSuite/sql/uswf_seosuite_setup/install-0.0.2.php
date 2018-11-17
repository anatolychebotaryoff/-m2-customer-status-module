<?php

$installer = $this;
 
$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('cms_page'), 'cms_canonical_url')) {
    $installer->getConnection()->addColumn($installer->getTable('cms_page'), 'cms_canonical_url', 'varchar(255) NOT NULL');
}

$installer->addAttribute('catalog_category', 'category_canonical_url', array(
    'group'             => 'General Information',
    'type'              => 'text',
    'backend'           => 'uswf_seosuite/catalog_category_attribute_backend_meta_canonical',
    'source'            => 'uswf_seosuite/catalog_category_attribute_source_meta_canonical',
    'frontend'          => '',
    'label'             => 'Canonical URL',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'sort_order'        => 61
));
 
$installer->endSetup();