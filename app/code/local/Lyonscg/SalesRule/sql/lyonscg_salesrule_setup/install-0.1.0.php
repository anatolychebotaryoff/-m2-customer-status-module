<?php
/**
 * File Description here....
 *
 * @category  Lyons
 * @package   Lyonscg_SalesRule
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn(
        $installer->getTable('salesrule/rule'),
        'terms_and_conditions',
        array(
            'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'  => 'Terms and Conditions',
            'nullable' => true,
            'default'  => null
        )
    );

$installer->endSetup();
