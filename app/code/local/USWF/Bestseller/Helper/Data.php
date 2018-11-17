<?php
class USWF_Bestseller_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getAssociatedProducts($product)
    {
        if ($product->isGrouped()) {
            return $product->getTypeInstance(true)
                ->getAssociatedProducts($product);
        }
    }

}