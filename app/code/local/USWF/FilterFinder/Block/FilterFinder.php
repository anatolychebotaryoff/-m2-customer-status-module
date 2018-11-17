<?php
/**
 * FilterFinder.php
 *
 * @category    USWF
 * @package     USWF_FilterFinder
 * @copyright
 * @author
 */
class USWF_FilterFinder_Block_FilterFinder extends Lyonscg_FilterFinder_Block_FilterFinder
{
    
    protected $preparedProductCollection = null;
    
    
    /**
     * Current function merges info from all possible options list
     * of the attribute with options that were taken from product collection
     *
     * @param array $optionsBad
     * @param array $options
     * @return array
     */
    public function buildOptions(array $optionsBad, array $options)
    {
        $optionsGood = array();
        foreach ($optionsBad as $idString) {
            $optionsIds = explode(',', $idString);
            foreach ($optionsIds as $optionId) {
                if (isset($options[$optionId])) {
                    $optionsGood[$optionId] = $options[$optionId];
                }
            }
        }
        asort($optionsGood);
        return $optionsGood;
    }

    /**
     * Prepares data for ajax response in dependency of current state
     *
     * @return array|string|void
     */
    public function toGetJson()
    {
        if ($this->currentStep == 4) {
            return false;
        } else {
            $forJson = array();
            $nextStepOptions = $this->prepareNextStepData();
            foreach ($nextStepOptions as $option) {
                $option['linkUrl'] = $this->getOptionUrl($option['label']);
                $forJson[] = $option;
            }
            return json_encode(array(
                'html' => $forJson
            ));
        }
    }

    /**
     * Function returns product collection with offset $currentPage
     *
     * @return mixed
     */
    public function prepareProductCollection($currentPage = 1)
    {
        if (is_null($this->preparedProductCollection)) {
            $currentPage = $this->getRequest()->getParam('page') ? intval($this->getRequest()->getParam('page')) : 1;
            $steps = $this->steps;

            // Get the Current Store ID
            $storeId = Mage::app()->getStore()->getId();
            // Create Model to extract attributes and products.
            $ffModel = Mage::getModel('lyonscg_filterfinder/filterfinder')
                ->getCollection();
            // Select only the product_entity_id field.
            $ffModel->addFieldToSelect('product_entity_id');
            // Set Distinct to true
            $ffModel->getSelect()->distinct(true);
            // Filter by correct store id.
            $ffModel->addFieldToFilter('website_id', $storeId);

            // Add the items from the selection of attributes.
            foreach ($steps as $key => $value) {
                if (is_null($value) || $value == '') {
                    break;
                }
                $attributeId = $this->getAttributeOptionId($key, $value);
                // filter out based on the value selected.
                $ffModel->addFieldToFilter($key, array('eq' => $attributeId));
            }

            // Create a product collection.
            $this->preparedProductCollection = Mage::getModel('catalog/product')->getCollection();
            // Select everything
            $this->preparedProductCollection->addAttributeToSelect('*');
            // Filter by Correct Store ID.
            $this->preparedProductCollection->setStoreId($storeId);
            // Add "as low as string" to the product.
            $this->preparedProductCollection->addMinimalPrice();

            $productIds = array();
            // Loop through the $ffModel to get all the product ids.
            foreach ($ffModel as $productId) {
                $productIds[] = $productId->getProductEntityId();
            }
            // set the filters with required product ids.
            $this->preparedProductCollection->addAttributeToFilter('entity_id', array('in' => $productIds));
            // Little Housekeeping
            unset($ffModel);
            // Set Page size
            $this->preparedProductCollection->setPageSize(20)->setCurPage($currentPage);
        }
        return $this->preparedProductCollection;
    }

}
