<?php

class USWF_Stockcustomization_Helper_data extends Mage_Catalog_Helper_data {

    /*
	For a simple product, find the stock configurations and if its in stock or not
	*/
    public function isBackordered($simple_item, $qty=2) {

	if (!$simple_item) {
            return false;
        }

	$stockData = $simple_item->getStockItem();
	$availableQty = $stockData->getData('qty');
	$manageStock = $stockData->getData('manage_stock');

        if (!$manageStock) {
            return false;
        }

        if ($availableQty >= $qty) {
            return false;
        }

        return true;
    }


    public function groupedSimpleItem($product) {
	/*
	For a given grouped product, loop through its associations and return the first simple item
	This design is based on how DFS sets up product today
	*/

        if ($product->getTypeId() == 'grouped') {

            $_associatedProducts = $product->getTypeInstance(true)
                ->getAssociatedProducts($product);

            foreach ($_associatedProducts as $_item) {
                $typeId = $_item->getTypeId();
                if ($typeId == 'simple') {
                    return $_item;
                }
            }
        } elseif ($product->getTypeId() == 'bundle') {
            $collection = $product->getTypeInstance(true)
                ->getSelectionsCollection($product->getTypeInstance(true)->getOptionsIds($product), $product);
            foreach ($collection as $p) {
                return $p;
            }
       
        } else {
            return $product;
        }

	    return null;

    }
}
