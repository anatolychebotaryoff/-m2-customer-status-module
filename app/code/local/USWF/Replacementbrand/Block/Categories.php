<?php
/**
 * Category.php
 *
 * @category    USWF
 * @package     USWF_Replacementbrand
 * @copyright
 * @author
 */

class USWF_Replacementbrand_Block_Categories extends Mage_Core_Block_Template
{
    const CAT_BLANK_IMAGE_NAME_CONFIG_PATH = 'uswf_replacementbrand/categories/blank_image';
    
    /**
     * Returns category collection to display on home page of replacement brand
     * 
     * @return array
     */
    public function getHomePageCategories() {
        $storeId = Mage::app()->getStore()->getId();
        $rootCatId = Mage::app()->getStore()->getRootCategoryId();
        $collection = Mage::getModel('catalog/category')->getCollection()
            ->setStoreId($storeId)
            ->addAttributeToFilter('path', array('like' => "1/{$rootCatId}/%"))
            ->addIsActiveFilter()
            ->addAttributeToFilter('replacement_brand_home', 1)
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('image')
            ->load()
            ->getItems();
        return $collection;
    }

    /**
     * Returns category image url
     * 
     * @param Mage_Catalog_Model_Category $category
     * @return string
     */
    public function getCategoryImageUrl($category) {
        return $category->getImageUrl() ? $category->getImageUrl() :
            $this->getSkinUrl('images/' . Mage::getStoreConfig(self::CAT_BLANK_IMAGE_NAME_CONFIG_PATH));
    }
}