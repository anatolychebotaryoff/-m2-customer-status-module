<?php

class USWF_AdminCrmOrder_Helper_Data extends Mage_Catalog_Helper_Data {

    /**
     * Retrieve subscription product profile info from platform (eligible intervals, min & max qty, discount, etc)
     * Creates product on platform if it doesn't exist.
     *
     * @param Mage_Catalog_Model_Product $product Magento product object
     * @return SFC_Autoship_Model_Platform_Product Platform product data structure
     */
    public function getPlatformProduct(Mage_Catalog_Model_Product $product, $store)
    {
        /** @var SFC_Autoship_Helper_Api $apiHelper */
        $apiHelper = Mage::helper('autoship/api');


        // Lookup whether product enabled / disabled
        $isProductEnabled = Mage::helper('autoship/product')->isAvailableForSubscription($product, $store, true);
        if (!$isProductEnabled) {
            $platformProduct = Mage::getModel('autoship/platform_product');
            $platformProduct->setData('enabled', false);
            return $platformProduct;
        }

        // Do API query by SKU for product info
        $response = $apiHelper->fetchProducts(array('sku' => $product->getSku()));
        //print_r($response);die;
        // Check response
        if ($response['code'] != 200) {
            // API Error
            Mage::throwException('API error!');
        }
        // Check that we found product info
        $result = $response['result'];
        $platformProducts = $result['products'];
        if (!is_array($platformProducts) || count($platformProducts) != 1) {
            Mage::throwException('Product not found on Subscribe Pro platform!');
        }
        // Map platform product data to Mage model object
        $platformProductData = $platformProducts[0];
        $platformProduct = Mage::getModel('autoship/platform_product');
        $platformProduct->addData($platformProductData);
        // Force enabled = true
        // We are no longer honoring the is_subscription_enabled field from the platform
        $platformProduct->setData('enabled', true);

        // Return product
        return $platformProduct;
    }


    /**
     * Return list of allowed attributes
     *
     * @param Mage_Eav_Model_Entity_Abstract $entity
     * @param array $filter
     * @return array
     */
    public function getAllowedAttributes($entity, array $filter = null) {
        $attributes = $entity->getResource()
            ->loadAllAttributes($entity)
            ->getAttributesByCode();
        $result = array();
        foreach ($attributes as $attribute) {
            if ($this->_isAllowedCustomerAttribute($attribute, $filter)) {
                $result[$attribute->getAttributeCode()] = $attribute;
            }
        }

        return $result;
    }


    /**
     * Attributes map array per entity type
     *
     * @var array
     */
    protected $_attributesMap = array(
        'global' => array(),
    );

    protected $_ignoredAttributeCodes = array(
        'global'    =>  array('entity_id', 'attribute_set_id', 'entity_type_id')
    );


    protected function _isAllowedCustomerAttribute($attribute, array $filter = null) {
        if (!is_null($filter)
            && !( in_array($attribute->getAttributeCode(), $filter)
                || in_array($attribute->getAttributeId(), $filter))) {
            return false;
        }

        return !in_array($attribute->getFrontendInput(), $this->_ignoredAttributeTypes)
        && !in_array($attribute->getAttributeCode(), $this->_ignoredAttributeCodes);
    }


    /**
     * Check is attribute allowed to usage
     *
     * @param Mage_Eav_Model_Entity_Attribute_Abstract $attribute
     * @param string $type
     * @param array $attributes
     * @return bool
     */
    protected function _isAllowedOrderAttribute($attributeCode, $type, array $attributes = null) {
        if (!empty($attributes)
            && !(in_array($attributeCode, $attributes))) {
            return false;
        }

        if (in_array($attributeCode, $this->_ignoredAttributeCodes['global'])) {
            return false;
        }

        if (isset($this->_ignoredAttributeCodes[$type])
            && in_array($attributeCode, $this->_ignoredAttributeCodes[$type])) {
            return false;
        }

        return true;
    }


    protected function _getAttributes($object, $type, array $attributes = null) {
        $result = array();

        if (!is_object($object)) {
            return $result;
        }

        foreach ($object->getData() as $attribute=>$value) {
            if (is_object($value)) {
                continue;
            }

            if ($this->_isAllowedOrderAttribute($attribute, $type, $attributes)) {
                $result[$attribute] = $value;
            }
        }

        foreach ($this->_attributesMap['global'] as $alias=>$attributeCode) {
            $result[$alias] = $object->getData($attributeCode);
        }

        if (isset($this->_attributesMap[$type])) {
            foreach ($this->_attributesMap[$type] as $alias=>$attributeCode) {
                $result[$alias] = $object->getData($attributeCode);
            }
        }

        return $result;
    }


    public function getAddress($quote, $addressType) {
        if ($addressType == 'billing') {
            $address = $quote->getBillingAddress();
        }

        else {
            $address = $quote->getShippingAddress();
        }

        $addressObject = array(
            'company' => $address->getCompany(),
            'firstname' => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'street' => $address->getStreetFull(),
            'city' => $address->getCity(),
            'postcode' => $address->getPostcode(),
            'telephone' => $address->getTelephone(),
            'region_code' => $address->getRegionCode(),
            'region' => $address->getRegionName(),
            'region_id' => $address->getRegionId(),
            'same_as_billing' => (string)$address->getSameAsBilling(),
            'country_id' => $address->getCountryId(),
            'country' => $address->getCountry(),
        );

        return $addressObject;
    }


