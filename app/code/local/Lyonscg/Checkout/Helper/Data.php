<?php
/**
 * Checkout Helper
 *
 * @category   Lyons
 * @package    Lyonscg_Checkout
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class Lyonscg_Checkout_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Check items in cart can be shipped to current state based on attribute ship_no_<location>
     *
     * @param null $regionId
     * @param null $product
     * @return array
     */
    public function checkItems($regionId = null, $product = null)
    {
        if (empty($regionId)) {
            return array('error' => -1, 'message' => Mage::helper('checkout')->__('State needs to be entered.'));
        }

        $region = Mage::getModel('directory/region')->load($regionId)->getName();

        // Check if doing just one product or all
        $items = array();
        if (!empty($product)) {
            $noShip = $product->getResource()->getAttribute('ship_no_by_location')
                        ->getFrontend()->getValue($product);

            if (!empty($noShip)) {
                if (in_array($region, explode(', ', $noShip))) {
                    $items[] = Mage::helper('checkout')->__('Item %s cannot be shipped to your state.  Please remove the item and process again.', $product->getSku());
                }
            }
        } else {
            foreach (Mage::getSingleton('checkout/type_onepage')->getQuote()->getAllItems() as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $noShip = $product->getResource()->getAttribute('ship_no_by_location')
                            ->getFrontend()->getValue($product);
                if (!empty($noShip)) {
                    if (in_array($region, explode(', ', $noShip))) {
                        $items[] = Mage::helper('checkout')->__('Item %s cannot be shipped to your state.  Please remove the item and process again.', $product->getSku());
                    }
                }
            }
        }

        if (empty($items)) {
            return array();
        } else {
            return array('error' => -1, 'message' => $items);
        }
    }
}