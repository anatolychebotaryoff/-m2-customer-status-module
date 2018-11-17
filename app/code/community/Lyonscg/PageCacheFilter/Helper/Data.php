<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */
 
class Lyonscg_PageCacheFilter_Helper_Data extends Mage_Core_Helper_Abstract
{
    const FILTER_CACHE_KEY = 'FPC_PAGECACHE_FILTER_CACHE_KEY';

    const XML_PATH_CACHE_FILTER_ENABLE = 'system/page_cache/lyonscg_pagecachefilter_enable';

    /**
     * Save query parameters to filter as an entry in the full page cache.
     */
    public function cacheFilters()
    {
        $cacheInstance = Enterprise_PageCache_Model_Cache::getCacheInstance();

        if (!Mage::getStoreConfig(self::XML_PATH_CACHE_FILTER_ENABLE)) {
            $cacheInstance->remove(self::FILTER_CACHE_KEY);
            return;
        }

        if (!$cacheInstance->load(self::FILTER_CACHE_KEY)) {
            $collection = Mage::getResourceModel('lyonscg_pagecachefilter/filter_collection');
            $collection->addFieldToFilter('enabled', array('eq' => 1))->addFieldToSelect('param');

            $filters = $collection->getData();
            $cacheInstance->save(
                urlencode(serialize($filters)),
                self::FILTER_CACHE_KEY,
                array(Enterprise_PageCache_Model_Processor::CACHE_TAG)
            );
        }
    }

    /**
     * Delete old filters and then generate a new cache entry using
     * cacheFilters above.
     */
    public function refreshCachedFilters()
    {
        $cacheInstance = Enterprise_PageCache_Model_Cache::getCacheInstance();

        $cacheInstance->remove(self::FILTER_CACHE_KEY);
        $this->cacheFilters();
    }
}