<?php
/**
 * Observer to Add Short Name to menu select query
 *
 * @category   Lyons
 * @package    Lyonscg_Catalog
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */

class Lyonscg_Catalog_Model_Observer
{
    // Class variable for categories array
    protected $_categories = array();

    /**
     * Add column short_name to select query for Main Menu
     *
     * @param $observer
     */
    public function addShortName($observer)
    {
        $_select = $observer->getSelect();
        $_adapter = $_select->getAdapter();
        $_select->columns(new Zend_Db_Expr('main_table.' . $_adapter->quoteIdentifier('short_name')));
    }

    public function addShortNameToCatalogTopmenuItems($observer)
    {
        if (empty($this->_categories)) {
            $this->addCategories(Mage::helper('catalog/category')->getStoreCategories());
        }

        foreach($observer->getMenu()->getAllChildNodes() as $childNode) {
            $id = str_replace('category-node-', '', $childNode->getId());
            if (!empty($this->_categories[$id]['short_name'])) {
                $childNode->setName($this->_categories[$id]['short_name']);
            }
        }
    }

    /**
     * Add categories to class variable - Recursive Function
     *
     * @param $categories
     */
    protected function addCategories($categories) {
        foreach($categories as $category) {
            $this->_categories[$category->getId()]['short_name'] = $category->getShortName();
            if ($childrenNodes = $category->getChildrenNodes()) {
                $this->addCategories($childrenNodes);
            }
        }
    }
    
    /**
     * Check "Not For Sale" attribute after is_salable checking
     * @param $observer
     */
    public function checkIsNotForSale($observer) {
        $product = $observer->getProduct();
        if(!$product->getParentProductId() && $product->getNotForSale()) {
            $observer->getSalable()->setIsSalable(false);
        }
    }
}