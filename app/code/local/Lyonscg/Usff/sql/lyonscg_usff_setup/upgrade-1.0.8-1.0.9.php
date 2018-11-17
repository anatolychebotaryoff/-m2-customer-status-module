<?php
/**
 *  Creating cms block "checkout_enhancements" for DFS on checkout page
 */


$installer = $this;
$installer->startSetup();



$title = 'DFS Shopping Cart Enhancements';
$identifier = 'dfs_checkout_enhancements';
$content = 'content for Checkout enchancement';

$website = Mage::getModel('core/website')->load('dfs');
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

$installer->endSetup();