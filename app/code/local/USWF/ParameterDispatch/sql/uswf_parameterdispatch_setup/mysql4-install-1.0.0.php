<?php
/**
 * USWF Page Cache Filter
 *
 * @category    USWF
 * @package     USWF_ParameterDispatch
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */
 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

// Create table to store list of parameters to filter.
$installer->run("
    CREATE TABLE IF NOT EXISTS {$this->getTable('uswf_parameter_dispatch')} (
        `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `param` VARCHAR(64) NOT NULL UNIQUE KEY,
        `event` VARCHAR(128) NOT NULL,
        `enabled` TINYINT(1) NOT NULL,
        `description` VARCHAR(255),
        `priority` INT(3) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
