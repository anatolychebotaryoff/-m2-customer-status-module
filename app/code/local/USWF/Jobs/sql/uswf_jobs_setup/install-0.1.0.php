<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$model = Mage::getModel('zeon_jobs/category')->load(1);
if ($model) {
    $model->setDescription('PHP Magento');
    $model->save();
}

$installer->endSetup();