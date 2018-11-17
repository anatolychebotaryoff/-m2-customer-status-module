<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Model_Observer
{

    private function setStoreBrandRecords($brandIds, $store_id) {

        foreach ($brandIds as $brand) {

            $brandCategories = Mage::getModel('uswf_brandcategory/record')
                ->getCollection()
                ->addFieldToFilter('brand', array('eq' => $brand['value']))
                ->addFieldToFilter('store_id', $store_id)
                ->load();

            $brandCategory = $brandCategories->getFirstItem();

            if (!$brandCategory->getId()) {
                $brandCategory = Mage::getModel('uswf_brandcategory/record');
                $brandCategory->setBrand($brand['value']);
                $brandCategory->setStoreId($store_id);
                $brandCategory->save();
            }


        }

    }


    public function updateBrandCategories($observer) {

        if ($observer->getDataObject()->getData('attribute_code') == 'brand') {

            $brandIds = Mage::helper('uswf_brandcategory')->getAllBrandsArray();

            $allStores = Mage::app()->getStores();
            foreach ($allStores as $store) {
                $storeId = $store->getId();

                $storeBrands = $this->setStoreBrandRecords($brandIds, $storeId);

            }

        }


    }

}
