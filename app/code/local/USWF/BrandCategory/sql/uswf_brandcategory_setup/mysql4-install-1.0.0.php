<?php
/**
 * USWF Page Cache Filter
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */
 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

// Create table to store list of parameters to filter.
$installer->run("
    CREATE TABLE IF NOT EXISTS {$this->getTable('uswf_brand_category')} (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `brand` INT(10) NOT NULL,
        `record` INT(10) NOT NULL,
        `enabled` TINYINT(1) NOT NULL,
        `description` VARCHAR(255),
        `store_id` INT(3) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
