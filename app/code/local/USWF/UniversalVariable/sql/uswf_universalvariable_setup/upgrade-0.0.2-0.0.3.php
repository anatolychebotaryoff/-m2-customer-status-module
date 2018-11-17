<?php

$store = Mage::app()->getStore();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$installer = $this;
$installer->startSetup();

try{
    $cmsBlock = Mage::getModel('cms/block')->load('qubit_head_css','identifier');
    if (!$cmsBlock->isEmpty()){
        $cmsBlock->setIdentifier('hotdeal_alert');
        $cmsBlock->setTitle('Hotdeal alert');
        $cmsBlock->save();
    }
    Mage::app()->cleanCache();
}catch (Exception $ex) {
    Mage::logException($ex);
}

$installer->endSetup();

Mage::app()->setCurrentStore($store);
