<?php
/**
 *  Creating cms block "subscription_price" for DFS on PDP
 */


$installer = $this;
$installer->startSetup();



$title = 'Our price/Subscription price';
$identifier = 'subscription_price';
$content = '<div class="SubStatBlock">
       <ul>
             <li>Our price: <span>{{var ourPrice}}</span></li>
             <li>Subscription price: <span>{{var subscrPrice}}</span></li>
       </ul>
       <p>Save an additional 10% when you use our No Worries </br> Subscription! <a href="#">Learn more</a>.</p>
</div>';

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