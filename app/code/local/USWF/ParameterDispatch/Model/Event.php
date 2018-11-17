<?php
/**
 * USWF Parameter Dispatch Event
 *
 * @category    USWF
 * @package     USWF_ParameterDispatch
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_ParameterDispatch_Model_Event extends Mage_Core_Model_Abstract
{

    protected $cachedCollection;

    protected function _construct()
    {
        $this->_init('uswf_parameterdispatch/event');
    }

    public function getCachedCollection()
    {

	if ($this->cachedCollection) {
            return $cachedCollection;      
        }

        $cache = Mage::app()->getCache();
        $cacheKey = 'parameter-dispatch-events';
        
        if (! $cachedData = $cache->load($cacheKey)) {
            $collection = $this->getCollection()->setOrder('priority', 'ASC')->getData();
            $cachedData = serialize($collection);
            $cache->save(urlencode($cachedData), $cacheKey, array("eventcache"), 60*60*24);
            $this->cachedCollection = $collection;
        } else {
	    $this->cachedCollection = unserialize(urldecode($cachedData));
        }

        return $this->cachedCollection;

    }

}
