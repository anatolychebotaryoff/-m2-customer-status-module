<?php
/**
 * HomePage CMS blocks for Usff website
 *
 * @category     Lyonscg
 * @package      Lyonscg_Usff
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Alexandr Pomelov (apomelov@lyonsg.com)
 */


$installer = $this;
$installer->startSetup();


// 1. HomePage Fridge Filters Category

$title = 'Fridge Filters Category';
$identifier = 'fridge_filters_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/refrigerator_category.jpg\'}}" alt="" /><h3>Shop Fridge Filters</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}
/*----------------------------------------------------------------------------------------------------------*/
// 2. HomePage Shop 3M Filtrete Filters

$title = 'Fridge 3M Filtrete Filters Category';
$identifier = 'fridge_3m_filtrette_filters_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/refrigerator_category.jpg\'}}" alt="" /><h3>Shop 3M Filtrete Filters</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 3. HomePage Fridge Water Filter Category

$title = 'Fridge Water Test Kits';
$identifier = 'fridge_water_test_kits_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/water_filter_category.jpg\'}}" alt="" /><h3>Shop Water Test Kits</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 4. HomePage Fridge Water Test Tits Category

$title = 'Fridge Faucet Mount Filters';
$identifier = 'fridge_faucet_mount_filters_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/water_test_kits_category.jpg\'}}" alt="" /><h3>Shop Faucet Mount Filters</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 5. HomePage Fridge Filters Category

$title = 'Fridge Pitchers & Filters';
$identifier = 'fridge_pitchers_and_filters_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/refrigerator_category.jpg\'}}" alt="" /><h3>Shop Pitchers & Filters</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}
/*----------------------------------------------------------------------------------------------------------*/
// 6. HomePage Shop 3M Filtrete Filters

$title = 'Fridge In-Line Filters';
$identifier = 'fridge_inline_filters_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/refrigerator_category.jpg\'}}" alt="" /><h3>Shop In-Line Filters</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 7. HomePage Fridge Water Filter Category

$title = 'Fridge Undersink Filters';
$identifier = 'fridge_undersink_filters_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/water_filter_category.jpg\'}}" alt="" /><h3>Shop Undersink Filters</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 8. HomePage Fridge Water Test Tits Category

$title = 'Fridge Whole House Filters';
$identifier = 'fridge_whole_house_filters_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/water_test_kits_category.jpg\'}}" alt="" /><h3>Shop Whole House Filters</h3></a>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}
/*----------------------------------------------------------------------------------------------------------*/


$installer->endSetup();