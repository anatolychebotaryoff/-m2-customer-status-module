<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_CouponMessaging
 * @copyright
 * @author
 */
class USWF_CouponMessaging_Model_Observer extends Lyonscg_CouponMessaging_Model_Observer
{
    /**
     * observes event:
     *              controller_action_postdispatch_checkout_cart_couponPost
     *
     * @param $observer Varien_Event_Observer
     */
    public function customizeMessages($observer)
    {    
        if (Mage::app()->getRequest()->getParam('remove') === '1') {
            return;
        }
        //Default an error message in case none of the below conditions are met and there is an error
        $msg = $this->getCmsBlockToHtml(self::COUPON_REMOVED_WRONG_CONDITION);
        $session = $this->_getSession();
        $couponCode = (string)Mage::app()->getRequest()->getParam('coupon_code');
        $vars = $this->getVars($couponCode);
        $coupon = $this->coupon;
        if ($this->checkHotDealLink() && $coupon->getId() && !$this->checkCouponInHotDealGroup()) {
            return;
        }
        if (
            Mage::getSingleton('customer/session')->getCouponCodeCustomerGroupNotMet() || 
            Mage::getSingleton('customer/session')->getCouponCodeNotActive()
        ) {
            Mage::getSingleton('customer/session')->unsCouponCodeCustomerGroupNotMet();
            Mage::getSingleton('customer/session')->unsCouponCodeNotActive();
            return $this;
        }
        $error = true;
        
        if (!count($session->getMessages()->getErrors()) && Mage::getSingleton('checkout/cart')->getQuote()->getCouponCode() === $couponCode) {
            $msg = $this->getCmsBlockToHtml(self::COUPON_VALID_AND_APPLIED);
            $error = false;
        } else {
            if (!$coupon->getId()) {
                $msg = $this->getCmsBlockToHtml(self::COUPON_DOES_NOT_EXIST);
            } else {
                $expirationDate = $coupon->getExpirationDate();
                if ($expirationDate && (strtotime($expirationDate) < strtotime(date('Y-m-d')))) {
                    $msg = $this->getCmsBlockToHtml(self::COUPON_OUTSIDE_DATE_RANGE);
                } else {
                    $couponRemovedShown = Mage::getSingleton('customer/session')->getCouponRemovedWrongCondition();
                    if (empty($couponRemovedShown)) {
                        $msg = $this->getCmsBlockToHtml(self::COUPON_CONDITION_NOT_MET);
                        if ($coupon->getRuleId()) {
                            $rule = Mage::getModel('salesrule/rule')->load($coupon->getRuleId());

                            $termsAndConditions = $rule->getTermsAndConditions();
                            if (!empty($termsAndConditions)) {
                                $msg .= '<br />' . Mage::helper('core')->stripTags($termsAndConditions);
                            }
                        }
                    } else {
                        Mage::getSingleton('customer/session')->unsCouponRemovedWrongCondition();
                    }
                }
            }
        }

        $result = $this->convertVars($msg, $vars);
        if ($result) {
            if ($error) {
                $session->addUniqueMessages(Mage::getSingleton('core/message')->error($result));
            } else {
                $session->addSuccess($result);
            }
        }
    }

    /**
     * Check rule valid
     *
     * @param Mage_SalesRule_Model_Coupon $coupon
     *
     * @return bool
     */
    protected function isValidRule(Mage_SalesRule_Model_Coupon $coupon){
        if (!$coupon->getRuleId()) {
            return false;
        }

        $rule = Mage::getModel('salesrule/rule')->load($coupon->getRuleId());

        if ($rule->getIsActive() != 1) {
            $vars = $this->getVars($coupon->getCode());
            $msg = $this->getCmsBlockToHtml(self::COUPON_CODE_NOT_ACTIVE);
            $result = $this->convertVars($msg, $vars);
            if ($result) {
                $this->_getSession()->addUniqueMessages(Mage::getSingleton('core/message')->error($result));
                Mage::getSingleton('customer/session')->setCouponCodeNotActive(true);
            }
            return false;
        }
        
        if ($this->checkHotDealLink()) {
            if (!$this->checkCouponInHotDealGroup()){
                return false;
            }
            return true;
        }
        
        $session = Mage::getSingleton('customer/session');
        $group_id = $session->getCustomerGroupId();
        
        if (!in_array($group_id, $rule->getCustomerGroupIds())) {
            $vars = $this->getVars($coupon->getCode());
            $msg = $this->getCmsBlockToHtml(self::COUPON_CODE_CUSTOMER_GROUP_NOT_MET);
            $result = $this->convertVars($msg, $vars);
            if ($result) {
                $this->_getSession()->addUniqueMessages(Mage::getSingleton('core/message')->error($result));
                Mage::getSingleton('customer/session')->setCouponCodeCustomerGroupNotMet(true);
            }
            return false;
        }

        return true;
    }
    /**
     * Check if hotdeal condition
     * 
     * @return boolean
     * 
     */
    protected function checkCouponInHotDealGroup() 
    {
        if (isset($_COOKIE['hd_groupid'])) {
            $couponCode = (string)Mage::app()->getRequest()->getParam('coupon_code');
            $vars = $this->getVars($couponCode);
            $coupon = $this->coupon;
            $rule = Mage::getModel('salesrule/rule')->load($coupon->getRuleId());
            $hod_deal_id = Mage::getModel('core/cookie')->get('hd_groupid');
            if (!in_array($hod_deal_id, $rule->getCustomerGroupIds())) {
                $vars = $this->getVars($coupon->getCode());
                $msg = $this->getCmsBlockToHtml(self::COUPON_CODE_CUSTOMER_GROUP_NOT_MET);
                $result = $this->convertVars($msg, $vars);
                if ($result) {
                    $this->_getSession()->addUniqueMessages(Mage::getSingleton('core/message')->error($result));
                }
                return false;
            } else {
                return true;
            }
        }
        return false;
    }
    
    /*
     * Check hotdeal link
     */
    protected function checkHotDealLink() 
    {
        if (isset($_COOKIE['hd_groupid'])) {
            return true;
        }
        return false;
    }
}
