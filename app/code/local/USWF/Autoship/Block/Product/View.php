<?php

class USWF_Autoship_Block_Product_View extends SFC_Autoship_Block_Product_View
{
    /**
     * Return true if product has options
     * This was made for deleting disabled/enabled autoship
     * @return bool
     */
    public function hasOptions()
    {
       return Mage_Catalog_Block_Product_View::hasOptions();
    }
}