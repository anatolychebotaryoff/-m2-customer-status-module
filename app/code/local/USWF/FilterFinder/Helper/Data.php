<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_FilterFinder
 * @copyright
 * @author
 */
class USWF_FilterFinder_Helper_Data extends Mage_Catalog_Helper_Data
{
    /**
     * Returns product listing variable for UV
     * @param Mage_Catalog_Model_Resource_Product_Collection $collection
     * @return array
     */
    public function getProductListing($collection) {
        $result = array(
            'result_count' => $collection->getSize(),
            'items' => array()
        );
        $uvObserver = Mage::getSingleton('uswf_universalvariable/page_observer');
        foreach($collection as $product) {
            $result['items'][] = $uvObserver->_getProductModel($product);
        }
        return $result;
    }
}