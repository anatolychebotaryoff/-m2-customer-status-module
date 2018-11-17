<?php

class USWF_AdminCrmOrder_Adminhtml_Csmenu_CsAddressController extends USWF_AdminCrmOrder_Adminhtml_Csmenu_CsCustomerController {


    protected function _addressInfo($address) {

        $result = array();

        foreach ($this->_mapAttributes as $attributeAlias => $attributeCode) {
            $result[$attributeAlias] = $address->getData($attributeCode);
        }

        foreach ($this->getAllowedAttributes($address) as $attributeCode => $attribute) {
            $result[$attributeCode] = $address->getData($attributeCode);
        }


        if ($customer = $address->getCustomer()) {
            $result['is_default_billing']  = $customer->getDefaultBilling() == $address->getId();
            $result['is_default_shipping'] = $customer->getDefaultShipping() == $address->getId();
        }

        return $result;
    }


    public function addressInfoAction() {
        $keys = array('address_id');
        $request = $this->getRequest->getPost();
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $request = $this->getRequest()->getPost();
        $addressId = $request['address_id'];

        $address = Mage::getModel('customer/address')
            ->load($addressId);

        if (!$address->getId()) {
            $this->_fault('not_exists');
        }

        $this->getResponse()->setBody(json_encode($this->_addressInfo($address)));
    }


    /**
    * Sample API Call
    * data = array(
    *  'firstname' => 'firstname',
    *  'lastname' => 'lastname',
    *  'telephone' => 'telephone',
    *  'postcode' => 'postcode',
    *  'is_default_billing' => true,
    *  'street' => array('street1', 'street2),
    *  'region' => 'MN',
    *  'country_id' => 'US'
    * )
    */
    public function createCustomerAddress() {
        $keys = array('customer_id', 'address_data');
        $request = $this->getRequest->getPost();
        $checkPassed = $this->_checkRequest($keys, $request);
        if (!$checkPassed) {
            return;
        }

        $addressData = $request['address_data'];
        $customerId = $addressData['customer_id'];
        $customer = Mage::getModel('customer/customer')
            ->load($customerId);

        if (!$customer->getId()) {
            $this->_fault('customer_not_exists');
        }

        $address = Mage::getModel('customer/address');
        foreach ($this->getAllowedAttributes($address) as $attributeCode=>$attribute) {
            if (isset($addressData[$attributeCode])) {
                $address->setData($attributeCode, $addressData[$attributeCode]);
            }
        }

        if (isset($addressData['is_default_billing'])) {
            $address->setIsDefaultBilling($addressData['is_default_billing']);
        }

        if (isset($addressData['is_default_shipping'])) {
            $address->setIsDefaultShipping($addressData['is_default_shipping']);
        }

        $address->setCustomerId($customer->getId());

        $valid = $address->validate();

        if (is_array($valid)) {
            $this->_fault('data_invalid', implode("\n", $valid));
        }

        try {
            $address->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
        }

        $this->getResponse()->setBody(json_encode($this->_addressInfo($address)));

    }
}