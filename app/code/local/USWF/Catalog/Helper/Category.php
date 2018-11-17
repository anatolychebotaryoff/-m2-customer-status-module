<?php
/**
 * Category.php
 *
 * @category    USWF
 * @package     USWF_Catalog
 * @copyright
 * @author
 */
class USWF_Catalog_Helper_Category extends Mage_Core_Helper_Abstract
{
    /**
     * Store categories cache
     *
     * @var array
     */
    protected $_storeCategories = array();
    
    /**
     * Retrieve current store categories
     *
     * @param   boolean|string $sorted
     * @param   boolean $asCollection
     * @return  Varien_Data_Tree_Node_Collection|Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection|array
     */
    public function getStoreCategories()
    {
        $parent     = Mage::app()->getStore()->getRootCategoryId();
        $cacheKey   = sprintf('%d-%d-%d-%d', $parent, false, false, true);
        if (isset($this->_storeCategories[$cacheKey])) {
            return $this->_storeCategories[$cacheKey];
        }

        /**
         * Check if parent node of the store still exists
         */
        $category = Mage::getModel('catalog/category');
        /* @var $category Mage_Catalog_Model_Category */
        if (!$category->checkId($parent)) {
            return array();
        }

        $recursionLevel  = max(0, (int) Mage::app()->getStore()->getConfig('catalog/navigation/max_depth'));
        $storeCategories = Mage::getSingleton('uswf_catalog_resource/category_flat')
            ->getCategories($parent, $recursionLevel);
        
        $this->_storeCategories[$cacheKey] = $storeCategories;
        return $storeCategories;
    }
}
