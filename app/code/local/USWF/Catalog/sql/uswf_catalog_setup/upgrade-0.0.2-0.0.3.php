<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
try{

    $content = '
<div class="upsell-banner">
    <a href="{{var product_link}}">
        <div class="upsell-banner-content">
            <span class="upsell-banner-content-top">Save <strong>${{var price_differ}}</strong></span>
            <span class="upsell-banner-content-bottom">Try our comparable Tier1 filter <span class="upsell-arrow-right">&#9654;</span></span>
            <span class="upsell-banner-anchor"></span>
        </div>
        <div class="upsell-banner-logo-wrapper">
            <img class="upsell-banner-logo" src="http://static.discountfilterstore.com/media/wysiwyg/Qubit/tier1-logo.png" alt="" />
        </div>
    </a>
</div>
';
    $block = Mage::getModel('cms/block');
    $block->setTitle('New Upsell Banner');
    $block->setIdentifier('new-upsell-block');
    $block->setStores(array(0));
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();


    Mage::getConfig()->cleanCache();
}catch (Exception $ex){
    Mage::logException($ex);
}


$installer->endSetup();
