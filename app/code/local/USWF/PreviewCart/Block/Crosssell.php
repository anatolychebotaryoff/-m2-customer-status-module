<?php

class USWF_PreviewCart_Block_Crosssell extends Mage_Checkout_Block_Cart_Crosssell
{
    public function getCustomPriceHtml($product) {
        $block = $this->getChild('product_price_custom');
        if (isset($block)) {
            $block->setProduct($product);
            return $block->toHtml();
        }
    }

    /**
     * Check is has items
     *
     * @return bool
     */
    public function hasItems()
    {
        return $this->getItemCount() > 0;
    }

    /**
     * Get last product ID that was added to cart
     *
     * @return int
     */
    protected function _getLastAddedProductId()
    {
        return Mage::getSingleton('checkout/session')->getLastAddedProductId();
    }
}
