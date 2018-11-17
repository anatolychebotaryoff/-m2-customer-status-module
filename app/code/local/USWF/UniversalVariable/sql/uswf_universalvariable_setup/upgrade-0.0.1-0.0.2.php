<?php

$store = Mage::app()->getStore();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$installer = $this;
$installer->startSetup();

$content = <<<HTML
<style type="text/css">

</style>
HTML;
$stores = Mage::getModel('core/store')->getCollection()->addFieldToFilter('store_id', array('gt'=>0))->getAllIds();

try{
    $cmsBlock = Mage::getModel('cms/block');
    $cmsBlock->setTitle('QuBit Head CSS');
    $cmsBlock->setIdentifier('qubit_head_css');
    $cmsBlock->setStores($stores);
    $cmsBlock->setIsActive(1);
    $cmsBlock->setContent($content);
    $cmsBlock->save();

    Mage::app()->cleanCache();
}catch (Exception $ex) {
    Mage::logException($ex);
}

$installer->endSetup();

Mage::app()->setCurrentStore($store);
