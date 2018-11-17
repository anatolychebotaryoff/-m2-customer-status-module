<?php
/**
 * Overriding Catalog Price rules observer model
 * Adding functionality for Hot Deals: setting up customer group id depend on cookie
 *
 * @category   Lyons
 * @package    Lyonscg_HotDeal
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Valentin Ponomarenko <vponomarenko@lyonscg.com>
 */
class Lyonscg_Hotdeal_Model_Observer extends Mage_CatalogRule_Model_Observer
{
    /**
     * Apply catalog price rules to product on frontend
     *
     * @param   Varien_Event_Observer $observer
     *
     * @return  Mage_CatalogRule_Model_Observer
     */
    public function processFrontFinalPrice($observer)
    {
        $product    = $observer->getEvent()->getProduct();
        $pId        = $product->getId();
        $storeId    = $product->getStoreId();
        $cookie = Mage::getSingleton('core/cookie');
        $hdGroupId = $cookie->get('hd_groupid');

        if ($observer->hasDate()) {
            $date = $observer->getEvent()->getDate();
        } else {
            $date = Mage::app()->getLocale()->storeTimeStamp($storeId);
        }

        if ($observer->hasWebsiteId()) {
            $wId = $observer->getEvent()->getWebsiteId();
        } else {
            $wId = Mage::app()->getStore($storeId)->getWebsiteId();
        }

        if ($observer->hasCustomerGroupId()) {
            $gId = $observer->getEvent()->getCustomerGroupId();
        } elseif ($product->hasCustomerGroupId()) {
            $gId = $product->getCustomerGroupId();
        } else {
            $gId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }
        
        if ($hdGroupId) {
            $gId = $hdGroupId;
        }
        
        $key = "$date|$wId|$gId|$pId";
        if (!isset($this->_rulePrices[$key])) {
            $rulePrice = Mage::getResourceModel('catalogrule/rule')
                ->getRulePrice($date, $wId, $gId, $pId);
            $this->_rulePrices[$key] = $rulePrice;
        }
        if ($this->_rulePrices[$key]!==false) {
            $finalPrice = min($product->getData('final_price'), $this->_rulePrices[$key]);
            $product->setFinalPrice($finalPrice);

            // Set registry value for pdp
            $hotDeal = Mage::registry('hotdeal');
            if (!isset($hotDeal)) {
                Mage::register('hotdeal', 1);
            }
            // set product hot_deal variable for adding to additional_data
            $product->setHotDeal(1);
        }
        if ($product->getGroupPrice()) {
            $product->setHotDeal(1);
        }
        return $this;
    }

    public function ensureHotdealApplied ($observer) {

        $hdgroupId = Mage::getSingleton('core/cookie')->get('hd_groupid');

        $customer = Mage::getSingleton('customer/session')->setCustomerGroupId($hdgroupId);

    }


    /**
     * Check Customer Group Before for hd_groupid cookie set
     *
     * @param $observer
     */
    public function checkCustomerGroupBefore($observer)
    {
        $quote = $observer->getEvent()->getQuoteAddress()->getQuote();

        $hdGroupId = Mage::getSingleton('core/cookie')->get('hd_groupid');
        if (!empty($hdGroupId)) {
            Mage::getSingleton('customer/session')->setCustomerGroupIdOrig($quote->getCustomerGroupId());
            $quote->setCustomerGroupId($hdGroupId);
        }
    }

    /**
     * Check if the customer group has been changed before and set it back to the original value
     *
     * @param $observer
     */
    public function checkCustomerGroupAfter($observer)
    {
        $quote = $observer->getEvent()->getQuoteAddress()->getQuote();

        $originalCustomerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupIdOrig();
        if(!empty($originalCustomerGroupId) || $originalCustomerGroupId == Mage_Customer_Model_Group::NOT_LOGGED_IN_ID) {
            $quote->setCustomerGroupId($originalCustomerGroupId);
        }
    }

    /**
     *
     * Apply catalog price rules to product in admin
     *
     * @param   Varien_Event_Observer $observer
     *
     * @return  Mage_CatalogRule_Model_Observer
     */
    public function processAdminFinalPrice($observer)
    {
        $product = $observer->getEvent()->getProduct();
        $storeId = $product->getStoreId();
        $date = Mage::app()->getLocale()->storeDate($storeId);
        $key = false;

        if ($ruleData = Mage::registry('rule_data')) {
            $wId = $ruleData->getWebsiteId();
            $gId = $ruleData->getCustomerGroupId();
            $pId = $product->getId();

            $key = "$date|$wId|$gId|$pId";
        }
        elseif (!is_null($product->getWebsiteId()) && !is_null($product->getCustomerGroupId())) {
            $wId = $product->getWebsiteId();
            $gId = $product->getCustomerGroupId();
            $pId = $product->getId();
            $key = "$date|$wId|$gId|$pId";
        }

        if ($key) {
            if (!isset($this->_rulePrices[$key])) {
                $rulePrice = Mage::getResourceModel('catalogrule/rule')
                    ->getRulePrice($date, $wId, $gId, $pId);
                $this->_rulePrices[$key] = $rulePrice;
            }
            if ($this->_rulePrices[$key]!==false) {
                $finalPrice = min($product->getData('final_price'), $this->_rulePrices[$key]);
                $product->setFinalPrice($finalPrice);

                $product->setHotDeal(1);
            }
        }
        if ($product->getGroupPrice()) {
            $product->setHotDeal(1);
        }

        return $this;
    }

}
