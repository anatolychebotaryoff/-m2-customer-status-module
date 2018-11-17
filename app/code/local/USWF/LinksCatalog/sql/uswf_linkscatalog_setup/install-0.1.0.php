<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_category', 'category_brand', array(
    'group'             => 'General Information',
    'type'              => 'varchar',
    'backend'           => 'eav/entity_attribute_backend_array',
    'source'            => 'uswf_linkscatalog/catalog_category_attribute_source_brand',
    'frontend'          => '',
    'label'             => 'Category Brands',
    'input'             => 'multiselect',
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
    'used_in_product_listing'  => true,
    'sort_order'        => 100
));

$installer->addAttribute('catalog_category', 'category_size_advertised', array(
    'group'             => 'General Information',
    'type'              => 'int',
    'backend'           => '',
    'source'            => 'uswf_linkscatalog/catalog_category_attribute_source_sizeadvertised',
    'frontend'          => '',
    'label'             => 'Category Advertised Size (in)',
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
    'used_in_product_listing'  => true,
    'sort_order'        => 101
));

$option=array();

$option['value'] = array(
    'option_0' => array(0 => 'arsenic', 4 => 'arsenic.html'),
    'option_1' => array(0 => 'fluoride', 4 => 'fluoride.html'),
    'option_2' => array(0 => 'chloramine', 4 => 'chloramines.html'),
    'option_3' => array(0 => 'ammonia', 4 => 'ammonia.html'),
    'option_4' => array(0 => 'chlorine', 4 => 'chlorine.html'),
    'option_5' => array(0 => 'sediment', 4 => 'sediment-in-drinking-water.html'),
    'option_6' => array(0 => 'oxidized_iron', 4 => 'iron-rust-corrosion.html'),
    'option_7' => array(0 => 'lead', 4 => 'lead-in-drinking-water.html'),
    'option_8' => array(0 => 'bacteria', 4 => 'e-coli.html'),
    'option_9' => array(0 => 'cysts', 4 => 'parasitic-cysts.html'),
    'option_10' => array(0 => 'alkalinity', 4 => 'alkalinity.html'),
    'option_11' => array(0 => 'allergies', 4 => 'allergies.html'),
    'option_12' => array(0 => 'dander', 4 => 'dander.html'),
    'option_13' => array(0 => 'dust', 4 => 'dust-mites.html'),
    'option_14' => array(0 => 'pollen', 4 => 'pollen.html'),
    'option_15' => array(0 => 'mold', 4 => 'mold.html')
);

$installer->addAttribute('catalog_product', USWF_LinksCatalog_Helper_Data::CONTAMINANTS_SUBSIDIARY, array(
    'option'             => $option,
    'group'             => 'Contaminants',
    'type'              => 'varchar',
    'backend'           => '',
    'source'            => 'eav/entity_attribute_source_table',
    'frontend'          => '',
    'label'             => 'Contaminants Subsidiary',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => false,
    'required'          => false,
    'user_defined'      => false,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'used_in_product_listing'  => false,
    'sort_order'        => 101,
));


$attributeBrandId = $this->getAttribute('catalog_product', 'brand', 'attribute_id');
$installer->updateAttribute('catalog_product', $attributeBrandId, 'frontend_model', 'uswf_linkscatalog/catalog_product_attribute_frontend_brand');

$attributeBrandId = $this->getAttribute('catalog_product', 'size_advertised', 'attribute_id');
$installer->updateAttribute('catalog_product', $attributeBrandId, 'frontend_model', 'uswf_linkscatalog/catalog_product_attribute_frontend_sizeadvertised');


$attributeBrandId = $this->getAttribute('catalog_product', 'merv', 'attribute_id');
$installer->updateAttribute('catalog_product', $attributeBrandId, 'frontend_model', 'uswf_linkscatalog/catalog_product_attribute_frontend_merv');

$attributeBrandId = $this->getAttribute('catalog_product', 'mpr', 'attribute_id');
$installer->updateAttribute('catalog_product', $attributeBrandId, 'frontend_model', 'uswf_linkscatalog/catalog_product_attribute_frontend_mpr');

$installer->endSetup();
