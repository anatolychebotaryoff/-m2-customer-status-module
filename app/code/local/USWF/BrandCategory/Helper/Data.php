<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */
 
class USWF_BrandCategory_Helper_Data extends Mage_Core_Helper_Abstract
{



    public function getBrandCategoryIds($store_id = 0) {

        $brandCategoryIds = Mage::getStoreConfig('catalog/brand_category/uswf_brandcategory_roots', $store_id);

        $brandCategoryIds = array_map('trim', explode(',', $brandCategoryIds));

        return $brandCategoryIds;

    }

    public function getBrandHtml($product) {


        $brandIds = Mage::getResourceModel('catalog/product')->getAttributeRawValue($product->getId(), 'brand', Mage::app()->getStore()->getId());
        $brandIds = array_map('trim', explode(',', $brandIds));

        $brandAttr = $product->getResource()->getAttribute('brand');

        $outBrands = array();

        foreach ($brandIds as $brandId) {

            $brandMap = Mage::getModel('uswf_brandcategory/record')
                ->getCollection()
                ->addFieldToSelect('id')
                ->addFieldToSelect('brand')
                ->addFieldToSelect('record')
                ->addFieldToFilter('enabled', array('eq' => '1'))
                ->addFieldToFilter('brand', array('eq' => $brandId))
                ->addFieldToFilter('store_id', array('eq' => Mage::app()->getStore()->getId()))
                ->load();

            $brandMap = $brandMap->getFirstItem();

            if ($brandMap->getData('id')) {

                $catData = Mage::getModel('catalog/category')->load($brandMap->getRecord());
                $outBrands[] = '<a href="' . $catData->getUrl($catData) . '">'. $brandAttr->getSource()->getOptionText($brandId) .'</a>';

            } else {

                $outBrands[] = $brandAttr->getSource()->getOptionText($brandId);
            }



        }

        return implode (', ', $outBrands);

    }

    public function getAllBrandsArray($optionList = false) {

        $attribute = Mage::getSingleton('eav/config')
            ->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'brand');
        
        if ($attribute->usesSource()) {
            $options = $attribute->getSource()->getAllOptions(false);
        }

        
        return $options;

    }

    public function getAllCategoriesArray($optionList = false, $store_id = 0) {


        $categories = array();

        foreach ( $this->getBrandCategoryIds($store_id) as $brandCategoryId) {
            $categoriesArray = Mage::getModel('catalog/category')
                ->getCollection()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('url_path')
                ->addAttributeToSelect('depth')
                ->addAttributeToSort('name', 'asc')
                ->addFieldToFilter('is_active', array('eq' => '1'))
                ->addFieldToFilter('parent_id', array('eq' => $brandCategoryId))
                ->load()
                ->toArray();

            $brandCategory = Mage::getModel('catalog/category')->load($brandCategoryId);
            $parentCategory = $brandCategory->getParentCategory();

            $categories[$brandCategoryId] = array(
                'value' => array(),
                'label' => $parentCategory->getName() . '-' . Mage::getModel('catalog/category')->load($brandCategoryId)->getName(),
            );

            foreach ($categoriesArray as $categoryId => $category) {
                if (isset($category['url_path'])) {
                    $categories[$brandCategoryId]['value'][] = array(
                        'value' => $category['entity_id'],
                        'label' => '  ' . Mage::helper('uswf_brandcategory')->__($category['name'])
                    );
                }
            }

        }
     
        return $categories;
    } 

}
