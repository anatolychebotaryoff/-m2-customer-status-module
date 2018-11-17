<?php

class USWF_Catalog_Block_Product_View_Type_Grouped extends Mage_Catalog_Block_Product_View_Type_Grouped
{

    /**
     * Check is product available for sale
     *
     * @return bool
     */
    public function isSaleableGroup()
    {
        $product = $this->getProduct();
        $result = 0;
        if ($product->isSaleable()) {
            $associatedProducts = $this->getAssociatedProducts();
            foreach ($associatedProducts as $item) {
                if ($item->isSaleable()) {
                    $result++;
                }
            }
        }
        return $result;
    }

    /**
     * Retrieve is product available for sale
     *
     * @return array
     */
    public function getSaleableAssociatedProducts()
    {
        $associatedProducts = $this->getAssociatedProducts();
        foreach ($associatedProducts as $key => $item) {
            if (!$item->isSaleable()) {
                unset($associatedProducts[$key]);
            }
        }
        return $associatedProducts;
    }

}