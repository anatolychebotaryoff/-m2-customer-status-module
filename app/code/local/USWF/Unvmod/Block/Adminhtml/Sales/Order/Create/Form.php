<?php

class USWF_Unvmod_Block_Adminhtml_Sales_Order_Create_Form extends Mage_Adminhtml_Block_Sales_Order_Create_Form
{
    private $curCustomer = null;

    public function getStoreSelectorDisplay()
    {
        $storeId    = $this->getStoreId();
        $customerId = $this->getCustomerId();
        if (!is_null($customerId) &&
            ($this->getCustomerStoreId() != Mage_Core_Model_App::ADMIN_STORE_ID) &&
            Mage::getStoreConfigFlag('uswf_unvmod/general/active')) {
            return 'none';
        }
        if (!is_null($customerId) && !$storeId ) {
            return 'block';
        }
        return 'none';
    }

    public function getDataSelectorDisplay()
    {
        $storeId    = $this->getStoreId();
        $customerId = $this->getCustomerId();
        if (!is_null($customerId) &&
            Mage::getStoreConfigFlag('uswf_unvmod/general/active') &&
            ($this->getCustomerStoreId() != Mage_Core_Model_App::ADMIN_STORE_ID)) {
            return 'block';
        }
        if (!is_null($customerId) && $storeId) {
            return 'block';
        }
        return 'none';
    }

    public function getCustomerStoreId(){
        if (is_null($this->curCustomer)){
            $customerId = $this->getCustomerId();
            $this->curCustomer = Mage::getModel('customer/customer')
                ->load($customerId);
        }

        if (is_object($this->curCustomer)){
            if($this->curCustomer->getStoreId() == Mage_Core_Model_App::ADMIN_STORE_ID){
                return $this->curCustomer->getWebsiteId();
            }else {
                return $this->curCustomer->getStoreId();
            }
        } else {
            return null;
        }
    }

}