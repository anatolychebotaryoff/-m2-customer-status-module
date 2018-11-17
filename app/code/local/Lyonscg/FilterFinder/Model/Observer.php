<?php
/**
 * Lyonscg_FilterFinder
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author      Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Filterfinder Observer to save filterfinder data.
 *
 * @category Lyons
 * @package  Lyonscg_FilterFinder
 */
class Lyonscg_FilterFinder_Model_Observer
{

    /**
     * File name to capture error messages.
     *
     * @var type
     */
    public $filename = 'lyonscg_filterfinder_debug';

    /**
     * This method deletes the existing data for the given product and website id and
     * saves the data from the "New Filter Finder" Tab.
     * Logs error messages to a log file.
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function saveFilterFinderData(Varien_Event_Observer $observer)
    {
        // Get the Product Id
        $productId = $observer->getEvent()->getProduct()->getId();
        // Get the website id.
        $websiteId = Mage::app()->getRequest()->getParam('store');
        // Get the filter finder data.
        $filterfinderData = $this->_getRequest()->getParam('filterfinderData');
        //lyonscg enazarov start[340901] FilterFinder integration issue
        if (!$filterfinderData) {
            $filterfinderData = array();
        }
        //lyonscg enazarov end[340901]

        $uniqueKey = '';
        $filterFinderDataArray = array();

        try {
            // Get the collection for this product id, website id
            // and delete all the entries.
            $collection = Mage::getResourceModel('lyonscg_filterfinder/filterfinder_collection');
            $collection->addFieldToFilter('product_entity_id', $productId);
            $collection->addFieldToFilter('website_id', $websiteId);
            // Delete all the entries for the given product id and website id.
            // Loop through all the items and delete them one by one.
            foreach ($collection as $item) {
                $filterFinderRecord = Mage::getModel('lyonscg_filterfinder/filterfinder')
                        ->load($item->getFilterfinderId());
                $filterFinderRecord->delete();
                unset($filterFinderRecord);
            }
            unset($collection);

            // Save data in an array which eliminates the duplicate data.
            foreach ($filterfinderData as $key => $value) {
                // Skip row if found empty
                if ($value['filter_finder_brand'] && $value['filter_finder_brand']
                    && $value['filter_finder_brand'] && $value['filter_finder_brand']
                ) {
                    $uniqueKey = $value['filter_finder_brand'] . $value['filter_finder_style']
                            . $value['filter_finder_location'] . $value['filter_finder_removal'];
                    $filterFinderDataArray[$uniqueKey]['filter_finder_brand'] = $value['filter_finder_brand'];
                    $filterFinderDataArray[$uniqueKey]['filter_finder_style'] = $value['filter_finder_style'];
                    $filterFinderDataArray[$uniqueKey]['filter_finder_location'] = $value['filter_finder_location'];
                    $filterFinderDataArray[$uniqueKey]['filter_finder_removal'] = $value['filter_finder_removal'];
                    $filterFinderDataArray[$uniqueKey]['delete'] = $value['delete'];
                }
            }

            // Loop through the array with unique values and save it to the database.
            foreach ($filterFinderDataArray as $uniqValue) {
                $filterFinderRecord = Mage::getModel('lyonscg_filterfinder/filterfinder');
                // Make sure not to include any data row that is marked for delete.
                if (!$uniqValue["delete"]) {
                    $filterFinderRecord->setWebsiteId($websiteId)
                            ->setProductEntityId($productId)
                            ->setFilterFinderBrand($uniqValue['filter_finder_brand'])
                            ->setFilterFinderStyle($uniqValue['filter_finder_style'])
                            ->setFilterFinderLocation($uniqValue['filter_finder_location'])
                            ->setFilterFinderRemoval($uniqValue['filter_finder_removal'])
                            ->save();
                }
                unset($filterFinderRecord);
            }
        } catch (Exception $e) {
            $this->filename .= '_' . date("Y-m") . '.log';
            Mage::log('Error occured while deleting/saving filter finder data '
                    . '.  Here is the error message: ' . $e->getMessage()
                    . PHP_EOL . '.  Here is the stack trace for debugging: ' .
                    $e->getTraceAsString(), null, $this->filename);
        }
    }

    /**
     * Retrieve the product model
     *
     * @return Mage_Catalog_Model_Product $product
     */
    public function getProduct()
    {
        return Mage::registry('product');
    }

    /**
     * Shortcut to getRequest
     *
     * @return array
     */
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }

}
