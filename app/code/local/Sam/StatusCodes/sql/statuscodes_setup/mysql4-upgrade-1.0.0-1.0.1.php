<?php

$installer = $this;
$connection = $installer->getConnection();

$installer->startSetup();

$setup = new Mage_Core_Model_Config();
$setup->saveConfig("sam_statuscodes/general/h_code", "Card member's name does not match. Street address and postal code match.", "default", 0);

$installer->endSetup();