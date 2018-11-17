<?php
/**
 * Rewrite Mage_Review_Model_Review
 *
 * @category  Lyons
 * @package   Lyonscg_Review
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_Review_Model_Review extends Mage_Review_Model_Review
{
    /**
     * Rewrite to add child products summary data for reviews
     *
     * @param $product Mage_Catalog_Model_Product
     * @param int $storeId
     */
    public function getEntitySummary($product, $storeId=0)
    {
        // Load Current Product Summary Review Data
        $summaryData = Mage::getModel('review/review_summary')
            ->setStoreId($storeId)
            ->load($product->getId());

        // If product type is grouped then we need to get all children reviews
        if ($product->getTypeId() === Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
            $associatedProducts = $product->getTypeInstance()->getAssociatedProducts($product);
            foreach ($associatedProducts as $associatedProduct) {
                if (!$ratingSummary = $product->getRatingSummary()) {
                    $associatedProductSummaryData = Mage::getModel('review/review_summary')
                        ->setStoreId($storeId)
                        ->load($associatedProduct->getId());
                    if ($associatedProductSummaryData) {
                        $summaryData->setReviewsCount($summaryData->getReviewsCount() + $associatedProductSummaryData->getReviewsCount());
                        if ($summaryData->getRatingSummary() == 0 || $associatedProductSummaryData->getRatingSummary() == 0) {
                            $summaryData->setRatingSummary(round($summaryData->getRatingSummary() + $associatedProductSummaryData->getRatingSummary()));
                        } else {
                            $summaryData->setRatingSummary(round(($summaryData->getRatingSummary() + $associatedProductSummaryData->getRatingSummary()) / 2));
                        }
                    }
                } else {
                    $summaryData->setReviewsCount($summaryData->getReviewsCount() + $associatedProductSummaryData->getReviewsCount());
                    if ($summaryData->getRatingSummary() == 0 || $associatedProductSummaryData->getRatingSummary() == 0) {
                        $summaryData->setRatingSummary(round($summaryData->getRatingSummary() + $associatedProductSummaryData->getRatingSummary()));
                    } else {
                        $summaryData->setRatingSummary(round(($summaryData->getRatingSummary() + $associatedProductSummaryData->getRatingSummary()) / 2));
                    }
                }
            }
        }

        $summary = new Varien_Object();
        $summary->setData($summaryData->getData());
        $product->setRatingSummary($summary);
    }

    /**
     * Rewrite to add child products summary data for reviews
     * Append review summary to product collection
     *
     * @param Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $collection
     * @return Mage_Review_Model_Review
     */
    public function appendSummary($collection)
    {
        $parentLinks = array();
        $entityIds = array();
        foreach ($collection->getItems() as $_itemId => $_item) {
            $entityIds[] = $_item->getEntityId();
            if ($_item->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                $associatedProducts = $_item->getTypeInstance()->getAssociatedProductIds($_item);
                foreach ($associatedProducts as $id) {
                    $parentLinks[$_item->getEntityId()][] = $id;
                    $entityIds[] = $id;
                }
            }
        }

        if (sizeof($entityIds) == 0) {
            return $this;
        }

        $summaryData = Mage::getResourceModel('review/review_summary_collection')
            ->addEntityFilter($entityIds)
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->load();

        foreach ($collection->getItems() as $_item ) {
            foreach ($summaryData as $_summary) {
                if (($_summary->getEntityPkValue() == $_item->getEntityId()) ||
                    (isset($parentLinks[$_item->getEntityId()]) && in_array($_summary->getEntityPkValue(), $parentLinks[$_item->getEntityId()])))
                {
                    $ratingSummary = $_item->getRatingSummary();
                    if ($ratingSummary === null) {
                        $_item->setRatingSummary($_summary);
                    } else {
                        $ratingSummary->setReviewsCount($ratingSummary->getReviewsCount() + $_summary->getReviewsCount());
                        if ($ratingSummary->getRatingSummary() == 0 || $_summary->getRatingSummary() == 0) {
                            $ratingSummary->setRatingSummary(round($ratingSummary->getRatingSummary() + $_summary->getRatingSummary()));
                        } else {
                            $ratingSummary->setRatingSummary(round(($ratingSummary->getRatingSummary() + $_summary->getRatingSummary()) / 2));
                        }
                    }
                }
            }
        }

        return $this;
    }
}
