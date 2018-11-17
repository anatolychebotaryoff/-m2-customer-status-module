<?php

/**
 * Air filter module result page controller, renders layout if size is passed, otherwise says 404
 *
 * @category    Lyonscg
 * @package     Lyonscg_AirFilter
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 *
 */

class Lyonscg_AirFilter_ResultController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $size = $this->getRequest()->getParam('size');
        $position = $this->getRequest()->getParam('position');
        if($size){
            $this->loadLayout();
            $filterBlock = $this->getLayout()->getBlock('resultset');
            $filterBlock->setSize($size);
            if($position){
                $filterBlock->setSliderPosition($position);
            }

            // Set Title for page
            $this->getLayout()->getBlock('head')->setTitle($this->__('Air Filter Finder: Furnaces & ACs– DiscountFilterStore.com'));

            // Set Meta Description for page
            $this->getLayout()->getBlock('head')->setDescription($this->__('Find the air filter you need for your furnace or air conditioner, by size, brand or MERV, using the DiscountFilterStore.com Air Filter Finder.'));

            $this->renderLayout();
        } else {
            $cache = Mage::app()->getCacheInstance();
            $cache->banUse('full_page'); 
            $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
            $this->getResponse()->setHeader('Status','404 File not found');
            $this->_forward('defaultNoRoute');
        }
    }
}
