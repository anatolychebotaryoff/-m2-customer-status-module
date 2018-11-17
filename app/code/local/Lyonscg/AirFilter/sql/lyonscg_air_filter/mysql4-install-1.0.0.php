<?php
/**
 * Install script for adding attribute to model
 *
 * @category     Lyonscg
 * @package      Lyonscg_AirFilter
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Yuriy Scherba (yscherba@lyonsg.com)
 */

$this->startSetup();
$this->addAttribute('catalog_category', 'air_filter_enabled', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'varchar',
    'label'         => 'Show this category in Air Filter brand section?',
    'backend'       => '',
    'visible'       => true,
    'required'      => false,
    'visible_on_front' => true,
    'default'           => 0,
    'source'    =>  'eav/entity_attribute_source_boolean',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
));

$this->endSetup();