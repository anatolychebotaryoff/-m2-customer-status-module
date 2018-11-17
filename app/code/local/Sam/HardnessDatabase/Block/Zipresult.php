<?php

class Sam_HardnessDatabase_Block_Zipresult
    extends Mage_Core_Block_Template
{
    
    protected function _toHtml()
    {
        $block = Mage::getSingleton('core/layout')->createBlock('core/template');
        if(Mage::registry('hardness_data')) {
            $block->setData('hardness', Mage::registry('hardness_data'));
        }
        return $block->setTemplate('hardness/zipresult.phtml')->toHtml();
    }
    
}