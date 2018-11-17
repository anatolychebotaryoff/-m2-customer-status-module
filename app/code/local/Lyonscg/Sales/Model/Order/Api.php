<?php
/**
 * Rewrite Mage_Sales_Model_Order_Api
 *
 * @category  Lyons
 * @package   Lyonscg_Sales
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_Sales_Model_Order_Api extends Mage_Sales_Model_Order_Api
{
    /**
     * Override to check for delivery_interval in product_options to set it as an individual field
     * Retrieve entity attributes values
     *
     * @param Mage_Core_Model_Abstract $object
     * @param $type
     * @param array $attributes
     * @return array|Mage_Sales_Model_Api_Resource
     */
    protected function _getAttributes($object, $type, array $attributes = null)
    {
        $result = array();

        if (!is_object($object)) {
            return $result;
        }

        foreach ($object->getData() as $attribute=>$value) {
            if ($this->_isAllowedAttribute($attribute, $type, $attributes)) {
                $result[$attribute] = $value;
                if ($type == 'order_item' && $attribute == 'product_options') {
                    $unserialized = unserialize($value);
                    if (isset($unserialized['info_buyRequest']['delivery-interval'])) {
                        $result['delivery_interval'] = $unserialized['info_buyRequest']['delivery-interval'];
                    }
                    if (isset($unserialized['additional_options'])) {
                        $options = $unserialized['additional_options'];
                        if (is_array($options)) {
                            foreach ($options as $option) {
                                if (isset($option['label']) && isset($option['value']) && ($option['label'] == 'Product Subscription Id')) {
                                    $result['subscription_id'] = $option['value'];
                                }
                            }
                        }
                    }
                } elseif ($type == 'order_item' && $attribute == 'additional_data') {
                    if ($additionalData = unserialize($value)) {
                        if (isset($additionalData[$object->getId()]) && $additionalData[$object->getId()] == 'hotdeal') {
                            $result['hotdeal'] = true;
                        }
                    }
                }
            }
        }

        if (isset($this->_attributesMap['global'])) {
            foreach ($this->_attributesMap['global'] as $alias=>$attributeCode) {
                $result[$alias] = $object->getData($attributeCode);
            }
        }

        if (isset($this->_attributesMap[$type])) {
            foreach ($this->_attributesMap[$type] as $alias=>$attributeCode) {
                $result[$alias] = $object->getData($attributeCode);
            }
        }

        // 387101 - add HasOffers variables to API
        $hoOrder = Mage::getModel('lyonscg_hasoffers/order')->load($object->getId(), 'order_id');
        if ($hoOrder->getId()) {
            $result['affiliate_id'] = $hoOrder->getAffiliateId();
            $result['offer_id'] = $hoOrder->getOfferId();
            $result['transaction_id'] = $hoOrder->getTransactionId();
        }
        else {
            $result['affiliate_id'] = '';
            $result['offer_id'] = '';
            $result['transaction_id'] = '';
        }

        return $result;
    }
}
