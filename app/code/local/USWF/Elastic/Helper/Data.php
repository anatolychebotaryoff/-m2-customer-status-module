<?php

class USWF_Elastic_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function loadProduct( $id ) {

        $adapter = Mage::getSingleton('uswf_elastic/adapter');

        return $adapter->loadRecord('products', $id);

    }

    public function getElasticKeywords($product) {

        $keywords = array();

        $attributes = array( "sku", "name", "size_advertised", "manufacturer_id" );

        foreach ($attributes as $attribute_code) {

            $rawText = $product->getResource()->getAttribute($attribute_code)->getFrontend()->getValue($product);


            $squashText = str_replace("-", "", str_replace(" ", "", $rawText));
            $filterText = str_replace("-", " ", $rawText);

            $keywords[] = $rawText;
            $keywords[] = $squashText;
            $keywords[] = $filterText;


        }

        return implode($keywords, " ");

    }

    private function getProductData($product, $store) {

        $fullModel = Mage::getModel('catalog/product')->setStoreId($store->getId())->setEntityId($product->getId());

        $_p = $product->getData();

        $_p["upsell_products"] = $product->getUpsellProductIds();
        $_p["thumbnail"] = (string) Mage::helper('catalog/image')->init($product, 'thumbnail')->resize(100);
        $_p["related_products"] = $product->getRelatedProductIds();

        $_p["elastic_keywords"] = $this->getElasticKeywords($product);


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
            $bundle = Mage::getModel('catalog/product')->setStoreId($store->getId())->setEntityId($bundleId); //load($bundleId);
            if ($bundle && $bundle->getStatus() == "1" ) {
                if (in_array($store->getId(), $bundle->getStoreIds())) {
                    $bundle = Mage::getModel('catalog/product')->setStoreId($store->getId())->load($bundleId);
                    if ( sizeOf( $bundle->getTypeInstance(true)->getOptionsIds($bundle))  == 1) {
                        $_p["bundles"][] = $this->getProductData($bundle, $store);
                    }
                }
            }
        }

        return $_p;
    }


    public function reindexProducts() {

        $stores = array_merge(array("0" => ""), Mage::app()->getStores());

        foreach ( $stores as $sId => $sCode) {
            $store = Mage::getSingleton('core/store')->load($sId);
            $c = Mage::getModel('catalog/product')->getCollection()->addStoreFilter($sId)->addAttributeToSelect('*');
            $c->addAttributeToFilter('type_id', array('eq'=>'simple'));

            $c->setPageSize(100);

            $pages = $c->getLastPageNumber();
            $currentPage = 1;

            do {
                $c->setCurPage($currentPage);
                $c->load();
                foreach ($c as $product) {

                    if (in_array($sId, $product->getStoreIds())) {
                        $_p = $this->getProductData($product, $store);
                        $_p["price"] = $product->getPrice();
                        Mage::getSingleton('uswf_elastic/adapter')->update("products", $_p);
                    }

                }
                $currentPage++;
                $c->clear();

            } while ($currentPage <= $pages);

        }

    }

    public function searchProducts( $term ) {

        $complex_query = array(
            "size" => 20,
            "sort" => array(
                array("not_for_sale" => array("order" => "asc"))
            ),
            "query" => array(
                "bool" => array(
                    "must" => array(
                        array(
                            "multi_match" => array(
                                "query" => $term,
                                "fields" => array(
                                    "manufacturer_id",
                                    "compatible",
                                    "system_models_show",
                                    "description",
                                    "sku",
                                    "name"
                                )
                            )
                        ),
                        array(
                            "match" => array(
                                "type_id" => "simple"
                            )
                        )
                    ),
                    "should" => array(
                        array(
                            "match" => array(
                                "compatible" => $term
                            )
                        ),
                        array(
                            "match" => array(
                                "system_models_show" => $term
                            )
                        )
                    )
                )
            ),
            "highlight" => array(
                "fields" => array(
                    "manufacturer_id" => array(),
                    "compatible" => array(),
                    "system_models_show" => array()
                )
            )
        );

        $adapter = Mage::getSingleton('uswf_elastic/adapter');

        return $adapter->search('products', $complex_query);

    }

}
