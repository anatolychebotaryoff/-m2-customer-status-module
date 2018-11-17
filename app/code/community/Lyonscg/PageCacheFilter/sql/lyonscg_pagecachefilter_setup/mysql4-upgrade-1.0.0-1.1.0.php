<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */
 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

// Create table to store list of parameters to filter.
$installer->run("
    ALTER TABLE {$this->getTable('lyonscg_pagecachefilter_filter')} ADD COLUMN `target` TINYINT(1) NOT NULL DEFAULT 0
");

$installer->endSetup();