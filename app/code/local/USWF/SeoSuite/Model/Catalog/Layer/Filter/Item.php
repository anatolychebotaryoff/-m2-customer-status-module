<?php
/**
 * Item.php
 *
 * @category    USWF
 * @package     USWF_SeoSuite
 * @copyright
 * @author
 */
class USWF_SeoSuite_Model_Catalog_Layer_Filter_Item extends MageWorx_SeoSuite_Model_Catalog_Layer_Filter_Item
{

    /**
     * @TODO  Optimize: use collection from block.
     * @param int $id
     * @return bool
     */
    private function _isCategoryAnchor($id)
    {
        if(is_object(Mage::registry('current_category')) && !is_array(Mage::registry('mageworx_category_anchor'))){
            $collection = Mage::registry('current_category')->getChildrenCategories();
            if(is_array($collection) && count($collection) > 0) {
                Mage::register('mageworx_category_anchor', $collection);
            }
        }
        $catData = Mage::registry('mageworx_category_anchor');
        if(is_array($catData) && !empty($catData[$id])){
            return $catData[$id]->getData('is_anchor');
        }
        return false;
    }
}
