<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Replacementbrand
 * @copyright
 * @author
 */
class USWF_Replacementbrand_Helper_Data extends Mage_Catalog_Helper_Data
{
    const NEW_PRODUCT_SLIDER_CONF_PATH = 'uswf_replacementbrand/catalog_product_new/enabled';
    
    /**
     * Returns if new product slider is enabled
     * @return bool
     */
    public function isNewProductSliderEnabled() {
        return Mage::getStoreConfig(self::NEW_PRODUCT_SLIDER_CONF_PATH);
    }
}