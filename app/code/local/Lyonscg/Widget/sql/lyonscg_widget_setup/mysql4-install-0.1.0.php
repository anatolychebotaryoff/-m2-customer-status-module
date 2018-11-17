<?php
/**
 * Installer to add new CMS Block to admin panel
 *
 * @category   Lyons
 * @package    Lyonscg_Widget
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/* Add new static block for store 4 (DWF) */
$staticBlock = array(
    'title'         =>  'Subcategories Display',
    'identifier'    =>  'subcategories_display',
    'content'       =>  '{{widget type="lyonscg_widget/category" widget_type="sub_category"}}',
    'is_active'     =>  1,
    'stores'        =>  array(4),
);

Mage::getModel('cms/block')->setData($staticBlock)->save();

$installer->endSetup();