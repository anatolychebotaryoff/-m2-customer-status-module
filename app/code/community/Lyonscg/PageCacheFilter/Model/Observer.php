<?php
/**
* LyonsCG Page Cache Filter
*
* @category    Lyonscg
* @package     Lyonscg_PageCacheFilter
* @author      Nicholas Hughart (nhughart@lyonscg.com)
* @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
*/

class Lyonscg_PageCacheFilter_Model_Observer
{
    /**
     * Filter out parameters that should be ignored by the entire application.
     * Parameters are filtered from the $_GET and $_SERVER['QUERY_STRING'] values.
     *
     * @param Varien_Event_Observer $observer
     * @throws Zend_Db_Select_Exception
     * @throws Mage_Core_Model_Store_Exception
     * @throws Mage_Core_Exception
     */
    public function filterIgnoredParameters(Varien_Event_Observer $observer)
    {
        // Do not perform this filtering if module is disabled
        if (!Mage::getStoreConfig(Lyonscg_PageCacheFilter_Helper_Data::XML_PATH_CACHE_FILTER_ENABLE)) {
            return;
        }

        // Avoid filtering parameters in admin
        if (Mage::app()->getStore()->isAdmin()) {
            return;
        }

        // No need to process anything if there are no get parameters
        if (empty($_GET)) {
            return;
        }

        // Parse query string so it can be filtered later
        $queryString = $_SERVER['QUERY_STRING'];
        $queryArray = explode('&', $queryString);
        $params = array();
        foreach($queryArray as $queryPair) {
            //we need to make sure that there is actually a key value pair
            $queryArray = explode('=', $queryPair);
            if ($queryArray && count($queryArray) > 1) {
                list($key, $value) = $queryArray;
                $params[$key] = $value;
           }
        }

        $collection = Mage::getResourceModel('lyonscg_pagecachefilter/filter_collection');
        $collection->addFieldToFilter('enabled', array('eq' => 1))
                   ->addFieldToFilter('target', array('eq' => 0))
                   ->addFieldToSelect('param');

        foreach ($collection as $filter) {

            $param = $filter->getParam();
            if (isset($_GET[$param])) {
                return;
            }

        }

        // Retrieve list of parameters that should be excluded from the application
        $collection = Mage::getResourceModel('lyonscg_pagecachefilter/filter_collection');
        $collection->addFieldToFilter('enabled', array('eq' => 1))
                   ->addFieldToFilter('target', array('eq' => 1))
                   ->addFieldToSelect('param');

        // Remove any parameters from $_GET that are set to be ignored.
        foreach ($collection as $filter) {
            $param = $filter->getParam();
            if (isset($_GET[$param])) {
                unset($_GET[$param]);
            }

            if (isset($params[$param])) {
                unset($params[$param]);
            }
        }

        // Rebuild query string variable and overwrite it with filtered version
        // This is necessary due to Magento updating $_GET from the query string
        // when handling rewrites.
        $queryArray = array();
        foreach($params as $key => $value) {
            $queryArray[] = $key . '=' . $value;
        }
        $_SERVER['QUERY_STRING'] = implode('&', $queryArray);
    }
}
