<?php

class Sam_HardnessDatabase_Block_Zipcheck
    extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    
    protected function _toHtml()
    {
        return Mage::getSingleton('core/layout')->createBlock('core/template')->setTemplate('hardness/zipcheck.phtml')->toHtml();
    }
    
}