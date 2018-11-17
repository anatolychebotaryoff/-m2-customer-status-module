<?php
/**
 * PDP CMS block for Usff website
 *
 * @category     Lyonscg
 * @package      Lyonscg_Usff
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Yuriy Scherba (yscherba@lyonsg.com)
 */


$installer = $this;
$installer->startSetup();


$title = 'Fridge Filters PDP Static Video Block';
$identifier = 'fridge_pdp_video_block';
$content = '<a class="goToVideo" href="#videoanchor">&nbsp;</a>';

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


