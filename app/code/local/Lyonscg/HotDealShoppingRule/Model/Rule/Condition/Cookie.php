<?php
/**
 * Lyonscg_HotDealShoppingRule
 *
 * @category  Lyonscg
 * @package   Lyonscg_HotDealShoppingRule
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author    Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Cookie Condition Class
 *
 * @category Lyonscg
 * @package  Lyonscg_HotDealShoppingRule
 */
class Lyonscg_HotDealShoppingRule_Model_Rule_Condition_Cookie
    extends Mage_Rule_Model_Condition_Abstract
{
    /**
     * @var string
     */
    protected $_inputType = 'string';


    /**
     * Value element type getter
     *
     * @return string
     */
    public function getValueElementType()
    {
        return 'text';
    }

    /**
     * Get attribute element
     *
     * @return mixed
     */
    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    /**
     * Specify allowed comparison operators
     *
     * @return Enterprise_CustomerSegment_Model_Segment_Condition_Segment
     */
    public function loadOperatorOptions()
    {
        parent::loadOperatorOptions();
        $this->setOperatorOption(array(
            '=='  => Mage::helper('enterprise_customersegment')->__('is set'),
            '!='  => Mage::helper('enterprise_customersegment')->__('is not set'),
        ));
        return $this;
    }

    /**
     * Enable chooser selection button
     *
     * @return bool
     */
    public function getExplicitApply()
    {
        return true;
    }

    /**
     * Render element HTML
     *
     * @return string
     */
    public function asHtml()
    {
        $this->_valueElement = $this->getValueElement();
        return $this->getTypeElementHtml()
        . Mage::helper('lyonscg_hotdealshoppingrule')->__('If cookie with name %s %s',
            $this->_valueElement->getHtml(), $this->getOperatorElementHtml())
        . $this->getRemoveLinkHtml();
    }

    /**
     * Validate if defined cookie name is set or not
     *
     * @param   Varien_Object $object
     * @return  bool
     */
    public function validate(Varien_Object $object)
    {
        /**
         * Condition attribute value
         */
        $value = trim($this->getValue());

        $cookieSet = array_key_exists($value, $_COOKIE);

        /**
         * Comparison operator
         */
        $op = $this->getOperatorForValidate();

        if ($op == '==') {
            return $cookieSet;
        } elseif ($op == '!=') {
            if ($cookieSet) {
                $observer = Mage::getModel('lyonscg_couponmessaging/observer');
                $vars = $observer->getVars($object->getQuote()->getCouponCode());
                $msg = $observer->getCmsBlockToHtml($observer::COUPON_CODE_CUSTOMER_GROUP_NOT_MET);
                $result = $observer->convertVars($msg, $vars);
                if ($result) {
                    Mage::getSingleton('checkout/session')->addUniqueMessages(Mage::getSingleton('core/message')->error($result));
                }
            }
            return !$cookieSet;
        } else {
            return !$cookieSet;
        }

    }


}
