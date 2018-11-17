<?php
/**
 * Overwrite for Mage_Bundle_Model_Observer to turn off adding bundle items to upsell if item belongs to a bundle
 *
 * @category   Lyons
 * @package    ${MODULENAME}
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class USWF_Bundle_Model_Observer extends Mage_Bundle_Model_Observer
{
    /**
     * DISABLE Observer for -- Append bundles in upsell list for current product
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function appendUpsellProducts($observer)
    {
        return $this;
    }
}