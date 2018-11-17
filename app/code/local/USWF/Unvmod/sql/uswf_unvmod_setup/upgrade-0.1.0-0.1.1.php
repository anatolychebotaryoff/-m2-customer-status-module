<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$content = <<<HTML

<style>
@import url({{skin url='css/bootstrap-fix.css'}});
</style>

HTML;

$block = Mage::getModel('cms/block')->load('DFS-tier1-banner-and-subcategories', 'identifier');
if ($block->getId()) {
    $contentOld = $block->getContent();
    $block->setContent($contentOld.$content);
    $block->save();
}