<?php

class USWF_PreviewCart_Model_System_Config_Backend_Chooser extends Mage_Core_Model_Config_Data
{

    /**
     * Check the product sku
     * @return USWF_PreviewCart_Model_System_Config_Backend_Chooser
     */    
    protected function _beforeSave()
    {
        $value = $this->getValue();		
        if ($value){
            $productSku = array_map('trim', explode(',',$value));
            foreach ($productSku as $sku) {
                if (!Mage::getModel('catalog/product')->getIdBySku($sku)) {
                    Mage::throwException("Product Sku '$sku' does not exist");
                }
            }
        }
        return $this;
    }
}