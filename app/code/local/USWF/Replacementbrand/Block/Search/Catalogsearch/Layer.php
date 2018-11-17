<?php
/**
 * View.php
 *
 * @category    USWF
 * @package     USWF_Replacementbrand
 * @copyright
 * @author
 */
class USWF_Replacementbrand_Block_Search_Catalogsearch_Layer extends Enterprise_Search_Block_Catalogsearch_Layer
{
    const MANUFACTURER_ATTR_CODE = 'manufacturer';
    const RB_STORE_CODE = 'rb_en';

    /**
     * Get all layer filters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = parent::getFilters();
        //We should hardcode this just because there is no per store attribute configuration 
        //(such params as visibility in layered navigation and so on...)
        foreach ($filters as $key => $filter) {
            if (
                $filter->getAttributeModel() &&
                $filter->getAttributeModel()->getAttributeCode() == self::MANUFACTURER_ATTR_CODE
            ) {
                if (Mage::app()->getStore()->getCode() == self::RB_STORE_CODE) {
                    $chunk = array_splice($filters, $key, 1);
                    array_splice($filters, 2, 0, $chunk);
                } else {
                    unset($filters[$key]);
                }
                break;
            }
        }
        return $filters;
    }
}