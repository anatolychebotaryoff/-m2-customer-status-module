<?php
/**
 * Improved Cache Clearing/Warming
 *
 * @category    Lyonscg
 * @package     Lyonscg_ImprovedCache
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (http://www.lyonscg.com)
 * @author      Nick Hughart (nhughart@lyonscg.com)
 */
 
class Lyonscg_ImprovedCache_Model_Resource_Cache_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('lyonscg_improvedcache/cache_item');
    }
}