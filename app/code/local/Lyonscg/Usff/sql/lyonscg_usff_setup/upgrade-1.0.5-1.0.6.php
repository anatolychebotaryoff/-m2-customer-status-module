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


$title = 'Fridge Filters HomePage brands';
$identifier = 'fridge_homepage_brands';
$content = '<div class="hp_brands">
<div class="homepage-label">
    <h2>Shop by brand...</h2>
</div>
<ul class="hp_brand_list">
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
    <li><a href="#"><img src="http://uswaterstage-discountfilterstore.lcgosc.com/media/catalog/category/Category-Thumbnail-3M_2.jpg" alt=""/></a></li>
</ul>
</div>';

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