<?php
/**
 * Attributes for Filter Finder
 *
 * @category     Lyonscg
 * @package      Lyonscg_Usff
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Yuriy Scherba (yscherba@lyonsg.com)
 */


$installer = $this;
$installer->startSetup();

$objCatalogEavSetup = Mage::getResourceModel('catalog/setup','catalog_setup');
$group = 'Filter Finder';
$attr_set = 'Fridge Filters';

///******************** Brand Attribute  *********************///
$attrCode = 'filter_finder_brand';
$attrLabel = 'Filter Finder Brands';
if (!$objCatalogEavSetup->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $attrCode)) {
    $objCatalogEavSetup->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attrCode, array(
        'type' => 'varchar',
        'group' => $group,
        'attribute_set' => $attr_set,
        'backend' => 'eav/entity_attribute_backend_array',
        'frontend' => '',
        'label' => $attrLabel,
        'input' => 'multiselect',
        'class' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => '0',
        'visible_on_front' => false,
        'unique' => false,
        'is_configurable' => false,
        'filterable' => 1,
        'used_for_promo_rules' => true
    ));
}

///******************** Style Attribute  *********************///
$attrCode = 'filter_finder_style';
$attrLabel = 'Filter Finder Style';
if (!$objCatalogEavSetup->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $attrCode)) {
    $objCatalogEavSetup->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attrCode, array(
        'type' => 'varchar',
        'group' => $group,
        'attribute_set' => $attr_set,
        'backend' => 'eav/entity_attribute_backend_array',
        'frontend' => '',
        'label' => $attrLabel,
        'input' => 'multiselect',
        'class' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => '0',
        'visible_on_front' => false,
        'unique' => false,
        'filterable' => 1,
        'is_configurable' => false,
        'used_for_promo_rules' => true
    ));
}

///******************** Location Attribute  *********************///
$attrCode = 'filter_finder_location';
$attrLabel = 'Filter Finder Location';
if (!$objCatalogEavSetup->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $attrCode)) {
    $objCatalogEavSetup->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attrCode, array(
        'type' => 'varchar',
        'group' => $group,
        'attribute_set' => $attr_set,
        'backend' => 'eav/entity_attribute_backend_array',
        'frontend' => '',
        'label' => $attrLabel,
        'input' => 'multiselect',
        'class' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => '0',
        'visible_on_front' => false,
        'unique' => false,
        'filterable' => 1,
        'is_configurable' => false,
        'used_for_promo_rules' => true
    ));
}

///******************** Removal Attribute  *********************///
$attrCode = 'filter_finder_removal';
$attrLabel = 'Filter Finder Removal';
if (!$objCatalogEavSetup->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $attrCode)) {
    $objCatalogEavSetup->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attrCode, array(
        'type' => 'varchar',
        'group' => $group,
        'attribute_set' => $attr_set,
        'backend' => 'eav/entity_attribute_backend_array',
        'frontend' => '',
        'label' => $attrLabel,
        'input' => 'multiselect',
        'class' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => '0',
        'visible_on_front' => false,
        'unique' => false,
        'filterable' => 1,
        'is_configurable' => false,
        'used_for_promo_rules' => true
    ));
}

$installer->endSetup();