<?php

/**
 * Lyonscg Coupon Messaging
 *
 * Module detects when a coupon code has been disqualified from a quote.  Meaning, when cart contents nullify the
 * the sales rule.  This does NOT detect when user clicks on "Cancel Coupon".
 *
 * @category  Lyonscg
 * @package   Lyonscg_CouponMessaging
 * @copyright Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author    Tyler Hebel <thebel@lyonscg.com>
 * @author    Mark Hodge <mhodge@lyonscg.com>
 */
class Lyonscg_CouponMessaging_Model_Observer
{
    const COUPON_VALID_AND_APPLIED = 'coupon_valid_applied';
    const COUPON_DOES_NOT_EXIST = 'coupon_does_not_exist';
    const COUPON_OUTSIDE_DATE_RANGE = 'coupon_outside_date_range';
    const COUPON_CONDITION_NOT_MET = 'coupon_condition_not_met';
    const COUPON_REMOVED_WRONG_CONDITION = 'coupon_code_removed_condition_not_met';
    const COUPON_CODE_NOT_ACTIVE = 'coupon_code_not_active';
    const COUPON_CODE_CUSTOMER_GROUP_NOT_MET = 'coupon_code_customer_group_not_met';

    /**
     * @var string or bool
     */
    private $_couponCode;

    /**
     * @var array
     */
    protected $vars = array();

    /**
     * @var Mage_SalesRule_Model_Coupon
     */
    protected $coupon;

    /**
     * @var Mage_SalesRule_Model_Rule
     */
    protected $rule;

    // this only runs once (singleton)!
    public function __construct()
    {
        $this->_couponCode = false;
    }

    /**
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function salesQuoteCollectTotalsBefore(Varien_Event_Observer $observer)
    {
        // grab the coupon before quote is updated
        $_quote = $observer->getEvent()->getData('quote');

        // set code to the string itself or false
        $this->_couponCode = $_quote->getCouponCode() ? : false;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function salesQuoteCollectTotalsAfter($observer)
    {
        if (Mage::app()->getRequest()->getParam('remove') === '1') {
            return;
        }
        $_quote = $observer->getEvent()->getData('quote');

        $_couponCode = $_quote->getCouponCode() ? : false;

        // compare codes from before event (this is a singleton!)
        if (($_couponCode != $this->_couponCode) && ($this->checkCoupon($this->_couponCode))) {
            $controllerName = Mage::app()->getRequest()->getControllerName();
            $moduleName = Mage::app()->getRequest()->getModuleName();
            if (($moduleName === 'checkout' && $controllerName === 'cart') ||
                ($moduleName === 'onestepcheckout' && $controllerName === 'ajax'))
            {
                $vars = $this->getVars($this->_couponCode);
                $msg = $this->getCmsBlockToHtml(self::COUPON_REMOVED_WRONG_CONDITION);
                $result = $this->convertVars($msg, $vars);
                if ($result) {
                    Mage::getSingleton('customer/session')->setCouponRemovedWrongCondition(true);
                    $this->_getSession()->addUniqueMessages(Mage::getSingleton('core/message')->error($result));
                }
            }
        }
    }

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
        $error = true;
        //Default an error message in case none of the below conditions are met and there is an error
        $msg = $this->getCmsBlockToHtml(self::COUPON_REMOVED_WRONG_CONDITION);
        $session = $this->_getSession();
        $couponCode = (string)Mage::app()->getRequest()->getParam('coupon_code');
        $vars = $this->getVars($couponCode);
        $coupon = $this->coupon;
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
     * @param $cmsBlockId
     *
     * @return mixed
     */
    public function getCmsBlockToHtml($cmsBlockId)
    {
        return $this->renderWysiwygData(Mage::getModel('cms/block')->load($cmsBlockId)->getContent());
    }


    /**
     * transforms wysiwyg data to html
     *
     * @param $data
     * @return mixed
     */
    protected function renderWysiwygData($data)
    {
        /** @var Mage_Cms_Helper_Data $helper */
        $helper    = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();

        return $processor->filter($data);
    }

    /**
     * @param string $msg
     * @param array $vars
     *
     * @return mixed
     */
    public function convertVars($msg, $vars)
    {
        $pattern = '#{{code}}|{{rulelabel}}|{{to_date}}#';

        return preg_replace_callback(
            $pattern,
            function($matches) use ($vars) {
                $var = $matches[0];
                switch ($var) {
                    case '{{code}}':
                        return isset($vars['code']) ? $vars['code']  : '';
                    case '{{rulelabel}}':
                        return isset($vars['rulelabel']) ? $vars['rulelabel'] : '';
                    case '{{to_date}}':
                        return isset($vars['to_date']) ? $vars['to_date'] : '';
                }

                return '';
            },
            $msg
        );
    }

    /**
     * @param $couponCode
     * @return array
     */
    public function getVars($couponCode)
    {
        if ($this->coupon === null) {
            $this->vars = array();
            $this->vars['code'] = $couponCode;
            $this->coupon = Mage::getModel('salesrule/coupon')->loadByCode($couponCode);
            $this->rule = Mage::getModel('salesrule/rule')->load($this->coupon->getRuleId());
            $_toc = $this->rule->getTermsAndConditions();
            if (!empty($_toc))
            {
                $this->vars['rulelabel'] = $_toc;
            }
            else
            {
                $this->vars['rulelabel'] = $this->rule->getDescription();
            }
            $expirationDate = $this->coupon->getExpirationDate();
            if ($expirationDate) {
                $toDate = Mage::app()->getLocale()->date();
                $toDate->set($expirationDate, 'y-M-d');
                $this->vars['to_date'] = $toDate->toString('MMM d, y');
            } else {
                $this->vars['to_date'] = '';
            }
        }
        return $this->vars;
    }

    /**
     * Check coupon code. If coupon exist then return true else false
     *
     * @param $couponCode
     *
     * @return bool $result
     */
    protected function checkCoupon($couponCode)
    {
        $coupon = Mage::getModel('salesrule/coupon')->load($couponCode, 'code');

        if (!$coupon->getId()) {
            return false;
        }

        if (!$this->isValidDate($coupon)) {
            return false;
        }

        if (!$this->isValidRule($coupon)) {
            return false;
        }

        return true;
    }

    /**
     * Check coupon date valid
     *
     * @param Mage_SalesRule_Model_Coupon $coupon
     *
     * @return bool
     */
    protected function isValidDate(Mage_SalesRule_Model_Coupon $coupon)
    {
        $date = strtotime(now('d-m-y'));
        $result = true;

        if ($couponExpDate = strtotime($coupon->getExpirationDate())) {

            if ($date > $couponExpDate) {
                $result = false;
            }
        }

        return $result;
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
            }
            return false;
        }

        $session = Mage::getSingleton('customer/session');
        $group_id = $session->getCustomerGroupId();

        if (!in_array($group_id, $rule->getCustomerGroupIds())) {
            $vars = $this->getVars($coupon->getCode());
            $msg = $this->getCmsBlockToHtml(self::COUPON_CODE_CUSTOMER_GROUP_NOT_MET);
            $result = $this->convertVars($msg, $vars);
            if ($result) {
                $this->_getSession()->addUniqueMessages(Mage::getSingleton('core/message')->error($result));
            }
            return false;
        }

        return true;
    }
}
