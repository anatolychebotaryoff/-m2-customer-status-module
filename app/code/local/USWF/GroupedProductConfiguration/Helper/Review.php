<?php
/**
 * Review.php
 *
 * @category    USWF
 * @package     USWF_GroupedProductConfiguration
 * @copyright
 * @author
 */
class USWF_GroupedProductConfiguration_Helper_Review extends Lyonscg_Review_Helper_Data
{
    /**
     * Refresh all approved reviews -- call the aggregate() function on each
     * returns the number of reviews updated
     *
     * @return int|bool
     */
    public function refreshReviews()
    {
        try {
            $this->deleteReviewEntitySummary();
            $collection = $this->_getCollection();
            $parents = array();
            $grouped = array();
            //prepare simples
            foreach ($collection as $review) {
                $parentIds = $review->getResource()->aggregateSimple($review, true);
                if ($parentIds) {
                    //collect all grouped parents ids for simple products
                    $parents = array_merge($parents, $parentIds);
                }
             }
            $parents= array_unique($parents);
            $parents = array_filter($parents);
            //then prepare grouped
            foreach ($collection as $review) {
                //collect all grouped product ids, that have reviews themselves
                $grouped[] = $review->getResource()->aggregateGrouped($review, true);
            }
            $grouped = array_unique($grouped);
            $grouped = array_filter($grouped);
            //then prepare all grouped products, that have not reviews themselves
            $parents = array_diff($parents, $grouped);
            foreach ($parents as $id) {
                //use last review to manipulate through this cycle (in fact we simply need model object)
                //only this field should be changed
                $review->setEntityPkValue($id);
                $review->getResource()->aggregateGrouped($review);
            }
            return $collection->count() + count($parents);
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete all entries in the review_entity_summary table so they don't pollute things
     *
     * @return $this
     */
    protected function deleteReviewEntitySummary()
    {
        $cr = Mage::getSingleton('core/resource');
        $tableName = $cr->getTableName('review_entity_summary');
        $write = $cr->getConnection('core_write');
        $write->query("DELETE FROM {$tableName};");
        return $this;
    }
}