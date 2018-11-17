<?php

$installer = Mage::getResourceModel('catalog/setup', 'catalog_setup');

$installer->startSetup();

//test

if (!Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'eps_image')) {
    $installer->addAttribute('catalog_product', 'eps_image', array(
        'type'                       => 'varchar',
        'label'                      => 'EPS Image',
        'input'                      => 'media_image',
        'frontend'                   => 'catalog/product_attribute_frontend_image',
        'required'                   => false,
        'sort_order'                 => 4,
        'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'used_in_product_listing'    => true,
        'group'                      => 'Images',
    ));
}

$installer->endSetup();