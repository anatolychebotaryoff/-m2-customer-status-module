<?php
/**
 *
 * @category    USWF
 * @package     USWF_Bundle
 * @copyright
 * @author
 */
class USWF_Bundle_Model_Core_Store extends Mage_Core_Model_Store
{
    /**
     * Convert price for percent type price
     * @param string $price
     * @param string $percent
     * @return type
     */
    public function convertPricePercent ($price, $percent) {
        
        $value = (float)$price*((100-(float)$percent)/100);
        
        return $this->formatPrice($value, true);
    }
}