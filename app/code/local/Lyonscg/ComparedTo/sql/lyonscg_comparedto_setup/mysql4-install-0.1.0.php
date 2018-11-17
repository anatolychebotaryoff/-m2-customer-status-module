<?php
/**
 * Add new product link type
 *
 * @category   Lyons
 * @package    Lyonscg_ComparedTo
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/** Add Tier 1 Text **/
Mage::getModel('core/variable')
    ->setCode('compare_tier1_text')
    ->setName('Compare Tier 1 Text')
    ->setPlainValue('Tier 1 brand: Low-Cost Alternative')
    ->save();

/** Add Current Selection Text for Compare */
Mage::getModel('core/variable')
    ->setCode('compare_current_selection_text')
    ->setName('Compare Current Selection Text')
    ->setPlainValue('Current Selection')
    ->save();

/** Add Compare Ribbon Text */
Mage::getModel('core/variable')
    ->setCode('compare_ribbon')
    ->setName('Compare Ribbon')
    ->setPlainValue('wysiwyg/ribbon.png')
    ->save();

$installer->endSetup();
