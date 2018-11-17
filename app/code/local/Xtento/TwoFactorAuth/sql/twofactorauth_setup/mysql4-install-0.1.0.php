<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('admin/user'), 'token_login_enabled', 'tinyint(1) NOT NULL DEFAULT \'0\'');
$installer->getConnection()->addColumn($this->getTable('admin/user'), 'login_token_secret', 'varchar(255) NULL');
$installer->getConnection()->addColumn($this->getTable('admin/user'), 'last_token_used', 'varchar(10) NULL');

$installer->endSetup();