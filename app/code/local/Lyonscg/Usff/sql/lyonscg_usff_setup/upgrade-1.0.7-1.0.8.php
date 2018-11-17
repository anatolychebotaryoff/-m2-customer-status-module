<?php
/**
 * Category for filter finder
 *
 * @category     Lyonscg
 * @package      Lyonscg_Usff
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Yuriy Scherba (yscherba@lyonsg.com)
 */


$installer = $this;
$installer->startSetup();
if (!Mage::getModel('catalog/category')->loadByAttribute('name', 'Fridge Filter Finder')){
    Mage::register('isSecureArea', 1);
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
    $category = Mage::getModel('catalog/category');
    $category->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID);
    $parentCategory = Mage::getModel('catalog/category')->loadByAttribute('name', 'FridgeFilters.com');
    $path = $parentCategory->getPath();
    $category->setName('Fridge Filter Finder')
        ->setShortName('FridgeFilterFinder')
        ->setIsActive(1)
        ->setUrlKey('fridgeFilterFinder')
        ->setDisplayMode('PRODUCTS')
        ->setIsAnchor(0)
        ->setIncludeInMenu(0)
        ->setCustomUseParentSettings(0)
        ->setCustomLayoutUpdate('<reference name="left"><remove name="catalog.leftnav"/><remove name="catalog.rightlayer"/></reference><reference name="content"><block type="filterfinder/filterFinder" name="filterfinder" before="-" template="filterfinder/filterfinder.phtml"/></reference>')
        ->setPageLayout('one_column');
    $category->setPath($path);
    $category->save();
    $category->setStoreId(Mage::app()->getStore('ff_en')->getId());
    $category->save();
}
$installer->endSetup();