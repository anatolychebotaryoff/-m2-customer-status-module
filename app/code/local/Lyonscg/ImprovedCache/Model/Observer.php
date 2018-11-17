<?php
/**
 * Improved Cache Clearing/Warming
 *
 * @category    Lyonscg
 * @package     Lyonscg_ImprovedCache
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (http://www.lyonscg.com)
 * @author      Nick Hughart (nhughart@lyonscg.com)
 */

class Lyonscg_ImprovedCache_Model_Observer
{
    /**
     * Page Cache Processor
     *
     * @var Enterprise_PageCache_Model_Processor
     */
    protected $_processor;

    /**
     * Page Cache Config
     *
     * @var Enterprise_PageCache_Model_Config
     */
    protected $_config;

    /**
     * Is Enabled Full Page Cache
     *
     * @var bool
     */
    protected $_isFPCEnabled;

    /**
     * Is Enabled Improved Cache
     *
     * @var bool
     */
    protected $_isEnabled;

    /**
     * Clear Product Cache on Save
     *
     * @var bool
     */
    protected $_clearProducts;

    /**
     * Clear Category Cache on Save
     *
     * @var bool
     */
    protected $_clearCategories;

    /**
     * True if Warming Cron is Enabled
     *
     * @var bool
     */
    protected $_partialWarmingCronEnabled;

    /**
     * Block core FPC flush on catalog rule application
     *
     * @var
     */
    protected $_blockCoreClear;

