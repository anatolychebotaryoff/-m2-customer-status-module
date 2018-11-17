<?php

class USWF_Stockcustomization_Model_Product_Api extends Mage_Catalog_Model_Api_Resource {

    public function updateproductstock(array $productData) {
        foreach ($productData as $productId => $data) {
            $productId = (int) $productId;
            $this->updateOneProductStock($productId, $data);
        }

        $process = Mage::getModel('index/indexer')->getProcessByCode('cataloginventory_stock');
        $process->reindexAll();

    }

    public function updateOneProductStock($productId, $data) {
        $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);

        if ($stockItem && !$stockItem->getProductId()) {
            //First Check to see if the product is found in the system
            //Patches bug
            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('entity_id', array('eq' => $productId))
                ->addAttributeToSelect('entity_id');

            if ($collection->getSize() < 1) {
                return;
            }
            else {
                $stockItem->setData('product_id', $productId);
                $stockItem->setData('stock_id', 1);
            }
        }

        $stockItem->addData($data);
        $stockItem->save();

    }
}
