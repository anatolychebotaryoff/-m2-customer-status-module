<?php
/**
 * Price.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Model_Product_Type_Price extends Mage_Catalog_Model_Product_Type_Price
{
    /**
     * Get minimal price for simple product
     *
     * @param Mage_Catalog_Model_Product $product
     * @param float|null $qty
     *
     * @return float
     */
    public function getMinPrice($product)
    {
        $price = (float)$product->getPrice();
        $groupPrice = $this->_applyGroupPrice($product, $price);
        list($tierPrice, $tierQty) = $this->getMinTierPrice($product, $price);
        $specialPrice = $this->_applySpecialPrice($product, $price);
        if ($tierPrice == 0 || $tierPrice > $price || $tierPrice > $groupPrice || $tierPrice > $specialPrice) {
            $prices = array_filter(array($price, $groupPrice, $specialPrice));
            return array(count($prices) ? min($prices) : 0, 1);
        } else {
            return array($tierPrice, $tierQty);
        }
    }

    /**
     * Get minimum tierprice for product (and qty)
     *
     * @param   Mage_Catalog_Model_Product $product
     * @param   float
     * @return  array($tierPrice, $tierQty)
     */
    public function getMinTierPrice($product, $price)
    {
        $allGroups = Mage_Customer_Model_Group::CUST_GROUP_ALL;
        $prices = $product->getData('tier_price');
        if (is_null($prices) || !is_array($prices)) {
            $attribute = $product->getResource()->getAttribute('tier_price');
            if ($attribute) {
                $attribute->getBackend()->afterLoad($product);
                $prices = $product->getData('tier_price');
            }
        }
        if (is_null($prices) || !is_array($prices)) {
            return array($price, 1);
        }
        $custGroup = $this->_getCustomerGroupId($product);
        $prevPrice = null;
        $prevQty = 0;
        foreach ($prices as $price) {
            if ($price['cust_group']!=$custGroup && $price['cust_group']!=$allGroups) {
                // tier not for current customer group nor is for all groups
                continue;
            }
            if ($price['website_price'] < $prevPrice || is_null($prevPrice)) {
                $prevPrice  = $price['website_price'];
                $prevQty = $price['price_qty'];
            }
        }
        return array(is_null($prevPrice) ? 0 : $prevPrice, $prevQty);
    }

    /**
     * Get tier price list including default qty and price
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  array
     */
    public function getPriceList($product)
    {
        $allGroups = Mage_Customer_Model_Group::CUST_GROUP_ALL;
        $prices = $product->getData('tier_price');
        if (is_null($prices) || !is_array($prices)) {
            $attribute = $product->getResource()->getAttribute('tier_price');
            if ($attribute) {
                $attribute->getBackend()->afterLoad($product);
                $prices = $product->getData('tier_price');
            }
        }

        $tierPrices = array();
        $defaultQty = ($stockItem = $product->getStockItem()) &&
            $stockItem->getMinSaleQty() && $stockItem->getMinSaleQty() > 0 ? $stockItem->getMinSaleQty() * 1 : 1;
        $tierPrices[$defaultQty] = $product->getPriceModel()->getFinalPrice($defaultQty, $product);

        if (is_null($prices) || !is_array($prices)) {
            return $tierPrices;
        }

        $custGroup = $this->_getCustomerGroupId($product);
        foreach ($prices as $price) {
            if ($price['cust_group']!=$custGroup && $price['cust_group']!=$allGroups) {
                // tier not for current customer group nor is for all groups
                continue;
            }
            $tierPrices[$price['price_qty'] * 1] = $price['website_price'];
        }

        return $tierPrices;
    }
}
