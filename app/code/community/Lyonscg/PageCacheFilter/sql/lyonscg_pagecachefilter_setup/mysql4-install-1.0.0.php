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
    CREATE TABLE IF NOT EXISTS {$this->getTable('lyonscg_pagecachefilter_filter')} (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `param` VARCHAR(64) NOT NULL UNIQUE KEY,
        `enabled` TINYINT(1) NOT NULL,
        `description` VARCHAR(255),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();