    public function quoteInfo($quote) {
        $store_id = $quote->getStoreId();
        $store = Mage::getSingleton('core/store')->load($store_id);

        //Reset the quote if an order exists
        $sales = Mage::getModel('sales/order')->getCollection()
                ->addAttributeToFilter('quote_id', array('eq' => $quote->getId()));

        if ($sales->getSize() > 0) {
            //The stand alone quote isnt really used here so just destroy it (active=false)
            $quote = Mage::getModel("sales/quote")->setStore($store)->setIsActive(false);
        }

        if ($quote->getGiftMessageId() > 0) {
            $quote->setGiftMessage(
                Mage::getSingleton('giftmessage/message')->load($quote->getGiftMessageId())->getMessage()
            );
        }

        $result = $this->_getAttributes($quote, 'quote');

        $billingAddress = $this->getAddress($quote, 'billing');
        $shippingAddress = $this->getAddress($quote, 'shipping');

        $result['billing_address'] = $billingAddress;
        $result['shipping_address'] = $shippingAddress;

        $result['items'] = array();

        foreach ($quote->getAllItems() as $item) {
            //Subscription Functionality
            $subscriptionEnabled = false;
            $subscriptionIntervals = array();
            if (Mage::getStoreConfig('autoship_general/general/enabled') == '1') {
		//This function removed from helper in order to use store
                $platformProduct = $this->getPlatformProduct($item->getProduct(), $store);
                $subscriptionEnabled = $platformProduct->getEnabled();
                if ($subscriptionEnabled) {
                    $subscriptionIntervals = $platformProduct->getIntervals();
                }

            }

            if ($item->getGiftMessageId() > 0) {
                $item->setGiftMessage(
                    Mage::getSingleton('giftmessage/message')->load($item->getGiftMessageId())->getMessage()
                );
            }

            $itemArray = $this->_getAttributes($item, 'quote_item');

            //Append subscription data to the quote
            $itemArray['subscription_enabled'] = $subscriptionEnabled;
            $itemArray['subscription_intervals'] = $subscriptionIntervals;

            $result['items'][] = $itemArray;
        }

        $result['payment'] = $this->_getAttributes($quote->getPayment(), 'quote_payment');
        $result['quote_id'] = $quote->getId();

        return $result;
    }


    public function updateProductInCart($quote, $quoteItem, $product, $deliveryOption, $deliveryInterval) {
        // Get platform helper
        /** @var SFC_Autoship_Helper_Platform $platformHelper */
        $platformHelper = Mage::helper('autoship/platform');
        /** @var SFC_Autoship_Helper_Product $productHelper */
        $productHelper = Mage::helper('autoship/product');

        // Get cart, quote and quote item
        /** @var Mage_Checkout_Model_Cart $cart */
        if ($quoteItem == null || !strlen($quoteItem->getId())) {
            Mage::throwException('Cant find quote item which was added!');
        }

        // Check if product is enabled
        if (!$productHelper->isAvailableForSubscription($product, $quote->getStore())) {
            return;
        }

        // Get subscription product profile
        $platformProduct = $platformHelper->getPlatformProduct($product);

        // Get new product qty from cart / quote
        $quoteQty = $quoteItem->getQty();

        // Apply default delivery option if none set
        if (!strlen($deliveryOption)) {
            if ($platformProduct->getData('default_subscription_option') == 'onetime_purchase') {
                $deliveryOption = 'one-time-delivery';
            }
            else {
                $deliveryOption = 'subscribe';
            }
        }

        // Implement trial subscription functionality
        if ($platformProduct->getData('is_trial_product')) {
            // Force subscription delivery option
            $deliveryOption = 'subscribe';
            // Set trial price on quote item
            $quoteItem->setCustomPrice($platformProduct->getData('trial_price'));
            $quoteItem->setOriginalCustomPrice($platformProduct->getData('trial_price'));
        }

        // Only do error messages if added product is set for subscription
        if ($deliveryOption == 'subscribe') {
            // Check qty to max sure we're in min - max range for subscription
            // Check the new quantity in the cart after addition
            if($quoteQty < $platformProduct->getData('min_qty')) {
                Mage::getSingleton('checkout/session')->addError('Item ' . $product->getSku() . ' requires minimum quantity of ' . $platformProduct->getData('min_qty') . ' for subscription.');
            }
            if($quoteQty > $platformProduct->getData('max_qty')) {
                Mage::getSingleton('checkout/session')->addError('Item ' . $product->getSku() . ' allows maximum quantity of ' . $platformProduct->getData('max_qty') . ' for subscription.');
            }
        }

        // Set data on quote item
        // Only set subscription option on quote item if we are in we meet all conditions
        if($quoteQty >= $platformProduct->getData('min_qty') && $quoteQty <= $platformProduct->getData('max_qty')) {
            $quoteItem->setData('create_new_subscription_at_checkout', ($deliveryOption == 'subscribe'));
        }
        else {
            $quoteItem->setData('create_new_subscription_at_checkout', false);
        }
        // Apply default interval if no interval set
        if (!strlen($deliveryInterval)) {
            $deliveryInterval = $platformProduct->getData('default_interval');
        }
        if (!strlen($deliveryInterval)) {
            // If no default interval, go for the 1st one in the list
            if (count($intervals = $platformProduct->getData('intervals'))) {
                $deliveryInterval = $intervals[0];
            }
        }
        // Set interval on quote item regardless
        $quoteItem->setData('new_subscription_interval', $deliveryInterval);
        // Save quote item
        $quoteItem->save();
    }
}
