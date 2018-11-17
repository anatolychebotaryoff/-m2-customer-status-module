<?php

$store = Mage::app()->getStore();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$installer = $this;
$installer->startSetup();

$content = <<<HTML
<ul class="guarantees">
    <li>
        <span class="guarantees-icon fa fa-2x fa-check-circle"></span>
        <span class="guarantees-text">Guaranteed fit and quality</span>
    </li>
    <li>
        <span class="guarantees-icon fa fa-2x fa-truck green"></span>
        <span class="guarantees-text">Free shipping over $39, free returns</span>
    </li>
</ul>
HTML;

$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
try{
    $cmsBlock = Mage::getModel('cms/block');
    $cmsBlock->setTitle('Product Guarantees');
    $cmsBlock->setIdentifier('product_guarantees');
    $cmsBlock->setStores($store);
    $cmsBlock->setIsActive(1);
    $cmsBlock->setContent($content);
    $cmsBlock->save();

    Mage::app()->cleanCache();
}catch (Exception $ex) {
    Mage::logException($ex);
}

$installer->endSetup();

Mage::app()->setCurrentStore($store);
