<?php
/**
 * Add support for HasOffers integration
 *
 * @category  Lyons
 * @package   Lyonscg_HasOffers
 * @author    Logan Montgomery <lmontgomery@lyonscg.com>
 * @copyright Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 */

$installer = $this;

$installer->startSetup();

$installer->run("
    CREATE TABLE IF NOT EXISTS `{$installer->getTable('lyonscg_hasoffers/order')}` (
      `hasorders_id` INT NOT NULL AUTO_INCREMENT,
      `order_id` INT NOT NULL UNIQUE,
      `transaction_id` VARCHAR(255) NOT NULL,
      `affiliate_id` VARCHAR(255) NOT NULL,
      `offer_id` VARCHAR(255) NOT NULL,
      PRIMARY KEY(`hasorders_id`)
    );
");

// ADD FOREIGN KEYS FOR SALES_FLAT_ORDER HERE

$installer->endSetup();