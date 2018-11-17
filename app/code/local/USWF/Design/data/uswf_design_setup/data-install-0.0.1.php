<?php

$installer = $this;
$installer->startSetup();

$title = 'DFS Header Info';
$identifier = 'dfs_header_info';
$content = '<div class="hello"><a href="{{store direct_url=\'shipping.html\'}}" target="_blank">Everyday free shipping over $39</a></div>';

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


