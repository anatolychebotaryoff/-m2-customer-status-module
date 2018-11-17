<?php
/**
 * Installer to add new product attribute
 *
 * @category   Lyons
 * @package    Lyonscg_Catalog
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Valentin Ponomarenko (vponomarenko@lyonscg.com)
 */ 
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'product_options', array(
        'type'              => 'text',
        'backend'           => '',
        'frontend'          => '',
        'label'             => 'Product Options',
        'input'             => 'text',
        'class'             => '',
        'source'            => '',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'           => true,
        'required'          => false,
        'user_defined'      => false,
        'default'           => '',
        'searchable'        => false,
        'filterable'        => false,
        'comparable'        => false,
        'visible_on_front'  => false,
        'unique'            => false,
        'apply_to'          => 'simple,configurable,bundle,grouped'
    ));

$installer->updateAttribute('catalog_product', 'product_options', 'used_in_product_listing', true);

$installer->endSetup();