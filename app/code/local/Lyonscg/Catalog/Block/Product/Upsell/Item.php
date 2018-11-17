<?php

class Lyonscg_Catalog_Block_Product_Upsell_Item extends Mage_Catalog_Block_Product_Abstract
{

    const CONFIG_BANNER_IMG_MEDIA_POSTFIX = 'wysiwyg/Qubit/';

    public function getUpsellBlock($item)
    {
        $priceDiffer = $this->_getPriceDiffer($item);
        if ($priceDiffer <= 0) {
	    return;
	}
        $priceDiffer = Mage::helper('core')->currency($priceDiffer, true, false);
        $itemImage = $this->helper('catalog/image')->init($item, 'small_image')->resize(70);
        $itemName = $this->escapeHtml($item->getName());
        $_product = Mage::getModel('catalog/product')->load($item->getEntityId());
        $itemManufacturer = $_product->getManufacturerId();

        $currentProduct = $this->getProduct();
        if ($currentProduct->getTypeId() == 'grouped' ){
            $itemPrice = $this->_getLowestPrice($currentProduct);
        } else {
            $itemPrice = $currentProduct->getFinalPrice();
        }
        $itemPrice = Mage::helper('core')->currency($itemPrice, true, false);

        $banner_primary_text = Mage::getStoreConfig('lyonscg_catalog/upsell_banner_conf/banner_primary_text');
        $banner_secondary_text = Mage::getStoreConfig('lyonscg_catalog/upsell_banner_conf/banner_secondary_text');
        $banner_text_color = Mage::getStoreConfig('lyonscg_catalog/upsell_banner_conf/banner_text_color');
        $banner_fill_color = Mage::getStoreConfig('lyonscg_catalog/upsell_banner_conf/banner_fill_color');

        if (in_array($banner_fill_color, array('#fff', '#ffff', 'white')))
          $banner_border_color = $banner_text_color;
        else
          $banner_border_color = $banner_fill_color;

        $image_src = Mage::getBaseUrl('media') . self::CONFIG_BANNER_IMG_MEDIA_POSTFIX  .
           Mage::getStoreConfig('lyonscg_catalog/upsell_banner_conf/banner_image');


        $variables = array(
            'banner_primary_text' => sprintf($banner_primary_text, $itemPrice),
            'banner_secondary_text' =>  sprintf($banner_secondary_text, $priceDiffer),
            'banner_text_color' => $banner_text_color,
            'banner_fill_color' => $banner_fill_color,
            'banner_border_color' => $banner_border_color,
            'image_src' => $image_src,
            'price'         => $itemPrice,
            'price_differ'  => $priceDiffer,
            'item_image'    => $itemImage,
            'item_name'     => $itemName,
            'item_sku'      => $item->getSku(),
            'item_manufacturer_id' => $itemManufacturer
        );

        $block = Mage::getModel('cms/block')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load('upsell-block');
        $filter = Mage::getModel('cms/template_filter');
        $filter->setVariables($variables);

        return $filter->filter($block->getContent());
    }

    public function getFridgeUpsellBlock($item)
    {
        $priceDiffer = $this->_getPriceDiffer($item);
        if ($priceDiffer <= 0) {
	    return;
	}
        $priceDiffer = Mage::helper('core')->currency($priceDiffer, true, false);
        $itemImage = $this->helper('catalog/image')->init($item, 'small_image')->resize(70);
        $itemName = $this->escapeHtml($item->getName());
        $_product = Mage::getModel('catalog/product')->load($item->getEntityId());
        $itemManufacturer = $_product->getManufacturerId();

        $variables = array(
            'price_differ'  => $priceDiffer,
            'item_image'    => $itemImage,
            'item_name'     => $itemName,
            'item_price'    => number_format($item->getPrice(), 2, '.', ','),
            'item_sku'      => $item->getSku(),
            'item_manufacturer_id' => $itemManufacturer
        );

        $block = Mage::getModel('cms/block')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load('fridge_upsell_block');
        $filter = Mage::getModel('cms/template_filter');
        $filter->setVariables($variables);

        return $filter->filter($block->getContent());
    }

    protected function _getPriceDiffer($_item)
    {
        if ($_item->getTypeId() == 'grouped') {
            $_upsellItemPrice = $this->_getLowestPrice($_item);
        } else {
            $_upsellItemPrice = $_item->getFinalPrice();
        }

        $currentProduct = $this->getProduct();
        if ($currentProduct->getTypeId() == 'grouped' ){
            $_itemPrice = $this->_getLowestPrice($currentProduct);
        } else {
            $_itemPrice = Mage::registry('current_product')->getFinalPrice();
        }

        return $_itemPrice - $_upsellItemPrice;

    }

    protected function _getLowestPrice($_item)
    {
        $_associatedProducts = $_item->getTypeInstance(true)->getAssociatedProducts($_item);
        $_lowestPrice = 0;
        foreach ($_associatedProducts as $_item) {
            if ($_lowestPrice == 0) {
                if ($_item->getQty() > 1) {
                    $_lowestPrice = $_item->getFinalPrice() / $_item->getQty();
                } else {
                    $_lowestPrice = $_item->getFinalPrice();
                }
            } elseif ($_item->getQty() > 1) {
                $_itemPrice = $_item->getFinalPrice() / $_item->getQty();
                $_lowestPrice = ($_itemPrice < $_lowestPrice ? $_itemPrice : $_lowestPrice);
            } else {
                if ($_item->getTypeId() == 'bundle') {
                    $bundleOptionsCollection = $_item->getTypeInstance(true)->getSelectionsCollection(
                        $_item->getTypeInstance(true)->getOptionsIds($_item), $_item
                    );
                    $bundleOptionsCount = 0;
                    foreach ($bundleOptionsCollection as $option) {
                        $bundleOptionsCount += $option->getSelectionQty();
                    }
                    $_itemPrice = $_item->getFinalPrice() / $bundleOptionsCount;
                    $_lowestPrice = ($_itemPrice < $_lowestPrice ? $_itemPrice : $_lowestPrice);
                } else {
                    $_lowestPrice = ($_item->getFinalPrice() < $_lowestPrice ? $_item->getFinalPrice() : $_lowestPrice);
                }
            }
        }

        return $_lowestPrice;
    }
}
