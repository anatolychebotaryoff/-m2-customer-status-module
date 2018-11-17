<?php
/**
 * Lyonscg Review
 *
 * @category    Lyonscg
 * @package     Lyonscg_Review
 * @copyright   Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 * @author      Logan Montgomery (lmontgomery@lyonscg.com)
 */

class Lyonscg_Review_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Get reviews collection we want to potentially refresh
     *
     * @return Mage_Review_Model_Resource_Review_Collection
     */
    protected function _getCollection()
    {
        $collection = Mage::getModel('review/review')->getCollection()
            ->addFieldToFilter('status_id', array('eq' => '1'));

        $collection->getSelect()->group(array('entity_pk_value'));
        return $collection;
    }

    /**
     * Refresh all approved reviews -- call the aggregate() function on each
     * returns the number of reviews updated
     *
     * @return int|bool
     */
    public function refreshReviews()
    {
        try {
            $this->_deleteReviewEntitySummary();
            $collection = $this->_getCollection();
            $totalCount = 0;
            foreach ($collection as $review) {
                $review->aggregate();
                $totalCount++;
            }
            return $totalCount;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get count of reviews to refresh
     *
     * @return int
     */
    public function refreshCount()
    {
        return count($this->_getCollection());
    }

    /**
     * Delete all entries in the review_entity_summary table so they don't pollute things
     *
     * @return $this
     */
    private function _deleteReviewEntitySummary()
    {
        $cr = Mage::getSingleton('core/resource');
        $tableName = $cr->getTableName('review_entity_summary');
        $write = $cr->getConnection('core_write');
        $write->query("DELETE FROM {$tableName};");
        return $this;
    }
}