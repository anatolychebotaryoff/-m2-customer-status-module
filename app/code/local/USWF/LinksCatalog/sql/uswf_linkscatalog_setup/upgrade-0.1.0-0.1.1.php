<?php
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();
$attribute = $installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, USWF_LinksCatalog_Helper_Data::CONTAMINANTS_SUBSIDIARY);
$attributeSetIds = $installer->getAllAttributeSetIds(Mage_Catalog_Model_Product::ENTITY);
foreach ($attributeSetIds as $setId) {
    $installer->addAttributeToGroup(
        Mage_Catalog_Model_Product::ENTITY,
        $setId,
        'General',
        $attribute['attribute_id'],
        101
    );
}

$installer->endSetup();