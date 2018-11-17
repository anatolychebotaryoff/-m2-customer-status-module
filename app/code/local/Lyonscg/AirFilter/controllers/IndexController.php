<?php

/**
 * Air filter module landing page controller, renders layout
 *
 * @category    Lyonscg
 * @package     Lyonscg_AirFilter
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 *
 */

class Lyonscg_AirFilter_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout(array('default'));

        // Set Title for page
        $this->getLayout()->getBlock('head')->setTitle($this->__('Air Filter Finder: Furnaces & ACs– DiscountFilterStore.com'));

        // Set Meta Description for page
        $this->getLayout()->getBlock('head')->setDescription($this->__('Find the air filter you need for your furnace or air conditioner, by size, brand or MERV, using the DiscountFilterStore.com Air Filter Finder.'));

        $this->renderLayout();
    }
}
