<?php

class Lyonscg_CachedCompare_Block_Product_Compare_Sidebar extends Mage_Catalog_Block_Product_Compare_Sidebar
{
    public function getProduct()
    {
        if (!$this->getData('product'))
        {
            if ($this->getProductId())
            {
                $_product = Mage::getModel('catalog/product')->load($this->getProductId());
            }
            else
            {
                $_product = parent::getProduct();
            }
            $this->setData('product', $_product);
        }
        return $this->getData('product');
    }

    public function getProductAddToCompareUrl()
    {
        $_product = $this->getProduct();
        if ($_product && $_product->getId())
        {
            return $this->getAddToCompareUrl($_product);
        }
        else
        {
            return '';
        }
    }
}