<?php

class USWF_AdminCrmOrder_Adminhtml_Csmenu_CsCustomerController extends Mage_Adminhtml_Controller_Action {


    protected function _checkRequest($keys, $postData) {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $postData)) {
                $this->getResponse()->setBody(json_encode(array('error' => $key . ' is not set!')));
                return false;
            }

        }

        return true;
    }
    
    protected function _validateFormKey() {
        return true;
    }


    public function getCustomerOrdersAction() {
        $keys = array('customer_id');
        $request = $this->getRequest()->getPost();
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $customerId = $request['customer_id'];
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $orderData = $this->_getCustomerOrders($customer);
        $this->getResponse()->setBody(json_encode($orderData));

    }


    protected function _parseCustomerOrderCollection($collection) {
        $result = array();
        foreach ($collection as $order) {
            $data = array(
                'total' => $order->getGrandTotal(),
                'increment_id' => $order->getIncrementId(),
                'order_id' => $order->getId(),
                'status' => $order->getStatusLabel(),
                'created_at' => $order->getCreatedAt(),
                'shipping_address' => $order->getShippingAddress()->getData(),
                'tracking_data' => array()
            );

            $trackingNumbers = array();

            foreach ($order->getTracksCollection() as $track){
                $trackData = array(
                    'number' => $track->getNumber(),
                    'title' => $track->getTitle(),
                    'carrier' => $track->getCarrierCode(),
                );
                $data['tracking_data'][] = $trackData;
            };



            $result[] = $data;
        }
        return $result;
    }


    protected function _convertGuestToCustomer($order) {
        $helper = Mage::helper('uswf_admincrmorder');
        $orderInfo = $helper->quoteInfo($order);
        return $orderInfo;
    }

    public function checkEmailAction() {
        $keys = array('customer_id', 'store_id');
        $request = $this->getRequest()->getPost();
        $checkPassed = $this->_checkRequest($keys, $request);
        $email = $request['email'];
        $storeId = $request['store_id'];

        $exists = false;
        $customer = Mage::getModel('customer/customer')
            ->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToFilter('email', $email)
            ->addAttributeToFilter('website_id', $storeId)
            ->getFirstItem();
        if ($customer->getId()) {
            $exists = true;
        }

        $this->getResponse()->setBody(json_encode(array('email_exists' => $exists)));
    }


    protected function _getCustomerOrders($customer) {
        $result = array();
        $customerOrderCollection = Mage::getModel('sales/order')->getCollection()->addFieldToSelect('*');
        $customerOrderCollection->addFieldToFilter('customer_id', $customer->getId());
        $result = array_merge($result, $this->_parseCustomerOrderCollection($customerOrderCollection));

        //Do another search to see if the customer placed an order as a guest
        $guestCollection = Mage::getModel('sales/order')->getCollection()->addFieldToSelect('*');
        $guestCollection->addFieldToFilter('customer_email', $customer->getEmail())
            ->addFieldToFilter('customer_is_guest', '1');

        if ($guestCollection->getSize() > 0) {
            $result = array_merge($result, $this->_parseCustomerOrderCollection($guestCollection));
        }

        return $result;
    }
    

    protected function _customerInfo($customer, $attributes = null, $include_orders) {

        if (!is_null($attributes) && !is_array($attributes)) {
            $attributes = array($attributes);
        }

        $result = array();
        $helper = Mage::helper('uswf_admincrmorder');

        foreach ($this->_mapAttributes as $attributeAlias=>$attributeCode) {
            $result[$attributeAlias] = $customer->getData($attributeCode);
        }

        foreach ($helper->getAllowedCustomerAttributes($customer, $attributes) as $attributeCode=>$attribute) {
            $result[$attributeCode] = $customer->getData($attributeCode);
        }

        if ($include_orders) {
            $result['orders'] = $this->_getCustomerOrders($customer);
        }

        return $result;
    }


    public function customerInfoAction() {
        $keys = array('customer_id');
        $request = $this->getRequest()->getPost();
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $customerId = $request['customer_id'];
        $attributes = isset($request['attributes']) ? $request['attributes'] : null;
        $include_orders = isset($request['include_orders']) ? $request['include_orders'] : false;

        $customer = Mage::getModel('customer/customer')->load($customerId);

        $this->getResponse()->setBody(json_encode($this->_customerInfo($customer, $attributes, $include_orders)));

    }


    public function getCustomerGroupAction() {
        $groupCollection = Mage::getModel('customer/group')->getCollection();
        $result = array();
        foreach($groupCollection as $group) {
            $result[] = $group->getData();

        }

        $this->getResponse()->setBody(json_encode($result));
    }


    /**
     * data = array(
     *  'fistname' => 'firstname',
     *  'lastname' => 'lastname',
     *  'email' => 'email@email.com',
     *  'website_id' => 'website_id'
     * )
     */
    public function createCustomerAction() {
        $keys = array('store_id', 'email', 'firstname', 'lastname');
        $request = $this->getRequest()->getPost();
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }
        /*TODO: Check if customer already exists */
        try {
            $customer = Mage::getModel('customer/customer')
                ->setData($request)
                ->setStore( Mage::getModel( 'core/store' )->load( $request["store_id"]  ))
                ->save();

            if (!$customer->getId()) {
                $this->_fault('not_exists');
            }

            $this->getResponse()->setBody(json_encode( array( 'customer_id' => $customer->getId() )));

        } catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
        }
    }
}
