<?php

class USWF_AutoCoupon_Model_System_Config_Backend_Autocoupon extends Mage_Core_Model_Config_Data
{
    protected function _beforeSave()
    {
        $value = $this->getValue();
        if ($value == USWF_AutoCoupon_Helper_Data::DEFAULT_NAME_COUPON_CODE) {
            Mage::throwException(Mage::helper('uswf_autocoupon')->__('Magento uses \'%s\' parameter Parameter. Select another parameter',USWF_AutoCoupon_Helper_Data::DEFAULT_NAME_COUPON_CODE));
        }
        $this->setValue(trim($value));
    }
}
