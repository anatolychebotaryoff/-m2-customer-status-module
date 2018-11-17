<?php
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer->startSetup();

$connection                      = $installer->getConnection();
$rulesTable                      = $installer->getTable('uswf_giftpurchase/rule');

if ($connection->isTableExists($rulesTable)) {
    $installer->getConnection()->addColumn($installer->getTable($rulesTable), 'popup_text', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'comment'   => 'PopUp Text',
    ));
    $installer->getConnection()->addColumn($installer->getTable($rulesTable), 'popup_text_active', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        'comment'   => 'PopUp Text Active',
    ));
}

$installer->endSetup();
