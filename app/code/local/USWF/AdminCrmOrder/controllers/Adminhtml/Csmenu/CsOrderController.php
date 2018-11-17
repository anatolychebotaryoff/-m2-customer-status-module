<?php

require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml').DS.'Sales'.DS.'Order'.DS.'CreateController.php';

class USWF_AdminCrmOrder_Adminhtml_Csmenu_CsOrderController extends Mage_Adminhtml_Sales_Order_CreateController {

    /**
     * Default ignored attribute codes per entity type
     *
     * @var array
     */
    protected $_ignoredAttributeCodes = array(
        'global' => array('entity_id', 'attribute_set_id', 'entity_type_id')
    );


    protected function _validateFormKey() {
        return true;
    }


    protected function _checkRequest($keys, $postData) {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $postData)) {
                $this->getResponse()->setBody(json_encode(array('error' => $key . ' is not set!')));
                return false;
            }

        }

        return true;
    }


    protected function _getQuoteAddress($customer, $addressType) {
        if ($addressType == 'billing') {
            $address = $customer->getDefaultBillingAddress();
        }

        else {
            $address = $customer->getDefaultShippingAddress();
        }

        //This can happen if there is no default shipping address but there is a billing address
        if (!$address && $addressType == 'shipping' && $customer->getDefaultBillingAddress()) {
            $address = $customer->getDefaultBillingAddress();
        }

        //if there is no address then stop here
        if (!$address) {
            return false;
        }

        $addressObject = array(
            'company' => $address->getCompany(),
            'firstname' => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'street' => $address->getStreetFull(),
            'city' => $address->getCity(),
            'postcode' => $address->getPostcode(),
            'telephone' => $address->getTelephone(),
            'region_id' => $address->getRegionId(),
            'country_id' => $address->getCountryId(),
	        'customer_address_id' => $address->GetId(),
        );
        return $addressObject;
    }


    public function getKeyAction() {
        $formKey = Mage::getSingleton('admin/session')->getFormKey();
        $this->getResponse()->setBody(json_encode(array('form_key' => $formKey)));
    }


    public function editQuoteAddressAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('store_id', 'quote_id', 'address_data', 'address_type', 'same_as_billing');
        $checkPassed = $this->_checkRequest($keys, $request);
        $helper = Mage::helper('uswf_admincrmorder');
        $same_as_billing = $request['same_as_billing'];
        $quote_id = $request['quote_id'];
        $store_id = $request['store_id'];
        $addressData = $request['address_data'];
        $type = $request['address_type'];
        if (!$checkPassed) {
            return;
        }

        $store = Mage::getSingleton('core/store')->load($store_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);

        if ($type == 'billing') {
            $billingAddress = $this->_prepareQuoteAddress($addressData, $quote);
            $quote->setBillingAddress($billingAddress);
            $quote->setBillingAddressId($billingAddress->getId());

        }

        elseif ($type == 'shipping') {
            if ($same_as_billing == 'true') {
                $address = $quote->getBillingAddress();

                $addressObject = array(
                    'company' => $address->getCompany(),
                    'firstname' => $address->getFirstname(),
                    'lastname' => $address->getLastname(),
                    'street' => $address->getStreetFull(),
                    'city' => $address->getCity(),
                    'postcode' => $address->getPostcode(),
                    'telephone' => $address->getTelephone(),
                    'region_id' => $address->getRegionId(),
                    'country_id' => $address->getCountryId(),
		            'customer_address_id' => $address->getId(),
		            'same_as_billing' => "1",
                );

                $quote->setShippingAddress($this->_prepareQuoteAddress($addressObject, $quote));

            }
            else {
                $shippingAddress = $this->_prepareQuoteAddress($addressData, $quote);
		        $shippingAddress->setSameAsBilling(0);
		        $shippingAddress->setCustomerAddressId(null);
                $quote->setShippingAddress($shippingAddress);
                $quote->setShippingAddressId($shippingAddress->getId());
            }

        }


        else {
            $this->getResponse()->setBody(json_encode(array('type_error' => 'You passed an invalid address type')));
            return;
        }

        $quote->collectTotals()->save();
        $quoteInfo = $helper->quoteInfo($quote);
        $this->getResponse()->setBody(json_encode($quoteInfo));
    }


    protected function _prepareQuoteAddress($addressData, $quote) {
            $address = Mage::getModel("sales/quote_address");
            $address->setData($addressData);
            $address->setSaveInAddressBook(1);
            return $address;
    }


    public function getQuoteAction() {

        $request = $this->getRequest()->getPost();
        $keys = array('store_id', 'quote_id');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');

        $store_id = $request['store_id'];
        $quote_id = $request['quote_id'];
        $group_id = isset($request['customer_group_id']) ? $request['customer_group_id'] : null;

        $store = Mage::getSingleton('core/store')->load($store_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);

        if ($group_id) {
            $quote->setCustomerGroupId($group_id);
            $quote->collectTotals()->save();
        }

        $quoteInfo = $helper->quoteInfo($quote);
        $this->getResponse()->setBody(json_encode($quoteInfo));

    }


    public function startAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('store_id');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');

        $store_id = $request['store_id'];
        $store = Mage::getSingleton('core/store')->load($store_id);
        $billing_address = isset($request['billing_address']) ? $request['billing_address'] : null;
        $shipping_address = isset($request['shipping_address']) ? $request['shipping_address'] : null;

        if (isset($request['customer_id'])) {
            $customer = Mage::getModel('customer/customer')->load($request['customer_id']);
            $quote = Mage::getModel('sales/quote')->setStore($store)->loadByCustomer($customer);
        }

        else {
            $quote = Mage::getModel("sales/quote")->setStore($store)->setIsActive(true);
        }

        /* Not sure if this is needed */
        $quote->getBillingAddress();
        $quote->getShippingAddress()->setCollectShippingRates(true);

        if ($billing_address) {
            $quote->setBillingAddress($this->_prepareQuoteAddress($billing_address, $quote));
        }

        if ($shipping_address) {
            $quote->setShippingAddress($this->_prepareQuoteAddress($billing_address, $quote));

        }

        $quote->collectTotals()->save();
        $this->getResponse()->setBody(json_encode($helper->quoteInfo($quote)));
    }


    public function convertGuestOrderToCustomerAction() {
        $request = $this->getRequest()->getPost();
        $order_id = $request['order_id'];
        $store_id = $request['store_id'];

        $store = Mage::getSingleton('core/store')->load($store_id);
        $order = Mage::getModel('sales/order')->setStore($store)->load($order_id);

        $customer = Mage::getModel('customer/customer')
            ->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToFilter('email', $order->getData('customer_email'))
            ->addAttributeToFilter('website_id', $store_id)
            ->getFirstItem();

        if ($customer->getId()) {
            return $this->initiateCustomer($store_id, $customer->getId());
        }

        else {

            try {
                $customer = Mage::getModel('customer/customer')
                    ->setFirstname($order->getData('customer_firstname'))
                    ->setMiddlename($order->getData('customer_middlename'))
                    ->setLastname($order->getData('customer_lastname'))
                    ->setEmail($order->getData('customer_email'))
                    ->setStore($store)
                    ->save();

                if (!$customer->getId()) {
                    throw new Exception('$Customer ID was not found after a save');
                }

                return $this->initiateCustomer($store_id, $customer->getId());

            } catch (Mage_Core_Exception $e) {
                $this->getResponse()->setBody(json_encode(array($e->getCode() => $e->getMessage())));
                return;
            }
        }
    }


    public function selectCustomerAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('store_id', 'customer_id');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');

        $customer_id = $request['customer_id'];
        $store_id = $request['store_id'];
        $quote_id = isset($request['quote_id']) ? $request['quote_id'] : null;
        return $this->initiateCustomer($store_id, $customer_id);
    }


    protected function initiateCustomer($store_id, $customer_id) {
        $helper = Mage::helper('uswf_admincrmorder');
        $store = Mage::getSingleton('core/store')->load($store_id);
        $customer = Mage::getModel('customer/customer')->load($customer_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->loadByCustomer($customer);

        if (!$quote->getId()) {
            $quote->setCustomerId($customer->getId());
        }

        //Reset the quote if an order exists
        $salesCheck = Mage::getModel('sales/order')->getCollection()
            ->addAttributeToFilter('quote_id', array('eq' => $quote->getId()));

        if ($salesCheck->getSize() > 0) {
            Mage::log('Found Duplicate');
            $quote = Mage::getModel("sales/quote")
                ->setStore($store)
                ->setIsActive(true)
                ->setCustomerId($customer->getId());
        }
 //       if ($quote_id) {
   //         $old_quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);
    //        $quote->merge($old_quote);
    //    }

        $quote->getBillingAddress();
        $quote->getShippingAddress()->setCollectShippingRates(true);

        //This can return null
        $defaultBilling = $this->_getQuoteAddress($customer, 'billing');
        $defaultShipping = $this->_getQuoteAddress($customer, 'shipping');

        if ($defaultBilling) {
            $quote->setBillingAddress($this->_prepareQuoteAddress($defaultBilling, $quote));
        }

        if ($defaultShipping) {
            $quote->setShippingAddress($this->_prepareQuoteAddress($defaultShipping, $quote));

        }

        $quote->setCustomerEmail($customer->getEmail());


        if (!$quote->getReservedOrderId()) {
            $quote->setReservedOrderId();
        }

        $quote->collectTotals()->save();

        //This line associates the cart to the admin session which is required in order to view the quote as new order
        Mage::getSingleton('adminhtml/session_quote')->setStoreId($store->getId())->setQuoteId($quote->getId());

        $this->getResponse()->setBody(json_encode($helper->quoteInfo($quote)));
    }


    public function prepareQuoteAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('store_id', 'quote_id');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');

        $store_id = $request['store_id'];
        $quote_id = isset($request['quote_id']) ? $request['quote_id'] : null;

        $store = Mage::getSingleton('core/store')->load($store_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);

        if (!$quote->getReservedOrderId()) {
            $quote->setReservedOrderId();
        }

        Mage::getSingleton('adminhtml/session_quote')->setStoreId($store->getId())->setQuoteId($quote->getId());

        $this->getResponse()->setBody(json_encode($helper->quoteInfo($quote)));

    }


    protected function _setCustomPrice($quote, $quoteItem, $customPrice) {
        $quoteItem->setCustomPrice($customPrice);
        $quoteItem->setOriginalCustomPrice($customPrice);
        $quoteItem->getProduct()->setIsSuperMode(true);
        $quoteItem->setPrice($customPrice);

        //Set row total fixes ability to set custom price
        $quoteItem->setRowTotal($customPrice * $quoteItem->getQty());
        $quoteItem->save();
    }


    protected function _setQtyPrice($quoteItem, $qty, $customPrice) {
        $quoteItem->setQty($qty);

        //Only set a custom price if the price passed is not the price already stored
        if ($customPrice != $quoteItem->getPrice()) {
            $quoteItem->setCustomPrice($customPrice);
            $quoteItem->setOriginalCustomPrice($customPrice);
            $quoteItem->getProduct()->setIsSuperMode(true);
            $quoteItem->setPrice($customPrice);

            //Set row total fixes ability to set custom price
            $quoteItem->setRowTotal($customPrice * $qty);

        }

        //Is this really necessary to save the quote item
        $quoteItem->save();
    }

    public function setCustomPriceAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('quote_id', 'store_id', 'product_id', 'custom_price');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');

        $store_id = $request['store_id'];
        $quote_id = $request['quote_id'];
        $product_id = $request['product_id'];
        $custom_price = $request['custom_price'];
        $store = Mage::getSingleton('core/store')->load($store_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);
        $product = Mage::getModel('catalog/product')->setStoreId($store_id)->load($product_id);

        //This may cause issue if quote contains multiple instance of same product
        $quoteItem = $quote->getItemByProduct($product);

        $this->_setCustomPrice($quote, $quoteItem, $custom_price);
        $quote->collectTotals()->save();
        $this->getResponse()->setBody(json_encode($helper->quoteInfo($quote)));
    }


    public function setQtyPriceAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('quote_id', 'store_id', 'product_id', 'qty', 'custom_price', 'quote_item_id');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');

        $store_id = $request['store_id'];
        $quote_id = $request['quote_id'];
        $product_id = $request['product_id'];
        $quote_item_id = (int) $request['quote_item_id'];
        $custom_price = $request['custom_price'];
        //Fixme necessary?
        $delivery_interval = $request['delivery_interval'];
        $delivery_interval = str_replace('+', ' ', $delivery_interval);

        $delivery_option = $request['delivery_option'];
        $custom_price = $request['custom_price'];
        $qty = $request['qty'];
        $store = Mage::getSingleton('core/store')->load($store_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);
        $product = Mage::getModel('catalog/product')->setStoreId($store_id)->load($product_id);

        //This may cause issue if quote contains multiple instance of same product
        if ($product->getTypeId() == "bundle") {
           // $items = Mage::getModel('sales/quote_item')->getCollection()->setQuote($quote);
            $items = $quote->getAllVisibleItems();
            foreach($items as $item) {
                if ($item->getId() == $quote_item_id) {
                    $quoteItem = $item;
                }
            }
            //$quoteItem = $items->getItemById($quote_item_id);
        }

        else {
            //This may cause issue if quote contains multiple instance of same product=
            $quoteItem = $quote->getItemByProduct($product);
        }

        if ($delivery_option == "true") {
            $helper = Mage::helper('uswf_admincrmorder');
            $helper->updateProductInCart($quote, $quoteItem, $product, 'subscribe', $delivery_interval);
        }

        else {
            $quoteItem->setData('create_new_subscription_at_checkout', false);
            $quoteItem->setData('new_subscription_interval', null);

        }

        $this->_setQtyPrice($quoteItem, $qty, $custom_price);

        $quote->collectTotals()->save();
        $this->getResponse()->setBody(json_encode($helper->quoteInfo($quote)));
    }


    protected function _prepareBundleProduct($product, $product_id, $qty) {
        $bundled_items = array();
        $optionCollection = $product->getTypeInstance()->getOptionsCollection();
        $selectionCollection = $product->getTypeInstance()->getSelectionsCollection($product->getTypeInstance()->getOptionsIds());
        $options = $optionCollection->appendSelections($selectionCollection);
        foreach($options as $option) {
            $_selections = $option->getSelections();
            foreach($_selections as $selection) {
                $bundled_items[$option->getOptionId()] = $selection->getSelectionId();
            }
        }

        $requestData = array(
            'bundle_option' => $bundled_items,
            'qty' => $qty,
            'product' => $product_id,
            'related_product' => null,
        );

	    return $requestData;
    }


    public function addAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('quote_id', 'store_id', 'product_id', 'qty');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');
        $custom_price = isset($request['custom_price']) ? $request['custom_price'] : null;
        $store_id = (int) $request['store_id'];
        $quote_id = (int) $request['quote_id'];
        $qty = $request['qty'];
        $product_id = $request['product_id'];

        $store = Mage::getSingleton('core/store')->load($store_id);
        $product = Mage::getModel('catalog/product')->setStoreId($store_id)->load($product_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);

        if ($product->getTypeId() == "bundle") {
            $requestData = $this->_prepareBundleProduct($product, $product_id, $qty);

            //For some reason, this only works if the product is loaded again. I can see no reason why this works
            //Took almost 2 days to make this connection
            $bundled_product = Mage::getModel('catalog/product')->setStoreId($store_id)->load($product_id);
            $quote->addProduct($bundled_product, new Varien_Object($requestData));
        }

        else {
            $quote->addProduct($product, $qty);
        }

        if ($custom_price) {
            //This may cause issue if quote contains multiple instance of same product
            $quoteItem = $quote->getItemByProduct($product);
            $this->_setCustomPrice($quote, $quoteItem, $custom_price);
        }

        $quote->collectTotals()->save();

        $this->getResponse()->setBody(json_encode($helper->quoteInfo($quote)));
    }


    public function removeAction() {
        $request = $this->getRequest()->getPost();
        $keys = array('quote_id', 'store_id', 'quote_item_id');
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $helper = Mage::helper('uswf_admincrmorder');
        $store_id = $request['store_id'];
        $quote_id = $request['quote_id'];
        $quote_item_id = $request['quote_item_id'];

        $store = Mage::getSingleton('core/store')->load($store_id);
        $quote = Mage::getModel('sales/quote')->setStore($store)->load($quote_id);
        $quote->removeItem($quote_item_id);
        $quote->collectTotals()->save();

        $this->getResponse()->setBody(json_encode($helper->quoteInfo($quote)));
    }

}
