<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_HotdealGroupPricing
 * @copyright
 * @author
 */
class USWF_HotdealGroupPricing_Model_Observer extends Lyonscg_Hotdeal_Model_Observer
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

        $hdGroupId = $hdGroupId ? $hdGroupId : Mage::helper('uswf_hotdealgrouppricing')->getBotDeal(); 

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
            if (Mage::registry('hotdeal_group')) {
                Mage::unregister('hotdeal_group');
            }
            Mage::register('hotdeal_group', $hdGroupId);
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
        if (Mage::helper('uswf_hotdealgrouppricing')->isHotdeal($product)) {
            $product->setHotDeal(1);
            // Set registry value for pdp
            $hotDeal = Mage::registry('hotdeal');
            if (!isset($hotDeal)) {
                Mage::register('hotdeal', 1);
            }
        }
        return $this;
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
        if (Mage::helper('uswf_hotdealgrouppricing')->isHotdeal($product)) {
            $product->setHotDeal(1);
        }

        return $this;
    }

    /**
     * Apply hotdeal price rules for bot
     *
     * @param   Varien_Event_Observer $observer
     *
     * @return  Mage_CatalogRule_Model_Observer
     */
    public function controllerFrontInitBefore($observer){
        $cookie = Mage::getSingleton('core/cookie');
        $hdGroupId = $cookie->get('hd_groupid');
        $hdGroupId = $hdGroupId ? $hdGroupId : Mage::helper('uswf_hotdealgrouppricing')->getBotDeal();
        if (is_numeric($hdGroupId)){
            Mage::getSingleton('customer/session')->setCustomerGroupId($hdGroupId);
            if (Mage::registry('hotdeal')) {
                Mage::unregister('hotdeal');
            }
            Mage::register('hotdeal', $hdGroupId);
        }
        return $this;
    }

}
