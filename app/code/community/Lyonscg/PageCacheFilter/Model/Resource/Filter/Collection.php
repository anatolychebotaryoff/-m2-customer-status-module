<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Model_Resource_Filter_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('lyonscg_pagecachefilter/filter');
    }
}