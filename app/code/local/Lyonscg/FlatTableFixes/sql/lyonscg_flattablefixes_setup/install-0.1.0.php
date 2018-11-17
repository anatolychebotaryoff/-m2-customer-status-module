<?php
/**
 * install-0.1.0.php
 *
 * @category    Lyonscg
 * @package     Lyonscg_FlatTableFixes
 * @author      Logan Montgomery (lmontgomery@lyonscg.com)
 * @copyright   2015 Lyonscg
 *
 * This converts the instructions_step_* attributes to text from varchar
 * copying the data over then cleaning up the old varchar data.
 */

/** @var Mage_Eav_Model_Entity_Setup $installer */
$installer = $this;

$installer->startSetup();

$attributesToChange = array(
    'instructions_step_1',
    'instructions_step_2',
    'instructions_step_3',
    'instructions_step_4',
    'instructions_step_5',
    'instructions_step_6',
    'instructions_step_7',
    'instructions_step_8',
    'instructions_step_9',
    'instructions_step_10',
);

$entityTypeId = $installer->getEntityTypeId('catalog_product');

$prodMod = Mage::getModel('catalog/product');
$prodRes = $prodMod->getResource();

// figure out tables
$prefix = Mage::getConfig()->getTablePrefix();
$varcharTable = $prefix.'catalog_product_entity_varchar';
$textTable = $prefix.'catalog_product_entity_text';

$attributeIds = array();

foreach ($attributesToChange as $attrCode)
{
    $attr = Mage::getSingleton('eav/config')->getCollectionAttribute($prodRes->getType(), $attrCode);
    $attributeIds[] = $attr->getAttributeId();
}

$attrInString = ' ('.join(',', $attributeIds).') ';

// convert each instructions_step_* attribute to text from varchar
foreach ($attributesToChange as $attr)
{
    $attrId = $installer->getAttribute($entityTypeId, $attr, 'attribute_id');
    $installer->updateAttribute($entityTypeId, $attrId, array(
        'backend_type' => 'text',
        'frontend_input' => 'textarea',
    ));
}

$installer->run("
    INSERT INTO $textTable (`entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value`)
    SELECT `entity_type_id`, `attribute_id`, `store_id`, `entity_id`, `value` FROM $varcharTable WHERE `attribute_id` IN $attrInString;
");

// delete all of the old attribute entries
$installer->run("
    DELETE FROM $varcharTable WHERE attribute_id IN $attrInString;
");

$installer->endSetup();