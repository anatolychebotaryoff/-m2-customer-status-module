<?php
/**
 *
 * @category    USWF
 * @package     USWF_Catalog
 * @copyright
 * @author
 */
class USWF_Catalog_Model_Product_Type_Price extends Mage_Catalog_Model_Product_Type_Price {
    /**
     * Get formated tier price
     * @param type $qty
     * @param type $product
     * @return type
     */
    public function getFormatedTierPrice($qty=null, $product) 
    {
        $price = $product->getTierPrice($qty);
        if (is_array($price)) {
            foreach ($price as $index => $value) {
                if (isset($value['isfixed']) && (int)$value['isfixed']) {
                    $price[$index]['formated_price'] = Mage::app()->getStore()->convertPrice(
                            $price[$index]['website_price'], true
                    );
                } else {
                    $price[$index]['formated_price'] = Mage::app()->getStore()->convertPricePercent(
                            $product->getFinalPrice(), $price[$index]['website_price']
                    );
                    $price[$index]['price_is_fixed'] = 1;
                }
            }
        }
        else {
            $price = Mage::app()->getStore()->formatPrice($price);
        }
        return $price;
    }
    
    /**
     * Get product tier price by qty
     *
     * @param   float $qty
     * @param   Mage_Catalog_Model_Product $product
     * @return  float
     */
    public function getTierPrice($qty = null, $product)
    {
        $allGroups = Mage_Customer_Model_Group::CUST_GROUP_ALL;
        $prices = $product->getData('tier_price');

        if (is_null($prices)) {
            $attribute = $product->getResource()->getAttribute('tier_price');
            if ($attribute) {
                $attribute->getBackend()->afterLoad($product);
                $prices = $product->getData('tier_price');
            }
        }

        if (is_null($prices) || !is_array($prices)) {
            if (!is_null($qty)) {
                return $product->getPrice();
            }
            return array(array(
                'price'         => $product->getPrice(),
                'website_price' => $product->getPrice(),
                'price_qty'     => 1,
                'cust_group'    => $allGroups,
            ));
        }

        $custGroup = $this->_getCustomerGroupId($product);
        if ($qty) {
            $prevQty = 1;
            $prevPrice = $product->getPrice();
            $prevGroup = $allGroups;

            $first_tier_price = array_values($prices);
            $first_tier_price = array_shift($first_tier_price);
            if (!isset($first_tier_price['isfixed'])) {
                $attr = $product->getResource()->getAttribute('tier_price');
                $attr->getBackend()->afterLoad($product);
                $prices = $product->getData('tier_price');
            }
            foreach ($prices as $price) {
                if ($price['cust_group']!=$custGroup && $price['cust_group']!=$allGroups) {
                    // tier not for current customer group nor is for all groups
                    continue;
                }
                if ($qty < $price['price_qty']) {
                    // tier is higher than product qty
                    continue;
                }
                if ($price['price_qty'] < $prevQty) {
                    // higher tier qty already found
                    continue;
                }
                if ($price['price_qty'] == $prevQty && $prevGroup != $allGroups && $price['cust_group'] == $allGroups) {
                    // found tier qty is same as current tier qty but current tier group is ALL_GROUPS
                    continue;
                }
                if ((int)$price["isfixed"]!=0) {
                    if ($price['website_price'] < $prevPrice) {
                            $prevPrice  = $price['website_price'];
                            $prevQty    = $price['price_qty'];
                            $prevGroup  = $price['cust_group'];
                    }
                } else {
                    $prod_price = (float) $product->getPrice();
                    $prod_group_price = (float) $product->getGroupPrice();
                    $special_price = 0;
                    
                    if ($prod_price > $prod_group_price && $prod_group_price!=0) {
                        $prod_price = $prod_group_price;
                    }

                    $_specialPriceFromDate = $product->getSpecialFromDate();
                    $now = new DateTime(now());
                    if ($_specialPriceFromDate != null) {
                        $specialPriceFromDate = new DateTime($_specialPriceFromDate);
                        if ($now > $specialPriceFromDate ) {
                            $_specialPriceToDate = $product->getSpecialToDate();
                            $specialPriceToDate = new DateTime($product->getSpecialToDate());
                            if ($_specialPriceToDate==null || $now < $specialPriceToDate) {
                                $attr_sp_price = $product->getResource()->getAttribute('special_price');
                                if ($attr_sp_price) {
                                    $attr_sp_price->getBackend()->afterLoad($product);
                                    $_special_price = $product->getData('special_price');
                                }
                                $special_price = (float) $_special_price * ((100 - (float) $price['website_price']) / 100);
                            }
                        }
                    }
                    if ($prod_price > $special_price && $special_price!=0) {
                        $prevPrice = $special_price;
                    } else {
                        $prevPrice = (float) $prod_price * ((100 - (float) $price['website_price']) / 100);
                    }
                    $prevQty    = $price['price_qty'];
                    $prevGroup  = $price['cust_group'];
                }
            }
            return $prevPrice;
        } else {
            $qtyCache = array();
            foreach ($prices as $i => $price) {
                if ($price['cust_group'] != $custGroup && $price['cust_group'] != $allGroups) {
                    unset($prices[$i]);
                } else if (isset($qtyCache[$price['price_qty']])) {
                    $j = $qtyCache[$price['price_qty']];
                    if ($prices[$j]['website_price'] < $price['website_price']) {
                        unset($prices[$j]);
                        $qtyCache[$price['price_qty']] = $i;
                    } else {
                        unset($prices[$i]);
                    }
                } else {
                    $qtyCache[$price['price_qty']] = $i;
                }
            }
        }

        return ($prices) ? $prices : array();
    }
} 
