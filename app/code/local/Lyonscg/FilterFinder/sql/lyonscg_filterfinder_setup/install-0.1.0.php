<?php
/**
 * Category for filter finder on discount store
 *
 * @category     Lyonscg
 * @package      Lyonscg_FilterFinder
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Yuriy Scherba (yscherba@lyonsg.com)
 */


$installer = $this;
$installer->startSetup();
if (!Mage::getModel('catalog/category')->loadByAttribute('name', 'Discount Filter Finder')){
    Mage::register('isSecureArea', 1);
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
    $category = Mage::getModel('catalog/category');
    $category->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID);
    $parentCategory = Mage::getModel('catalog/category')->loadByAttribute('name', 'DiscountFilterStore.com');
    $path = $parentCategory->getPath();
    $category->setName('Discount Filter Finder')
        ->setShortName('DiscountFilterFinder')
        ->setIsActive(1)
        ->setDisplayMode('PRODUCTS')
        ->setIsAnchor(0)
        ->setIncludeInMenu(0)
        ->setCustomUseParentSettings(0)
        ->setPageLayout('one_column');
    $category->setPath($path);
    $category->save();
    $category->setStoreId(Mage::app()->getStore('dfs_en')->getId());
    $category->save();
}
$installer->endSetup();