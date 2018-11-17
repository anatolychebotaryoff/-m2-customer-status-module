<?php
/**
 * Rewrite AW_AdvancedReviews_Helper_Data
 *
 * @category  Lyons
 * @package   Lyonscg_AdvancedReviews
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_AdvancedReviews_Helper_Data extends AW_AdvancedReviews_Helper_Data
{
    /**
     * Rewrite to check if product is a grouped product and add child ids to review collection
     *
     * @param null $product
     * @param null $reviews
     * @param null $page
     * @param null $limit
     * @return mixed
     */
    public function getPagerToolbar($product = null, $reviews = null, $page = null, $limit = null) {
        $block = Mage::app()->getLayout()->createBlock('advancedreviews/ajax_pager')->setTemplate('advancedreviews/ajax/pager.phtml');
        $collection = Mage::getModel('review/review')->getCollection();
        $collection->getSelect()->where('status_id = 1');
        if ($product) {
            if (strpos($product, ',') !== false) {
                $product = explode(',', $product);
            } else {
                $product = array($product);
            }
            $childIds = array();
            if ($currentProduct = Mage::registry('current_product')) {
                if ($currentProduct->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                    $childIds = $currentProduct->getTypeInstance()->getAssociatedProductIds($currentProduct);
                }
            }
            $collection->addFieldToFilter('entity_pk_value', array('in' => array_merge($product, $childIds)));
        }

        if (is_array($reviews))
            $reviews = implode(',', $reviews);

        if ($reviews) {
            $collection->getSelect()->where('main_table.review_id IN (' . $reviews . ')');
        }
        if ($page)
            $block->setCurrentPage($page);

        $collection->setCurPage($page);
        $collection->setPageSize($limit);
        $block->setCollection($collection);
        return $block->toHtml();
    }
}