    /**
     * True is store warming is enabled
     *
     * @var
     */
    protected $_storeWarmingCronEnabled;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_processor = Mage::getSingleton('enterprise_pagecache/processor');
        $this->_config    = Mage::getSingleton('enterprise_pagecache/config');
        $this->_isFPCEnabled = Mage::app()->useCache('full_page');
        $this->_isEnabled = Mage::getStoreConfig('lyonscg_improvedcache/general/enable');
        $this->_clearProducts = Mage::getStoreConfig('lyonscg_improvedcache/flushing/clear_product');
        $this->_clearCategories = Mage::getStoreConfig('lyonscg_improvedcache/flushing/clear_category');
        $this->_partialWarmingCronEnabled = Mage::getStoreConfig('lyonscg_improvedcache/warming/enable_partial_cron');
        $this->_storeWarmingCronEnabled = Mage::getStoreConfig('lyonscg_imporovedcache/warming/enable_store_cron');
        $this->_blockCoreClear = Mage::getStoreConfig('lyonscg_improvedcache/flushing/block_core_clear');
    }

    /**
     * Returns ture if FPC and improved cache are enabled.
     *
     * @return bool
     */
    private function _isEnabled() {
        return $this->_isEnabled && $this->_isFPCEnabled;
    }

    /**
     * Clear FPC entries related to the parent category of the saved category
     *
     * @param Varien_Event_Observer $observer
     */
    public function clearCategoryCache(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled() || !$this->_clearCategories) {
            return;
        }

        /** @var Mage_Catalog_Model_Category $category */
        $category = $observer->getCategory();

        if ($category) {
            $tags = $category->getCacheIdTags();
            $ids = $this->_tagsToIds($tags);

            $this->_createCacheItems($ids[Mage_Catalog_Model_Product::ENTITY], $ids[Mage_Catalog_Model_Category::ENTITY]);
            Enterprise_PageCache_Model_Cache::getCacheInstance()->clean($tags);
        }
    }

    /**
     * Clear FPC entries related to the product and any categories it is assigned to.
     *
     * @param Varien_Event_Observer $observer
     */
    public function clearProductCache(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled() || !$this->_clearProducts) {
            return;
        }

        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();

        if ($product) {
            $this->_clearProductCache($product);
        }
    }

    /**
     * Clear FPC entries related to given products.
     * Also clears entries for any categories the product is assigned to
     * as well as any parent products and categories they are assigned to.
     *
     * @param Varien_Event_Observer $observer
     */
    public function clearProductsCache(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled() || !$this->_blockCoreClear) {
            // Determine core function that is normally called on this event
            $class = (string)Mage::getConfig()->getNode('adminhtml/events/catalogrule_after_apply/observers/enterprise_pagecache/class');
            $method = (string)Mage::getConfig()->getNode('adminhtml/events/catalogrule_after_apply/observers/enterprise_pagecache/method');

            // Call core method that we disabled via the config
            $object = Mage::getSingleton($class);
            $object->$method($observer);

            return;
        }

        /** @var Mage_Catalog_Model_Product_Condition_Interface $productCondition */
        $productCondition = $observer->getProductCondition();

        if ($productCondition instanceof Mage_Catalog_Model_Product_Condition_Interface) {
            $collection = Mage::getResourceModel('catalog/product_collection');
            $productCondition->applyToCollection($collection);
            foreach($collection as $product) {
                $this->_clearProductCache($product);
            }
        }
    }

    /**
     * Track collection loads for products and categories and
     * add the appropriate tags to the request.
     *
     * @param Varien_Event_Observer $observer
     */
    public function trackCollection(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled()) {
            return;
        }

        $collection = $observer->getEvent()->getCollection();
        if (!$collection) {
            $collection = $observer->getEvent()->getCategoryCollection();
        }

        $tags = array();
        /** @var Mage_Core_Model_Abstract $item */
        foreach($collection as $item) {
            $tags = array_merge($tags, $item->getCacheIdTags());
        }

        if ($tags) {
            $requestTags = $this->_processor->getRequestTags();

            // Add only unique and new tags to the request
            $newTags = array_diff($tags, $requestTags);
            $this->_processor->addRequestTag($newTags);
        }
    }

    /**
     * Warm all active stores
     *
     * @param Varien_Event_Observer $observer
     */
    public function warmStores(Varien_Event_Observer $observer)
    {
        if (!$this->_isEnabled() && $this->_storeWarmingCronEnabled) {
            return;
        }

        $stores = Mage::getResourceModel('core/store_collection')
            ->setWithoutDefaultFilter(true)
            ->addFieldToFilter('is_active', array('eq' => 1));

        $helper = Mage::helper('lyonscg_improvedcache');
        foreach ($stores as $store) {
            $helper->crawlStore($store);
        }
    }

    /**
     * Clear any cache related to a given product
     *
     * @param Mage_Catalog_Model_Product $product
     */
    protected function _clearProductCache($product)
    {
        // Clear any pages related to the product itself.
        $tags = $product->getCacheIdTags();
        $ids = $this->_tagsToIds($tags);

        $parents = $this->_getParentProducts($product);
        if ($parents) {
            foreach ($parents as $parent) {
                $tags = array_merge($tags, $parent->getCacheIdTags());
                $ids = array_merge($ids, $this->_tagsToIds($tags));
            }
        }

        $this->_createCacheItems($ids[Mage_Catalog_Model_Product::ENTITY], $ids[Mage_Catalog_Model_Category::ENTITY]);
        Enterprise_PageCache_Model_Cache::getCacheInstance()->clean($tags);
    }

    /**
     * Get IDs for parent products of this product
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    protected function _getParentProducts($product)
    {
        // Determine if there are any parent products
        $parentIds = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($product->getId());
        $parentIds = array_merge($parentIds, Mage::getModel('catalog/product_type_grouped')->getParentIdsByChild($product->getId()));
        $parentIds = array_merge($parentIds, Mage::getModel('bundle/product_type')->getParentIdsByChild($product->getId()));

        // Get collection of parent products.
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addIdFilter($parentIds)
            ->addStoreFilter($product->getStoreId());

        return $collection;
    }

    // Search tags for
    protected function _tagsToIds($tags)
    {
        $ids = array();
        foreach($tags as $tag) {
            if (strpos($tag, Mage_Catalog_Model_Product::ENTITY)) {
                $ids[Mage_Catalog_Model_Product::ENTITY] = str_replace(Mage_Catalog_Model_Product::ENTITY . '_', '', $tag);
            } else if (strpos($tag, Mage_Catalog_Model_Category::ENTITY)) {
                $ids[Mage_Catalog_Model_Category::ENTITY] = str_replace(Mage_Catalog_Model_Category::ENTITY . '_', '', $tag);
            }
        }

        return $ids;
    }

    /**
     * Create cache item which can be used for
     * cache warming.
     *
     * @param array $ids
     * @param string $entity
     */
    protected function _createCacheItems($productIds, $categoryIds)
    {
        if (!$this->_partialWarmingCronEnabled) {
            return;
        }

        if (!empty($productIds)) {
            $productsCollection = Mage::getResourceModel('core/url_rewrite_collection');
            $productsCollection->addFieldToFilter('product_id', array('in' => $productIds));
            $productsCollection->getSelect()->columns(array('entity_type' => new Zend_Db_Expr(Mage_Catalog_Model_Product::ENTITY)));
        }

        if (!empty($categoryIds)) {
            $categoriesCollection = Mage::getResourceModel('core/url_rewrite_collection');
            $categoriesCollection->addFieldToFilter('category_id', array('in' => $categoryIds))
                ->addFieldToFilter('product_id', array('null' => true));
            $categoriesCollection->getSelect()->columns(array('entity_type' => new Zend_Db_Expr(Mage_Catalog_Model_Category::ENTITY)));
        }

        $rewrites = array_merge($productIds, $categoryIds);

        foreach($rewrites as $rewrite) {
            $item = Mage::getModel('lyonscg_improvedcache/cache_item');

            $entityId = null;
            $entityType = $rewrite->getEntityType();
            if ($entityType == Mage_Catalog_Model_Product::ENTITY) {
                $entityId = $rewrite->getProductId();
            } else {
                $entityId = $rewrite->getCategoryId();
            }

            $item->setRequestPath($rewrite->getRequestPath())
                ->setPageType($entityType)
                ->setEntityId($entityId)
                ->setStoreId($rewrite->getStoreId())
                ->save();
        }
    }
}