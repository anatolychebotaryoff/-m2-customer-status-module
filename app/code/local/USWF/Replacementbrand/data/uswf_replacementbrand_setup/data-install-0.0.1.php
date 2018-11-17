<?php

$installer = $this;
$installer->startSetup();

$currentStore = Mage::app()->getStore();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

/** @var $website Mage_Core_Model_Website */
$website = Mage::getModel('core/website');
$website->setCode('rb')
    ->setName('ReplacementBrand.com')
    ->save();

/** @var $storeGroup Mage_Core_Model_Store_Group */
$storeGroup = Mage::getModel('core/store_group');
$storeGroup->setWebsiteId($website->getId())
    ->setName('ReplacementBrand.com')
    ->save();

/** @var $store Mage_Core_Model_Store */
$store = Mage::getModel('core/store');
$store->setCode('rb_en')
    ->setWebsiteId($storeGroup->getWebsiteId())
    ->setGroupId($storeGroup->getId())
    ->setName('ReplacementBrand_en')
    ->setIsActive(1)
    ->save();

$configList = array(
    'design/theme/locale' => 'rb',
    'design/theme/template' => 'rb',
    'design/theme/skin' => 'rb',
    'design/theme/layout' => 'rb',
    'design/theme/default' => 'rb'
);
foreach ($configList as $path => $value) {
    Mage::getConfig()->saveConfig($path, $value, 'websites', $website->getId());
}

$category = Mage::getModel('catalog/category');
$category->setStoreId($store->getId())
    ->setName('ReplacementBrand.com')
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


