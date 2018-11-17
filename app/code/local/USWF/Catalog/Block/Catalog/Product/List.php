<?php

class USWF_Catalog_Block_Catalog_Product_List extends Mage_Catalog_Block_Product_List {

    public function getCustomPriceHtml($product) {
        $block = $this->getChild('product_price_custom');
        if (isset($block)) {
            $block->setProduct($product);
            return $block->toHtml();
        }
    }

    public function getAssociatedProducts($product)
    {
        if ($product->isGrouped()) {
            return $product->getTypeInstance(true)
                ->getAssociatedProducts($product);
        }
    }

    /**
     * Retrieve is product available for sale
     *
     * @return array
     */
    public function getSaleableAssociatedProducts($product)
    {
        if ($product->isGrouped()) {
            $associatedProducts = $product->getTypeInstance(true)
                ->getAssociatedProducts($product);
            foreach ($associatedProducts as $key => $item) {
                if (!$item->isSaleable()) {
                    unset($associatedProducts[$key]);
                }
            }
            return $associatedProducts;
        }
    }
}
