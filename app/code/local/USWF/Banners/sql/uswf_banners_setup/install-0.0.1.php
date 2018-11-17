<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run('
    DELETE FROM ' . $installer->getTable('core_config_data') . '  WHERE PATH LIKE "uswf_banners/%"
');

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'pdp_banner', array(
    'group'                     => 'General',
    'backend'                   => '',
    'frontend'                  => '',
    'label'                     => 'PDP Banner',
    'input'                     => 'select',
    'type'                      => 'varchar',
    'source'                    => 'eav/entity_attribute_source_boolean',
    'global'                    => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'                   => 1,
    'required'                  => 0,
    'user_defined'              => true,
    'source'                    => 'uswf_banners/source_pdp_banners'
));

$installer->endSetup();