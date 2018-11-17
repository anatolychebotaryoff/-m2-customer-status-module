<?php

class USWF_Catalog_Block_Catalog_Product_Upsell_Item extends Lyonscg_Catalog_Block_Product_Upsell_Item {

    /**
     * Check hotdeal price is lower for all products
     *
     * @param $collection
     * @return bool
     */
    public function checkItemsPriceDiffer($collection) {
        $result = false;
        foreach ($collection as $_item){
            $priceDiffer = $this->_getPriceDiffer($_item);
            if ($priceDiffer <= 0) {
                $result = false;
            } else {
                $result = true;
            }
        }
        return $result;
    }

}