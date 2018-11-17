<?php

$installer = $this;
$installer->startSetup();

$currentStore = Mage::app()->getStore();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

/** @var $website Mage_Core_Model_Website */
$website = Mage::getModel('core/website');
$website->setCode('sf')
    ->setName('SmartFIT.com')
    ->save();

/** @var $storeGroup Mage_Core_Model_Store_Group */
$storeGroup = Mage::getModel('core/store_group');
$storeGroup->setWebsiteId($website->getId())
    ->setName('SmartFIT.com')
    ->save();

/** @var $store Mage_Core_Model_Store */
$store = Mage::getModel('core/store');
$store->setCode('sf_en')
    ->setWebsiteId($storeGroup->getWebsiteId())
    ->setGroupId($storeGroup->getId())
    ->setName('SmartFIT_en')
    ->setIsActive(1)
    ->save();

$configList = array(
    'design/theme/locale' => 'sf',
    'design/theme/template' => 'sf',
    'design/theme/skin' => 'sf',
    'design/theme/layout' => 'sf',
    'design/theme/default' => 'sf'
);
foreach ($configList as $path => $value) {
    Mage::getConfig()->saveConfig($path, $value, 'websites', $website->getId());
}

$category = Mage::getModel('catalog/category');
$category->setStoreId($store->getId())
    ->setName('SmartFIT.com')
    ->setDisplayMode(Mage_Catalog_Model_Category::DM_PRODUCT)
    ->setIsActive(1)
    ->setIncludeInNavigationMenu(false)
    ->setPath('1')
    ->setAttributeSetId($category->getDefaultAttributeSetId())
    ->save();

$storeGroup->setRootCategoryId($category->getId())
    ->save();

$process = Mage::getModel('index/indexer')->getProcessByCode('catalog_category_flat');
$process->reindexAll();

Mage::app()->setCurrentStore($currentStore->getStoreId());

$installer->endSetup();


