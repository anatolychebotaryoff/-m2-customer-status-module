<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Block_Adminhtml_Filter extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Render grid, add buttons
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_filter';
        $this->_blockGroup = 'lyonscg_pagecachefilter';
        $this->_headerText = Mage::helper('lyonscg_pagecachefilter')->__('Full Page Cache Filters');
        $this->_addButtonLabel = Mage::helper('lyonscg_pagecachefilter')->__('Add New Filter');

        parent::__construct();
    }
}
