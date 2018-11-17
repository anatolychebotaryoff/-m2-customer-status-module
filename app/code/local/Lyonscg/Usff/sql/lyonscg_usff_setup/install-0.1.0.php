<?php


$installer = $this;
$installer->startSetup();



$title = 'Fridge Header Info';
$identifier = 'fridge_header_info';
$content = '<ul class="headerInfoBlock">
    <li>Customer Service: <span class="red">800-683-8353</span></li>
    <li><span class="blue">FREE Shipping over $75</span></li>
</ul>';

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

$installer->endSetup();


