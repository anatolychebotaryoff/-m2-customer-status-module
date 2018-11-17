<?php
/**
 *  Creating cms block "subscription_price" for DFS on PDP
 */


$installer = $this;
$installer->startSetup();



$title = 'DFS Grouped PDP PopUp Subscribe Content Block';
$identifier = 'subscr_popup_content';
$content = '<h2>No worries filter subscription program</h2>
            <p>When we say we’ll get you the filter you need when you need it, we mean it!</p>
            <ul>
                <li>Your filters will ship when you need them.</li>
                <li>You can set up your own filter replacement schedule.</li>
                <li>You will always get a notice before we ship your filter.</li>
                <li>You can update your account details quickly &amp; easily.</li>
                <li>Your filters are free to return.</li>
                <li>You can cancel anytime.</li>
                <p>Learn more about our <a href="#">No Worries Filter Subscription Program.</a></p>
            </ul>';

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