<?php

class USWF_Elastic_Model_Resource_Product_Indexer_Elastic extends Mage_Index_Model_Resource_Abstract {

    protected function _construct() {
        $this->_init('catalog/product_index_elastic', 'entity_id');
    }

    /**
     * Retrieve parent ids and types by child id
     * Return array with key product_id and value as product type id
     *
     * @param int $childId
     * @return array
     */
    public function getProductParentsByChild($childId)
    {
        $write = $this->_getWriteAdapter();
        $select = $write->select()
            ->from(array('l' => $this->getTable('catalog/product_relation')), array('parent_id'))
            ->join(
                array('e' => $this->getTable('catalog/product')),
                'l.parent_id = e.entity_id',
                array('e.type_id'))
            ->where('l.child_id = ?', $childId);

        return $write->fetchPairs($select);
    }

    /**
     * Reindex product elastic data for specified product ids
     *
     * @param array | int $ids
     * @return Mage_Catalog_Model_Resource_Product_Indexer_Price
     */
    public function reindexProductIds($ids)
    {

        if (empty($ids)) {
            return $this;
        }
        if (!is_array($ids)) {
            $ids = array($ids);
        }

        foreach ($ids as $id) {
            $this->getProductDataStores($id);
        }

        return $this;

    }

    public function getProductDataStores($productId) {

        $stores = array_merge(array("0" => ""), Mage::app()->getStores());

        foreach ( $stores as $sId => $sCode) {
            $store = Mage::getSingleton('core/store')->load($sId);
            $c = Mage::getModel('catalog/product')->getCollection()->addStoreFilter($sId)->addAttributeToSelect('*');
            $c->addAttributeToFilter('type_id', array('eq'=>'simple'));
            $c->addAttributeToFilter('entity_id', array('eq'=> $productId ));

            foreach ($c as $product) {

                $_p = $this->getProductData($product, $store);
                $_p["price"] = $product->getPrice();
                $update = Mage::getSingleton('uswf_elastic/adapter')->update("products", $_p);
                Mage::log($update, null, "elastic_update.log");

            }

        }

    }

    private function getProductData($product, $store) {

        $fullModel = Mage::getModel('catalog/product')->setStoreId($store->getId())->setEntityId($product->getId());

        $_p = $product->getData();

        $_p["upsell_products"] = $product->getUpsellProductIds();

        $thumbnail = Mage::getModel('catalog/product_media_config')->getMediaUrl( $product->getThumbnail() );

        //$thumbnail = Mage::helper('catalog/image')->init($product, 'thumbnail');
        //if ($thumbnail) {
            $_p["thumbnail"] = (string) $thumbnail;
        //}
        $_p["related_products"] = $product->getRelatedProductIds();


        $tierPrices = $fullModel->getData('tier_price');
        if (is_null($tierPrices)) {
            $attribute = $fullModel->getResource()->getAttribute('tier_price');
            if ($attribute) {
                $attribute->getBackend()->afterLoad($fullModel);
                $tierPrices = $fullModel->getData('tier_price');
            }
        }

        $group_prices = $fullModel->getData('group_price');
        if (is_null($group_prices)) {
            $attribute = $fullModel->getResource()->getAttribute('group_price');
            if ($attribute) {
                $attribute->getBackend()->afterLoad($fullModel);
                $group_prices = $fullModel->getData('group_price');
            }
        }

        $rc = Mage::getResourceModel('catalog/product');
        $price = $rc->getAttributeRawValue( $product->getId(), 'price', $store->getId());

        $_p["price"] = $price;

        $_p["tier_price"] = $tierPrices;
        $_p["group_price"] = $group_prices;
        $_p["minimum_cart_qty"] = Mage::getModel("cataloginventory/stock_item")
            ->loadByProduct($product->getId())->getMinSaleQty();
        $_p["compatible"] = $fullModel->getCompatible();
        $_p["system_models_show"] = $fullModel->getSystemModelsShow();
        $_p["store_id"] = $store->getId();
        $_p["bundles"] = array();

        $bundleIds = Mage::getResourceSingleton('bundle/selection')->getParentIdsByChild($product->getId());

        foreach ($bundleIds as $bundleId) {
            $bundle = Mage::getModel('catalog/product')->setStoreId($store->getId())->setEntityId($bundleId);
            if ($bundle && $bundle->getStatus() == "1" ) {
                if (in_array($store->getId(), $bundle->getWebsiteIds())) {
                    $bundle = Mage::getModel('catalog/product')->setStoreId($store->getId())->load($bundleId);
                    if ( sizeOf( $bundle->getTypeInstance(true)->getOptionsIds($bundle))  == 1) {
                        $_p["bundles"][] = $this->getProductData($bundle, $store);
                    }
                }
            }
        }

        return $_p;
    }

    /**
     * Rebuild all index data
     * @return Mage_Catalog_Model_Resource_Product_Indexer_Price
     */
    public function reindexAll() {

        $products = Mage::getModel('catalog/product')->getCollection();
        $productIds = $products->getAllIds();

        $this->reindexProductIds($productIds);

    }


}
