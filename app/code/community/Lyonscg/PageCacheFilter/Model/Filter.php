<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Model_Filter extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('lyonscg_pagecachefilter/filter');
    }
}
