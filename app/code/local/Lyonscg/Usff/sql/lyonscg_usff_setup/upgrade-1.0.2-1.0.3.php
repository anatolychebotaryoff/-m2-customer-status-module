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


// 1. HomePage Banner
$title = 'Fridge Upsell Block';
$identifier = 'fridge_upsell_block';
$content = '<div class="fridge-upsell-block">
    <div class="product-labels">
     <div class="text-line">Save more with the comparable version:</div>
    <div class="price">Save {{var price_differ}} on your filter!</div>
    </div>
    <div class="product-section">
        <img src="{{var item_image}}" class="product-image" alt="{{var item_name}}" title="{{var item_name}}" />
        <div class="name">
        {{var item_sku}})
        <div class="product-price">${{var item_price}}</div>
        </div>
    </div>
</div>
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


