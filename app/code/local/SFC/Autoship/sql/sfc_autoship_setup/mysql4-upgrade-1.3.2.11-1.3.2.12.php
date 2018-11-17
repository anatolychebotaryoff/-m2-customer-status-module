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

/**
 * Add new attribute to order item
 */
$installer->addAttribute('order_item', 'subscription_reorder_ordinal', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'visible'  => false,
    'required' => false
));
$installer->addAttribute('order_item', 'subscription_next_order_date', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_DATE,
    'visible'  => false,
    'required' => false
));

/**
 * Add new attribute to quote item
 */
$installer->addAttribute('quote_item', 'subscription_next_order_date', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_DATE,
    'visible'  => false,
    'required' => false
));

/**
 * Clean up installer
 */
$installer->endSetup();
