<?php
/**
 * AAir Filter Landing page delimeter block
 *
 * @category    Lyonscg
 * @package     Lyonscg_AirFilter
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 */


$installer = $this;
$installer->startSetup();

$title = 'Or find by brand';
$identifier = 'or_find_by_brand';
$content = '';

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


