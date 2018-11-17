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


// 1. HomePage Banner
$title = 'Fridge Homepage Banner';
$identifier = 'fridge_homepage_banner';
$content = '<div class="homepage-banner"><img src="{{skin url=\'images/media/homepage_banner_img.jpg\'}}" alt="" /></div>';

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
// 2. HomePage Fridge Refrigerator Category

$title = 'Fridge Refrigerator Category';
$identifier = 'fridge_refrigerator_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/refrigerator_category.jpg\'}}" alt="" /><h3>Shop Refrigerators</h3></a>';

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

$title = 'Fridge Water Filter Category';
$identifier = 'fridge_water_filter_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/water_filter_category.jpg\'}}" alt="" /><h3>Shop Water Filters</h3></a>';

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

$title = 'Fridge Water Test Tits Category';
$identifier = 'fridge_water_test_kits_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/water_test_kits_category.jpg\'}}" alt="" /><h3>Shop Water Test Kits</h3></a>';

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
// 5. HomePage Fridge Filterete Filter Category

$title = 'Fridge Filterete Filter Category';
$identifier = 'fridge_filterete_filter_category';
$content = '<a href="#"><img src="{{skin url=\'images/media/filterete_filter_category.jpg\'}}" alt="" /><h3>Shop 3M Filtrete Filters</h3></a>';

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


