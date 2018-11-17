<?php
/**
 * Rewrite AW_AdvancedReviews_Block_Ajax_Pager
 *
 * @category  Lyons
 * @package   Lyonscg_AdvancedReviews
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_AdvancedReviews_Block_Ajax_Pager extends AW_AdvancedReviews_Block_Ajax_Pager
{
    /**
     * Rewrite to check if product is a grouped product and add child ids to review collection
     *
     * @return Mage_Review_Model_Resource_Review_Collection|null
     */
    public function getCollection()
    {
        if(!$this->_collection){
            $collection = Mage::getModel('review/review')->getCollection();
            $collection->getSelect()
                ->where('status_id = 1')
                ->join(array('review_store'=>$collection->getTableName('review/review_store')),'main_table.review_id = review_store.review_id AND review_store.store_id = '.Mage::app()->getStore()->getId(),array('true_store_id'=>'store_id'))
            ;
            if($productID = $this->getRequest()->getParam('id')) {
                $childIds = array();
                if ($currentProduct = Mage::registry('current_product')) {
                    if ($currentProduct->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                        $childIds = $currentProduct->getTypeInstance()->getAssociatedProductIds($currentProduct);
                    }
                }
                $collection->addFieldToFilter('entity_pk_value', array('in' => array_merge(array($productID), $childIds)));
            }
            if($customerID = $this->getRequest()->getParam('customerId'))
                $collection->getSelect()->where('customer_id = ?',$customerID);
            $this->_collection = $collection;
            $this->_collection->setPageSize(10);
        }
        return $this->_collection;
    }
}
