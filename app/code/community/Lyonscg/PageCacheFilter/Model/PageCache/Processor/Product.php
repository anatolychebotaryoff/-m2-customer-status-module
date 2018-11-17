<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Model_PageCache_Processor_Product extends Enterprise_PageCache_Model_Processor_Product
{
    /**
     * Return cache page id with application. Depends on catalog session and GET super global array.
     * Also makes a call out to cacheFilters to save (if necessary) an updated list of query filters.
     *
     * @param Enterprise_PageCache_Model_Processor $processor
     * @return string
     */
    public function getPageIdInApp(Enterprise_PageCache_Model_Processor $processor)
    {
        Mage::helper('lyonscg_pagecachefilter')->cacheFilters();

        return parent::getPageIdInApp($processor);
    }

    /**
     * Return cache page id without application. Depends on GET super global array.
     * GET super global is filtered before and restored after generating the ID.
     *
     * @param Enterprise_PageCache_Model_Processor $processor
     * @return string
     */
    public function getPageIdWithoutApp(Enterprise_PageCache_Model_Processor $processor)
    {
        $saved = $this->_filter();

        $return = parent::getPageIdWithoutApp($processor);

        $this->_restore($saved);

        return $return;
    }

    /**
     * Return array of query filter objects.
     *
     * @return array
     */
    private function _getFilters()
    {
        $cacheInstance = Enterprise_PageCache_Model_Cache::getCacheInstance();

        $filters = $cacheInstance->load(Lyonscg_PageCacheFilter_Helper_Data::FILTER_CACHE_KEY);
        if ($filters) {
            return (unserialize(urldecode($cacheInstance->load(Lyonscg_PageCacheFilter_Helper_Data::FILTER_CACHE_KEY))));
        } else {
            return array();
        }
    }

    /**
     * Removes any filterable parameters from the GET super global
     *
     * @return array
     */
    private function _filter()
    {
        $filters = $this->_getFilters();

        $filteredParams = array();
        foreach ($filters as $filter) {
            $param = $filter['param'];

            if (isset($_GET[$param])) {
                $filteredParams[$param] = $_GET[$param];
                unset($_GET[$param]);
            }
        }

        return $filteredParams;
    }

    /**
     * Restores any filtered parameters back into the GET super global
     *
     * @param array $filteredParams
     */
    private function _restore($filteredParams)
    {
        $_GET = array_merge($_GET, $filteredParams);
    }
}