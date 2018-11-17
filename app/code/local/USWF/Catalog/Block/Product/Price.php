<?php

/**
 * Product price block
 *
 * @category   USWF
 * @package    USWF_Catalog
 */
class USWF_Catalog_Block_Product_Price extends Mage_Catalog_Block_Product_Price
{

    /**
     * Get tier prices (formatted)
     *
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    public function getTierPrices($product = null)
    {
        if (is_null($product)) {
            $product = $this->getProduct();
        }
        $prices = $product->getFormatedTierPrice();
        $res = array();
        if (is_array($prices)) {
            foreach ($prices as $price) {
                $price['price_qty'] = $price['price_qty'] * 1;

                $productPrice = $product->getPrice();
                if ($product->getPrice() != $product->getFinalPrice()) {
                    $productPrice = $product->getFinalPrice();
                }

                // Group price must be used for percent calculation if it is lower
                $groupPrice = $product->getGroupPrice();
                if ($productPrice > $groupPrice && $groupPrice>0) {
                    $productPrice = $groupPrice;
                }
                if ((float)$price['price'] < (float)$productPrice && array_key_exists('isfixed', $price) && (int)$price['isfixed']) {
                    $price['savePercent'] = ceil(100 - ((100 / $productPrice) * $price['price']));

                    $tierPrice = Mage::app()->getStore()->convertPrice(
                        Mage::helper('tax')->getPrice($product, $price['website_price'])
                    );
                    $price['formated_price'] = Mage::app()->getStore()->formatPrice($tierPrice);
                    $price['formated_price_incl_tax'] = Mage::app()->getStore()->formatPrice(
                        Mage::app()->getStore()->convertPrice(
                            Mage::helper('tax')->getPrice($product, $price['website_price'], true)
                        )
                    );

                    if (Mage::helper('catalog')->canApplyMsrp($product)) {
                        $oldPrice = $product->getFinalPrice();
                        $product->setPriceCalculation(false);
                        $product->setPrice($tierPrice);
                        $product->setFinalPrice($tierPrice);

                        $this->getLayout()->getBlock('product.info')->getPriceHtml($product);
                        $product->setPriceCalculation(true);

                        $price['real_price_html'] = $product->getRealPriceHtml();
                        $product->setFinalPrice($oldPrice);
                    }

                    $res[] = $price;
                } elseif (!array_key_exists('isfixed', $price) || !(int)$price['isfixed']) {
                    if (!$price['price_is_fixed']) {
                        $price['formated_price'] = Mage::app()->getStore()->convertPricePercent(
                            $product->getFinalPrice(), $price['website_price']
                        );
                    }
                    $price['savePercent'] = (float)$price['price'];
                    $res[] = $price;
                }
            }
        }
        return $res;
    }
}
