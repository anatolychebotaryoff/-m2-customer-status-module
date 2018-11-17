<?php
/**
 * Rewrite AW_AdvancedReviews_Model_Mysql4_Review
 *
 * @category  Lyons
 * @package   Lyonscg_AdvancedReviews
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_AdvancedReviews_Model_Mysql4_Review extends AW_AdvancedReviews_Model_Mysql4_Review
{
    /**
     * Rewrite to check if product is a grouped product and add child ids to review collection
     *
     * @param null $proscons
     * @param $storeId
     * @param null $product_id
     * @param null $customerId
     * @return array
     */
    public function getReviewsByProscons($proscons = null,$storeId,$product_id = null,$customerId = null){
        $reviews = Mage::getModel('review/review')->getCollection();
        $reviews->getSelect()
            ->joinLeft(array('proscons'=>$this->getTable('advancedreviews/proscons_vote')),'main_table.review_id = proscons.review_id',array('proscons_ids'=>'GROUP_CONCAT(proscons.proscons_id)'))
            ->group('main_table.review_id')
            ->join(array('review_store'=>$this->getTable('review/review_store')),'main_table.review_id = review_store.review_id AND review_store.store_id = '.$storeId,array('true_store_id'=>'store_id'))
            ->having('true_store_id = ?',Mage::app()->getStore()->getId())
            ->where('status_id = 1')
        ;

        if($product_id) {
            $childIds = array();
            if ($currentProduct = Mage::registry('current_product')) {
                if ($currentProduct->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                    $childIds = $currentProduct->getTypeInstance()->getAssociatedProductIds($currentProduct);
                }
            }
            $reviews->addFieldToFilter('entity_pk_value', array('in' => array_merge(array($product_id), $childIds)));
        }

        if($customerId)
            $reviews->getSelect()->where('customer_id = ?',$customerId);

        if($proscons){
            $tags = explode(',',$proscons);
            foreach($tags as $id)
                $reviews->getSelect()->having('(`proscons_ids`  LIKE \''.$id.'\') OR (`proscons_ids`  LIKE \'%,'.$id.',%\') OR (`proscons_ids`  LIKE \''.$id.',%\') OR (`proscons_ids`  LIKE \'%,'.$id.'\')');
        }

        $vote = Mage::getModel('advancedreviews/proscons');
        $votesCollection = $vote->getCollection();
        $votesCollection->getSelect()
            ->joinLeft(array('proscons_store'=>$this->getTable('advancedreviews/proscons_store')),'main_table.id = proscons_store.proscons_id',array())
            ->order('sort_order ASC')
            ->where('status = 1')
            ->where('store_id = ?',Mage::app()->getStore()->getId());
        $votes = $votesCollection->getData();




        $filteredReviews = $reviews->getData();
        $filters = array();
        $reviewsIds = array();
        foreach($filteredReviews as $review){
            $reviewsIds[] = $review['review_id'];
            $rFilters = explode(',',$review['proscons_ids']);
            foreach($rFilters as $filter){
                if(isset($filters[$filter]))
                    $filters[$filter]+=1;
                else
                    $filters[$filter]=1;
            }
        }


        //sort $filters by sort_order
        foreach($votes as $key=>$vote){
            if(array_key_exists($vote['id'], $filters)){
                $votes[$key]['qty'] = $filters[$vote['id']];
            }
            else{
                unset($votes[$key]);
            }
        }

        return array('reviews'=>$reviewsIds,'votes'=>$votes);
    }

    /**
     * Rewrite to check if product is a grouped product and add child ids to review collection
     *
     * @param $product
     * @param $reviews
     * @param int $page
     * @param int $limit
     * @param null $sortBy
     * @param string $sortDir
     * @param null $customerId
     * @return Mage_Review_Model_Resource_Review_Collection
     */
    public function getFilteredReviews($product,$reviews, $page = 1, $limit = 10,$sortBy = null,$sortDir = 'DESC',$customerId = null){

        if(!$sortBy){
            $sortBy = Mage::helper('advancedreviews')->confOrderingItemsArray();
            $sortBy = @$sortBy[0]['value'];

        }

        if(is_array($reviews))
            $reviews = implode(',', $reviews);

        $collection = Mage::getModel('review/review')->getCollection();
        $collection->getSelect()
            ->join(array('review_store'=>$collection->getTableName('review/review_store')),'main_table.review_id = review_store.review_id AND review_store.store_id = '.Mage::app()->getStore()->getId(),array('true_store_id'=>'store_id'))
            //->having('true_store_id = ?',Mage::app()->getStore()->getId())
            ->limit($limit,($page-1)*$limit)
            ->where('status_id = 1')
        ;
        if($customerId != '')
            $collection->getSelect()->where('customer_id = ?',$customerId);
        if($product != '') {
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
            $collection->addFieldToFilter('main_table.entity_pk_value', array('in' => array_merge($product, $childIds)));
        }
        if($reviews != '')
            $collection->getSelect()->where('main_table.review_id IN ('. $reviews .')');

        $collection->getSelect()->reset('order');
        if($sortBy === AW_AdvancedReviews_Model_Mysql4_Review_Collection::ORDER_BY_DATE)
        {
            $collection->getSelect()->order('main_table.created_at ' . $sortDir);

        }
        elseif ($sortBy === AW_AdvancedReviews_Model_Mysql4_Review_Collection::ORDER_BY_RATING)
        {
            $ratingTableName = $collection->getTableName('rating/rating_option_vote');
            $collection->getSelect()->joinLeft(array('ov' => $ratingTableName),
                '(ov.review_id = main_table.review_id)',
                array('summa' => 'AVG(percent)'))->group('main_table.review_id');
            $collection->getSelect()->order('summa ' . $sortDir);
        }
        elseif ($sortBy === AW_AdvancedReviews_Model_Mysql4_Review_Collection::ORDER_BY_HELPFULNESS)
        {
            $helpfulnessTable = $collection->getTableName('advancedreviews/helpfulness');
            $collection->getSelect()
                ->joinLeft( array( 'helpfulness' => $helpfulnessTable ),
                    'main_table.review_id = helpfulness.review_id',
                    array( 'all_count' => 'COUNT(helpfulness.id)',
                        'yes_count' => 'SUM(helpfulness.value)' ))
                ->group('main_table.review_id');
            $collection->getSelect()->order('yes_count ' . $sortDir);
        }
        return $collection;
    }
}
