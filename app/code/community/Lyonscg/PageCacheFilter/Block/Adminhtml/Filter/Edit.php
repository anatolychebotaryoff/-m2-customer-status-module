<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Block_Adminhtml_Filter_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Edit page block initialize
     */
    public function __construct()
    {
        $this->_blockGroup = 'lyonscg_pagecachefilter';
        $this->_controller = 'adminhtml_filter';
        $this->_objectId = 'id';

        parent::__construct();
    }

    /**
     * Return header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        $model = Mage::registry('lyonscg_pagecachefilter_filter');
        if ($model && $model->getId()) {
          return Mage::helper('lyonscg_pagecachefilter')
              ->__("Edit '%s' Filter", $this->escapeHtml($model->getParam()));
        }
        else {
          return Mage::helper('lyonscg_pagecachefilter')->__('New Filter');
        }
    }
}
