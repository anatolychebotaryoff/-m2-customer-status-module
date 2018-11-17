<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

//HP_Top_Products=================start
$content = <<<HTML
{{block type="bestseller/bestseller" name="bestseller" template="bestseller/bestseller_hp.phtml"}}
HTML;
$block = Mage::getModel('cms/block')->load('HP_Top_Products', 'identifier');
if ($block->getId()) {
    $block->setContent($content);
    $block->save();
}
//HP_Top_Products=================end

$installer->endSetup();