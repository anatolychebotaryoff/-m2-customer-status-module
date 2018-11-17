<?php

class USWF_AutoCoupon_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_AUTOCOUPON_ACTIVE = 'uswf_autocoupon/general/active';
    const XML_PATH_AUTOCOUPON_LINK_PARAM = 'uswf_autocoupon/general/link_param';
    const XML_PATH_AUTOCOUPON_REDIRECT_LINK = 'uswf_autocoupon/general/redirect_link';
    const DEFAULT_NAME_COUPON_CODE = 'coupon_code';

    /**
     * Check is module exists and enabled.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        if (!$this->isModuleEnabled() || !Mage::getStoreConfig(self::XML_PATH_AUTOCOUPON_ACTIVE)) {
            return false;
        }
        return true;
    }

    /**
     * Retrieve url.
     *
     * @return boolean
     */
    public function getRedirectUrl()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_AUTOCOUPON_REDIRECT_LINK));
    }

}