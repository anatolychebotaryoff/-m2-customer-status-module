<?php

class USWF_PreviewCart_Block_Upsell extends Enterprise_TargetRule_Block_Catalog_Product_List_Upsell
{
    /**
     * Retrieve current product instance (if actual and available)
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return Mage::registry('previewcart_product');
    }

    /**
     * Get related items
     *
     * @return array
     */
    public function getItems()
    {
        $config = Mage::getStoreConfig(USWF_PreviewCart_Helper_Data::XML_PATH_UPSELL_PRODUCT);
        $productSku = array_map('trim', explode(',',$config));
        if ($config && count($productSku)) {
            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('sku', array('in' => $productSku))
                ->getItems();
        } else {
            $collection = $this->getItemCollection();
        }
        return $collection;
    }

    public function getCustomPriceHtml($product) {
        $block = $this->getChild('product_price_custom');
        if (isset($block)) {
            $block->setProduct($product);
            return $block->toHtml();
        }
    }
}
