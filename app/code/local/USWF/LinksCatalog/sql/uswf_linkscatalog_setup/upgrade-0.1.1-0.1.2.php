<?php
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$option=array();

$option['value'] = array(
    'option_0' => array(0 => 'Activated Carbon Block'),
    'option_1' => array(0 => 'Activated Carbon w Ion Exchange Resin'),
    'option_2' => array(0 => 'Anion Resin'),
    'option_3' => array(0 => 'Antimicrobial Pleated Fabric'),
    'option_4' => array(0 => 'Arsenic Selective Resin'),
    'option_5' => array(0 => 'Bonded Cellulose'),
    'option_6' => array(0 => 'Bonded Polypropylene'),
    'option_7' => array(0 => 'Calcite'),
    'option_8' => array(0 => 'Carbon Block'),
    'option_9' => array(0 => 'Carbon Wrapped'),
    'option_10' => array(0 => 'Carbon-Impregnated Fabric'),
    'option_11' => array(0 => 'Cellulose'),
    'option_12' => array(0 => 'Ceramic with Carbon'),
    'option_13' => array(0 => 'Ceramic with KDF'),
    'option_14' => array(0 => 'Ceramic with Pleated Membrane'),
    'option_15' => array(0 => 'Charcoal'),
    'option_16' => array(0 => 'Eagle Redox Alloy'),
    'option_17' => array(0 => 'Fiberglass'),
    'option_18' => array(0 => 'Fine Mesh Pre-Resin Fluoride Removal Media'),
    'option_19' => array(0 => 'Granular Activated Carbon'),
    'option_20' => array(0 => 'Hexametaphosphate Crystals'),
    'option_21' => array(0 => 'Ion Exchange Resin'),
    'option_22' => array(0 => 'Micro-Z filter media'),
    'option_23' => array(0 => 'Nylon Monofilament'),
    'option_24' => array(0 => 'Nylon Monofilament Mesh'),
    'option_25' => array(0 => 'Permanganate Treated Zeolite'),
    'option_26' => array(0 => 'Pleated Cellulose'),
    'option_27' => array(0 => 'Phosphate Crystal'),
    'option_28' => array(0 => 'Pleated Fabric'),
    'option_29' => array(0 => 'Pleated Fabric with Activated Carbon'),
    'option_30' => array(0 => 'Pleated Polyester'),
    'option_31' => array(0 => 'Polyester'),
    'option_32' => array(0 => 'Polypropylene'),
    'option_33' => array(0 => 'Radiological Filter Media'),
    'option_34' => array(0 => 'Scale Reduction media'),
    'option_35' => array(0 => 'Semi-Permeable Membrane'),
    'option_36' => array(0 => 'Sintered Ceramic'),
    'option_37' => array(0 => 'Spindown'),
    'option_38' => array(0 => 'Spun Fiberglass Filament'),
    'option_39' => array(0 => 'Stainless Steel'),
    'option_40' => array(0 => 'String-Wound Polypropylene')



);

$installer->addAttribute('catalog_product', USWF_LinksCatalog_Helper_Data::PRIMARY_FILTER_MEDIA, array(
    'option'             => $option,
    'group'             => 'Specs',
    'type'              => 'varchar',
    'backend'           => '',
    'source'            => 'eav/entity_attribute_source_table',
    'frontend'          => 'uswf_linkscatalog/catalog_product_attribute_frontend_primaryfiltermedia',
    'label'             => 'Primary Filter Media',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => true,
    'unique'            => false,
    'used_in_product_listing'  => false,
    'html_allowed_on_front' => true,
    'sort_order'        => 102,
));

$installer->endSetup();
