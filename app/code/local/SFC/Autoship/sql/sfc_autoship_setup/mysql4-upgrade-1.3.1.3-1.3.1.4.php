<?php
/**
 * Subscribe Pro - Subscriptions Management Extension
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of SUBSCRIBE PRO INC.
 *
 * @category  SFC
 * @package   SFC_Autoship
 * @author    Garth Brantley <garth@subscribepro.com>
 * @copyright 2009-2016 SUBSCRIBE PRO INC. All Rights Reserved.
 * @license   http://www.subscribepro.com/terms-of-service/ Subscribe Pro Terms of Service
 * @link      http://www.subscribepro.com/
 *
 */

/**
 * Installer
 */
$installer = $this;
$installer->startSetup();

// Update subscription_enabled product attribute to have apply to all product types except grouped
$installer->updateAttribute(
    'catalog_product',
    'subscription_enabled',
    'apply_to',
    'simple,configurable,bundle,virtual,downloadable'
);

$sql = <<<SQL

DROP TABLE IF EXISTS sfc_autoship_migrated_subscription_item;
DROP TABLE IF EXISTS sfc_autoship_migrated_subscription;
DROP TABLE IF EXISTS sfc_autoship_migrated_cim_profile;
DROP TABLE IF EXISTS sfc_autoship_og_subscription;
DROP TABLE IF EXISTS sfc_autoship_subscription_order;

SQL;

$installer->run($sql);

/**
 * Clean up installer
 */
$installer->endSetup();
