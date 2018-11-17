<?php

class USWF_Catalog_Block_Product_Upsell_Item extends Lyonscg_Catalog_Block_Product_Upsell_Item {

    public function getUpsellBlock($item)
    {
        $priceDiffer = $this->_getPriceDiffer($item);
        if ($priceDiffer < 0) {
            return false;
        }
        $itemImage = $this->helper('catalog/image')->init($item, 'small_image')->resize(70);
        $itemName = $this->escapeHtml($item->getName());
        $_product = Mage::getModel('catalog/product')->load($item->getEntityId());
        $itemManufacturer = $_product->getManufacturerId();

        $variables = array(
            'price_differ'  => number_format($priceDiffer, 2),
            'item_image'    => $itemImage,
            'item_name'     => $itemName,
            'item_sku'      => $item->getSku(),
            'item_manufacturer_id' => $itemManufacturer,
            'product_link' => $item->getProductUrl()
        );

        $block = Mage::getModel('cms/block')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load('new-upsell-block');
        $filter = Mage::getModel('cms/template_filter');
        $filter->setVariables($variables);

        return $filter->filter($block->getContent());
    }

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
