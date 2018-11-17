<?php
/**
 * Review.php
 *
 * @category    USWF
 * @package     USWF_GroupedProductConfiguration
 * @copyright
 * @author
 */

class USWF_GroupedProductConfiguration_Model_Resource_Review extends Mage_Review_Model_Resource_Review
{

    /**
     * Return product type
     * 
     * @param $productId
     * @return mixed
     */
    protected function getProductType($productId) {
        $select = $this->_getReadAdapter()
            ->select()
            ->from($this->getTable('catalog/product'), array('type_id'))
            ->where('entity_id = :entity_id')
            ->limit(1);
        $bind = array(':entity_id' => $productId);
        return $this->_getReadAdapter()->fetchOne($select, $bind);
    }
    
    /**
     * Aggregate
     *
     * @param Mage_Core_Model_Abstract $object
     */
    public function aggregate($object)
    {
        if (!$object->getEntityPkValue() && $object->getId()) {
            $object->load($object->getReviewId());
        }
        if ($this->getProductType($object->getEntityPkValue()) === Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
            $this->aggregateGrouped($object);
        } else {
            if ($parentIds = $this->aggregateSimple($object)) {
                foreach($parentIds as $parentId) {
                    //only this field should be changed
                    $object->setEntityPkValue($parentId);
                    $this->aggregateGrouped($object);
                }
            }
        }
    }

    /**
     * Aggregate simple product and returns array of parent grouped product ids if ones are presented
     *
     * @param Mage_Core_Model_Abstract $object
     * @param bool $checkProductType
     * 
     * @return array 
     */
    public function aggregateSimple($object, $checkProductType = false)
    {
        if (
            $checkProductType && 
            $this->getProductType($object->getEntityPkValue()) === Mage_Catalog_Model_Product_Type::TYPE_GROUPED
        ) {
            return;
        } 
        
        $readAdapter    = $this->_getReadAdapter();
        $writeAdapter   = $this->_getWriteAdapter();

        $ratingModel    = Mage::getModel('rating/rating');
        $ratingSummaries= $ratingModel->getEntitySummary($object->getEntityPkValue(), false);

        foreach ($ratingSummaries as $ratingSummaryObject) {
            if ($ratingSummaryObject->getCount()) {
                $ratingSummary = round($ratingSummaryObject->getSum() / $ratingSummaryObject->getCount());
            } else {
                $ratingSummary = $ratingSummaryObject->getSum();
            }

            $reviewsCount = $this->getTotalReviews(
                $object->getEntityPkValue(),
                true,
                $ratingSummaryObject->getStoreId()
            );
            $select = $readAdapter->select()
                ->from($this->_aggregateTable)
                ->where('entity_pk_value = :pk_value')
                ->where('entity_type = :entity_type')
                ->where('store_id = :store_id');
            $bind = array(
                ':pk_value'    => $object->getEntityPkValue(),
                ':entity_type' => $object->getEntityId(),
                ':store_id'    =>$ratingSummaryObject->getStoreId()
            );
            $oldData = $readAdapter->fetchRow($select, $bind);

            $data = new Varien_Object();

            $data->setReviewsCount($reviewsCount)
                ->setEntityPkValue($object->getEntityPkValue())
                ->setEntityType($object->getEntityId())
                ->setRatingSummary(($ratingSummary > 0) ? $ratingSummary : 0)
                ->setStoreId($ratingSummaryObject->getStoreId());

            $writeAdapter->beginTransaction();
            try {
                if ($oldData['primary_id'] > 0) {
                    $condition = array("{$this->_aggregateTable}.primary_id = ?" => $oldData['primary_id']);
                    $writeAdapter->update($this->_aggregateTable, $data->getData(), $condition);
                } else {
                    $writeAdapter->insert($this->_aggregateTable, $data->getData());
                }
                $writeAdapter->commit();
            } catch (Exception $e) {
                $writeAdapter->rollBack();
            }
        }

        return Mage::getSingleton('catalog/product_type_grouped')
            ->getParentIdsByChild($object->getEntityPkValue());
    }

    /**
     * Aggregate grouped product
     *
     * @param Mage_Core_Model_Abstract $object
     * @param bool $checkProductType
     * 
     * @return int grouped product id
     */
    public function aggregateGrouped($object, $checkProductType = false)
    {
        if (
            $checkProductType && 
            $this->getProductType($object->getEntityPkValue()) !== Mage_Catalog_Model_Product_Type::TYPE_GROUPED
        ) {
            return;
        }
        
        $readAdapter    = $this->_getReadAdapter();
        $writeAdapter   = $this->_getWriteAdapter();

        $ratingModel    = Mage::getModel('rating/rating');
        $ratingSummaries= $ratingModel->getEntitySummary($object->getEntityPkValue(), false);

        foreach ($ratingSummaries as $ratingSummaryObject) {
            if ($ratingSummaryObject->getCount()) {
                $ratingSummary = round($ratingSummaryObject->getSum() / $ratingSummaryObject->getCount());
            } else {
                $ratingSummary = $ratingSummaryObject->getSum();
            }

            $reviewsCount = $this->getTotalReviews(
                $object->getEntityPkValue(),
                true,
                $ratingSummaryObject->getStoreId()
            );
            $select = $readAdapter->select()
                ->from($this->_aggregateTable)
                ->where('entity_pk_value = :pk_value')
                ->where('entity_type = :entity_type')
                ->where('store_id = :store_id');
            $bind = array(
                ':pk_value'    => $object->getEntityPkValue(),
                ':entity_type' => $object->getEntityId(),
                ':store_id'    =>$ratingSummaryObject->getStoreId()
            );
            $oldData = $readAdapter->fetchRow($select, $bind);

            $product = Mage::getModel('catalog/product')->load($object->getEntityPkValue());
            $associatedProducts = $product->getTypeInstance()->getAssociatedProducts($product);
            foreach ($associatedProducts as $associatedProduct) {
                $associatedProductSummaryData = Mage::getModel('review/review_summary')
                    ->setStoreId($ratingSummaryObject->getStoreId())
                    ->load($associatedProduct->getId());
                if ($associatedProductSummaryData) {
                    $reviewsCount += $associatedProductSummaryData->getReviewsCount();
                    if ($ratingSummary == 0 || $associatedProductSummaryData->getRatingSummary() == 0) {
                        $ratingSummary = round($ratingSummary + $associatedProductSummaryData->getRatingSummary());
                    } else {
                        $ratingSummary = round(($ratingSummary +
                                $associatedProductSummaryData->getRatingSummary()) / 2);
                    }
                    $associatedProductSummaryData->clearInstance();
                }
                $associatedProduct->clearInstance();
            }
            $product->clearInstance();

            $data = new Varien_Object();

            $data->setReviewsCount($reviewsCount)
                ->setEntityPkValue($object->getEntityPkValue())
                ->setEntityType($object->getEntityId())
                ->setRatingSummary(($ratingSummary > 0) ? $ratingSummary : 0)
                ->setStoreId($ratingSummaryObject->getStoreId());

            $writeAdapter->beginTransaction();
            try {
                if ($oldData['primary_id'] > 0) {
                    $condition = array("{$this->_aggregateTable}.primary_id = ?" => $oldData['primary_id']);
                    $writeAdapter->update($this->_aggregateTable, $data->getData(), $condition);
                } else {
                    $writeAdapter->insert($this->_aggregateTable, $data->getData());
                }
                $writeAdapter->commit();
            } catch (Exception $e) {
                $writeAdapter->rollBack();
            }
        }
        
        return $object->getEntityPkValue();
    }
    
}
