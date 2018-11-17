<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_HotdealGroupPricing
 * @copyright
 * @author
 */
class USWF_HotdealGroupPricing_Helper_Data extends Mage_Catalog_Helper_Data
{
    const HOT_DEALS_GROUP_PRICE_PATTERN = '#^Hot Deals(.*)$#i';
    
    protected $hotdealProductCache = array();
    const CATALOG_PRODUCT_TYPE_SIMPLE = 'simple';
    const CATALOG_PRODUCT_TYPE_BUNDLE = 'bundle';
    /**
     * Check if product is hot deal
     * @param $product Mage_Catalog_Model_Product
     * @return bool
     */
    public function isHotdeal($product) {
        if (!isset($this->hotdealProductCache[$product->getId()])) {
            if (
                ($group = $this->getPriceGroup($product)) &&
                ($groupName = Mage::getModel('customer/group')->load($group)->getCustomerGroupCode())
            ) {
                $this->hotdealProductCache[$product->getId()] = true;
            } else {
                $this->hotdealProductCache[$product->getId()] = false;
            }
        }
        return $this->hotdealProductCache[$product->getId()];
    }

    /**
     * Returns price group, if group price is applied 
     * @param $product Mage_Catalog_Model_Product
     * @return mixed
     */
    protected function getPriceGroup($product) {
        $groupPrices = $product->getData('group_price');
        if (is_null($groupPrices)) {
            return false;
        }
        if (is_null($groupPrices) || !is_array($groupPrices)) {
            return false;
        }
        if ($product->getCustomerGroupId()) {
            $customerGroup = $product->getCustomerGroupId();
        } else {
            $customerGroup = Mage::getSingleton('customer/session')->getCustomerGroupId();
        }
        $finalPrice = (float)$product->getPrice();
        foreach ($groupPrices as $groupPrice) {
            if ($groupPrice['cust_group'] == $customerGroup) {
                if ($groupPrice['isfixed'] == 1 && $groupPrice['website_price'] <= $finalPrice) {
                    return $customerGroup;
                } else if ($groupPrice['isfixed'] == 0 && ( $finalPrice * ( $groupPrice['website_price'] / 100) ) <= $finalPrice ) {
                    return $customerGroup;
                }
            }
        }
        return false;
    }

    public function getBotDeal() {

        $hd_param = Mage::app()->getRequest()->getParam('hotdeal');
        $ua = Mage::helper('core/http')->getHttpUserAgent();
        $match_uas = Mage::getStoreConfig('web/hotdeals/bot_agents');

        if ($match_uas) {

            $match_uas = explode(',', $match_uas);

            foreach ($match_uas as $match_ua) {

                if (strstr(strtolower($ua), trim($match_ua))) {
                    if (is_numeric($hd_param)){
                        Mage::getSingleton('customer/session')->setCustomerGroupId($hd_param);
                    } else {
                        Mage::getSingleton('customer/session')->setCustomerGroupId(null);
                    }
                    return $hd_param;

                }

            }
        }

    }

    /**
     * Check if product is hot deal (Associated)
     * @param $product Mage_Catalog_Model_Product
     * @return bool
     */
    public function isHotdealAssociated($product) {
        $result = false;
        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE) {
            $products = $product->getTypeInstance(true)
                ->setStoreFilter($product->getStore(), $product)
                ->getAssociatedProducts($product);
        }
        if (!isset($products)) {
            $products = array($product);
        }
        foreach($products as $item){
            $attribute = $item->getResource()->getAttribute('group_price');
            $attribute->getBackend()->afterLoad($item);
            $groupPrices = $item->getData('group_price');
            if ($this->isHotdeal($item)) {
                $result = true;
            }
        }

        return $result;
    }

}
