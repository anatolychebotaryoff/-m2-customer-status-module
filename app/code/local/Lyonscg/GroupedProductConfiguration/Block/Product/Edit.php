<?php
/**
 * Rewrite Itoris_GroupedProductConfiguration_Block_Product_Edit
 *
 * @category  Lyons
 * @package   Lyonscg_GroupedProductConfiguration
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_GroupedProductConfiguration_Block_Product_Edit
    extends Itoris_GroupedProductConfiguration_Block_Product_Edit
{
    protected function _prepareLayout() {
        $foot = $this->getLayout()->getBlock('foot');
        if ($foot) {
            $foot->addItem('skin_js', 'js/bundle.js');
        }
        return Mage_Core_Block_Abstract::_prepareLayout();
    }
}
