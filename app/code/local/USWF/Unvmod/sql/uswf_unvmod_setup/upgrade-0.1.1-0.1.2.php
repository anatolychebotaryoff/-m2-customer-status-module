<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$content = <<<HTML

<div class="upsell-banner-content">
    <span class="upsell-banner-content-top">Don't want to pay {{var price}}?</span>
    <span class="upsell-banner-content-bottom">Try our high quality alternative and save {{var price_differ}} <span class="upsell-arrow-right">&#9654;</span></span>
    <span class="upsell-banner-anchor"></span>
</div>
<div class="upsell-banner-logo-wrapper">
    <img class="upsell-banner-logo" src="{{media url="wysiwyg/Qubit/tier1-logo.png"}}" alt="">
</div>

HTML;

$block = Mage::getModel('cms/block')->load('upsell-block', 'identifier');
if ($block->getId()) {
    $block->setContent($content);
    $block->save();
}