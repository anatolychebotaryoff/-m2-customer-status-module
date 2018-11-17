<?php
/**
 * Add new product link type
 *
 * @category   Lyons
 * @package    Lyonscg_ReplacedBy
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
    INSERT INTO `{$installer->getTable('catalog/product_link_type')}` VALUES (6, 'replaced_by');
    INSERT INTO `{$installer->getTable('catalog/product_link_attribute')}` VALUES(null, 6, 'position', 'int');
");

$installer->endSetup();