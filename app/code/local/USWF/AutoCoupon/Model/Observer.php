<?php

class USWF_AutoCoupon_Model_Observer
{
    protected $_helper;
    protected $_nameParam;

    /**
     * Class construct
     *
     * @param array $constructArguments
     */
    public function __construct(array $constructArguments)
    {
        $this->_helper = Mage::helper('uswf_autocoupon');
        $this->_nameParam = trim(Mage::getStoreConfig(USWF_AutoCoupon_Helper_Data::XML_PATH_AUTOCOUPON_LINK_PARAM));
    }

    public function controllerActionPredispatch(Varien_Event_Observer $observer)
    {
        if ($this->isEnabled()) {
            $params = array_change_key_case(Mage::app()->getRequest()->getParams(), CASE_LOWER);
            if ($this->_nameParam != '' && isset($params[$this->_nameParam]) && $this->_nameParam != USWF_AutoCoupon_Helper_Data::DEFAULT_NAME_COUPON_CODE) {
                $couponCode = $params[$this->_nameParam];
                if ($couponCode != '' && $this->_isCouponValid($couponCode)) {
                    if (Mage::helper('checkout/cart')->getItemsCount()) {
                        Mage::getSingleton('checkout/session')
                            ->getQuote()
                            ->setCouponCode($couponCode)
                            ->save();
                        Mage::getSingleton('core/session')->addSuccess(
                            $this->_helper->__('Coupon was automatically applied')
                        );
                        Mage::getSingleton('customer/session')->unsetData('coupon_code');
                    } else {
                        Mage::getSingleton('customer/session')->setCouponCode($couponCode);
                    }
                    if ($url = $this->_helper->getRedirectUrl()) {
                        $observer->getControllerAction()->getResponse()->setRedirect($url);
                    }
                }
            }
        }
    }

    public function checkoutCartAddProductComplete()
    {
        if ($this->isEnabled()) {
            $couponCode = Mage::getSingleton('customer/session')->getCouponCode();
            if (isset($couponCode) && ($this->_isCouponValid($couponCode)) && (Mage::helper('checkout/cart')->getItemsCount())) {
                Mage::getSingleton('core/session')->addSuccess(
                    $this->_helper->__('Coupon was automatically applied')
                );
                Mage::getSingleton('checkout/session')->getQuote()->setCouponCode($couponCode)->collectTotals()->save();
                Mage::getSingleton('customer/session')->unsetData('coupon_code');
            }
        }
    }

    protected function _isCouponValid($couponCode)
    {
        try {
            $coupon = Mage::getModel('salesrule/coupon')->loadByCode($couponCode);
            if (is_object($coupon)) {
                $rule = Mage::getModel('salesrule/rule')->load($coupon->getRuleId());
                if (is_object($rule)) {
                    if ($rule->getIsActive()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $ex) {
            Mage::logException($ex);
            return false;
        }
    }

    /**
     * Check is module exists and enabled.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        if (!$this->_helper->isEnabled()) {
            return false;
        }
        return true;
    }
}