<?php
/**
 * StoreFront CyberSource Tokenized Payment Extension for Magento
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of StoreFront Consulting, Inc.
 *
 * @category  SFC
 * @package   SFC_CyberSource
 * @author    Garth Brantley <garth@storefrontconsulting.com>
 * @copyright 2009-2013 StoreFront Consulting, Inc. All Rights Reserved.
 * @license   http://www.storefrontconsulting.com/media/downloads/ExtensionLicense.pdf StoreFront Consulting Commercial License
 * @link      http://www.storefrontconsulting.com/cybersource-saved-credit-cards-extension-for-magento/
 *
 */

$installer = $this;
/* @var $installer Mage_Eav_Model_Entity_Setup */

$installer->startSetup();

// Create - sfc_cybersource_payment_profile - table
$installer->run("
create table if not exists {$installer->getTable('sfc_cybersource/payment_profile')}(
    id int not null auto_increment,
    customer_id int(10) UNSIGNED not null,
    customer_fname varchar(255),
    customer_lname varchar(255),
    customer_cardnumber varchar(32),
    cc_type varchar(32),
    payment_token  varchar(32),
    unique (payment_token),
    primary key(id),
    foreign key (customer_id) references {$installer->getTable('customer_entity')} (entity_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    ");

// END SETUP
$installer->endSetup();
