<?php

class USWF_Bundle_Block_Adminhtml_Sales_Order_Create_Items_Grid extends
        Mage_Adminhtml_Block_Sales_Order_Create_Items_Grid 
{
    /**
     * Returns the HTML string for the tiered pricing
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @return string
     */
    public function getTierHtml($item)
    {
        $html = '';
        $productL = $item->getProduct()->load($item->getProduct()->getId());
        $prices = $productL->getTierPrice();
        $product_price = $productL->getFinalPrice();
        if ($prices) {
            foreach ($prices as $data) {
                if (isset($data['isfixed']) && !(int) $data['isfixed']) {
                    $qty    = $data['price_qty'] * 1;
                    $price = (float) $product_price * ((100 - (float) $data['price']) / 100);
                    $info[] = $this->helper('sales')->__('%s for %s', $qty, round($price,2));
                } else {
                    $qty    = $data['price_qty'] * 1;
                    $price  = $this->convertPrice($data['price']);
                    $info[] = $this->helper('sales')->__('%s for %s', $qty, $price);
                }
            }
            $html = implode('<br/>', $info);
        }
        return $html;
    }
}
