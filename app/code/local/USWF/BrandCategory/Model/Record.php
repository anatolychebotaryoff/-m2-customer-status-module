<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Model_Record extends Mage_Core_Model_Abstract
{

    protected $cachedCollection;

    protected function _construct()
    {
        $this->_init('uswf_brandcategory/record');
    }

    public function getCachedCollection()
    {

	    if ($this->cachedCollection) {
            return $this->cachedCollection;
        }

        $cache = Mage::app()->getCache();
        $cacheKey = 'brand-category-records';
        
        if (! $cachedData = $cache->load($cacheKey)) {
            $collection = $this->getCollection()->setOrder('name', 'ASC')->getData();
            $cachedData = serialize($collection);
            $cache->save(urlencode($cachedData), $cacheKey, array("recordcache"), 60*60*24);
            $this->cachedCollection = $collection;
        } else {
	        $this->cachedCollection = unserialize(urldecode($cachedData));
        }

        return $this->cachedCollection;

    }

}
