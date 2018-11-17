<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();

$installer->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'replacement_brand_home', array(
    'group'             => 'General',
    'input'             => 'select',
    'type'              => 'varchar',
    'label'             => 'Show this category on replacement brand home page ?',
    'backend'           => '',
    'visible'           => true,
    'required'          => false,
    'visible_on_front'  => true,
    'default'           => 0,
    'source'            => 'eav/entity_attribute_source_boolean',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
));

$installer->endSetup();
