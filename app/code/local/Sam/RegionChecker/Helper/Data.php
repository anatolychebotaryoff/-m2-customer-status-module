<?php

class Sam_RegionChecker_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function checkItems($regionId = null, $products)
    {
        if (empty($regionId)) {
            return array('error' => -1, 'message' => Mage::helper('checkout')->__('State needs to be entered.'));
        }

        $region = Mage::getModel('directory/region')->load($regionId)->getName();

        // Check if doing just one product or all
        $items = array();
        foreach ($products as $item) {

            $product = Mage::getModel('catalog/product')->load($item->getProductId());

            $noShip = $product->getResource()->getAttribute('ship_no_by_location')
                        ->getFrontend()->getValue($product);

            if (!empty($noShip)) {
                if (in_array($region, explode(', ', $noShip))) {
                    $items[] = Mage::helper('checkout')->__('Item %s cannot be shipped to your state.  Please remove the item and process again.', $product->getSku());
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
