<?php
/**
 * Grouped.php
 *
 * @category    USWF
 * @package     USWF_GroupedProductConfiguration
 * @copyright
 * @author
 */

class USWF_GroupedProductConfiguration_Model_Product_Type_Grouped 
    extends Itoris_GroupedProductConfiguration_Model_Product_Type_Grouped {

    public function isSalable($product = null) {
        $visibilityConfig =  $this->getDataHelper()->visibilityConfig($product);
        if (empty($visibilityConfig['mode'])) {
            $salable = Mage_Catalog_Model_Product_Type_Grouped::isSalable($product);
            if (!is_null($salable)) {
                return $salable;
            }
        } else {
            if ($this->getDataHelper()->getSettings()->getEnabled() && $this->getDataHelper()->isRegisteredAutonomous()
                && $visibilityConfig['mode'] != 'out_of_stock' && $visibilityConfig['mode'] !='custom_message' &&
                $visibilityConfig['mode'] !='show_price_disallow_add_to_cart'
            ) {
                $salable = false;
                foreach ($this->getAssociatedProducts($product) as $associatedProduct) {
                    $salable = $salable || $associatedProduct->isSalable();
                }
                return $salable;
            }
        }

        $this->setProduct($product);
        return Mage_Catalog_Model_Product_Type_Grouped::isSalable();
    }
}