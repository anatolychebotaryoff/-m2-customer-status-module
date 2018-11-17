<?php

class USWF_GroupedCartName_Block_Bundle_Cart_Item_Renderer extends Mage_Bundle_Block_Checkout_Cart_Item_Renderer {

    public function getProductName()
    {
        if ($this->getItem()->getData('nfs_item')) {
            return $this->getItem()->getData('name');
        }

        if ($this->hasProductName()) {
            return $this->getData('product_name');
        }

        return $this->getProduct()->getName();
    }

    public function getProductUrl()
    {
        //Return the Group Page URL if exists
        $infoBuyRequest = $this->getItem()->getOptionByCode('info_buyRequest');
        $buyRequest = new Varien_Object(unserialize($infoBuyRequest->getValue()));
        $nfsUrl = $buyRequest->getData('grouped-product-url');
        $parentId = $this->getItem()->getData('grouped_product_id');
        if ($nfsUrl) {
            return $nfsUrl;
        } else if ($parentId) {
            $parent = Mage::getModel('catalog/product')->load($parentId);
            return $parent->getProductUrl();
        }

        if (!is_null($this->_productUrl)) {
            return $this->_productUrl;
        }


        if ($this->getItem()->getRedirectUrl()) {
            return $this->getItem()->getRedirectUrl();
        }

        $product = $this->getProduct();
        $option  = $this->getItem()->getOptionByCode('product_type');
        if ($option) {
            $product = $option->getProduct();
        }

        return $product->getUrlModel()->getUrl($product);
    }

}
