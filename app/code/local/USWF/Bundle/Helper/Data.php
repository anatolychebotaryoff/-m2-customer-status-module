<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Bundle
 * @copyright
 * @author
 */
class USWF_Bundle_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get percentage price
     * @param string $price
     * @param string $percent
     * @return float
     */
    public function getPercentagePrice($price,$percent) {
        $value = (float)$price*((100-(float)$percent)/100);
        return $value;
    }
}
