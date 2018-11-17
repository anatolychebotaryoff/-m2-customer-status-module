<?php

$installer = $this;
$installer->startSetup();

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'uswf_featured', array(
    'label' => 'USWF featured',
    'type' => 'int',
    'input' => 'select',
    'source' => 'eav/entity_attribute_source_boolean',
    'group' => 'General',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'searchable' => false,
    'visible_in_advanced_search' => false,
    'visible_on_front' => false,
    'visible' => true,
    'required' => false,
    'position' => 0,
));

$installer->endSetup();
