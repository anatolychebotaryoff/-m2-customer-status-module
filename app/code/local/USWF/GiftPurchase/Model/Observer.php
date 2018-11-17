<?php

class USWF_GiftPurchase_Model_Observer
{
    protected $_addedProductId = array();

    /*
     * Add gift
     */
    public function checkoutCartProductAddAfter(Varien_Event_Observer $observer) {
        $product = $observer->getData('product');
        $quote = Mage::getSingleton('checkout/session')->getQuote();

        $date = date('Y-m-d');
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $rules = Mage::getResourceModel('uswf_giftpurchase/rule')->getRulesFromProduct($date, Mage::app()->getStore()->getId(), $customerGroupId, $product->getId());
        $rulesResult = array();
        foreach ($rules as $rule) {
            $ruleTmp = Mage::getModel('uswf_giftpurchase/rule');
            $ruleTmp->load($rule['rule_id']);
            if (!$ruleTmp->isEmpty() && $ruleTmp->getIsActive()) {
                $rulesResult[$ruleTmp->getId()] = $ruleTmp;
            }
        }

        foreach ($rulesResult as $rule) {
            $skuGifts = array_map('trim', explode(',', $rule->getGiftProductSku()));
            foreach ($skuGifts as $elem) {
                $_productId = (int)Mage::getModel('catalog/product')->getIdBySku($elem);
                $_product = Mage::getModel('catalog/product')->load($_productId);
                if (is_object($_product) && $_product->isSaleable()) {
                    if ($rule->getPopupTextActive()) {
                        Mage::getSingleton('checkout/session')->setGiftProductRulePopupText($rule->getPopupText());
                    }
                    $additionalOptions['gift_product'] = 1;
                    $_product->addCustomOption('gift_option', serialize($additionalOptions));
                    $options = array(
                        'qty' => $rule['gift_product_qty'],
                        'gift_product' =>
                            array(
                                'gift_product_rule_id', $rule->getId()
                            )
                    );
                    if (is_object($_product) && $_product->getTypeID() == 'bundle') {
                        $bundleOptions = array();
                        $selectionCollection = $_product->getTypeInstance(true)->getSelectionsCollection(
                            $_product->getTypeInstance(true)->getOptionsIds($_product), $_product
                        );
                        foreach ($selectionCollection as $option) {
                            $bundleOptions[$option->getOptionId()] = $option->getSelectionId();
                        }
                        $options['bundle_option'] = $bundleOptions;
                    }
                    try {
                        $this->_addedProductId[$_product->getId()] = 1;
                        $quote->addProduct($_product, new Varien_Object($options));
                    } catch (Exception $ex) {
                        Mage::logException($ex);
                    }
                }
            }
        }
        if (count($rulesResult)) {
            $quote->collectTotals()->save();
        }
    }

    public function salesQuoteProductAddAfter(Varien_Event_Observer $observer)
    {
        $items = $observer->getData('items');

        foreach ($items as $key => $item) {
            /* @var $item Mage_Sales_Model_Quote_Item*/
            if ($item->getParentItemId()) {
                continue;
            }
            if (array_key_exists($item->getProductId(), $this->_addedProductId)) {
                /** @var Mage_Core_Model_Cookie $cookieModel */
                $cookieModel = Mage::getSingleton('core/cookie');
                $cookieModel->set(
                    USWF_GiftPurchase_Helper_Data::GIFTCHECKOUT_POPUP_COOKIE,
                    true,
                    Mage::getConfig()->getNode('global/session_cache_limiter'),
                    null,null,null,false
                );
                $item->setCustomPrice(0);
                $item->setOriginalCustomPrice(0);
                unset($this->_addedProductId[$item->getProductId()]);
            }
        }
    }

    /*
     * Remove gift
     */
    public function salesQuoteRemoveItem(Varien_Event_Observer $observer)
    {
        $quote = Mage::getSingleton('checkout/cart')->getQuote();
        $removeItem = $observer->getQuoteItem();
        $productId = $removeItem->getProductId();

        $date = date('Y-m-d');
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $rules = Mage::getResourceModel('uswf_giftpurchase/rule')->getRulesFromProduct($date, Mage::app()->getStore()->getId(), $customerGroupId, $productId);
        $rulesResult = array();

        foreach ($rules as $rule) {
            $ruleTmp = Mage::getModel('uswf_giftpurchase/rule');
            $ruleTmp->load($rule['rule_id']);
            if (!$ruleTmp->isEmpty() && $ruleTmp->getIsActive()) {
                $rulesResult[$ruleTmp->getId()] = $ruleTmp;
            }
        }

        foreach ($rulesResult as $rule) {
            $skuGifts = array_map('trim', explode(',', $rule->getGiftProductSku()));
            foreach ($skuGifts as $elem) {
                $giftProductId = Mage::getModel('catalog/product')->getIdBySku($elem);
                $items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
                foreach($items as $item) {
                    if ($item->getProductId() == $giftProductId) {
                        $itemOptions  = $item->getOptionsByCode();
                        if (isset($itemOptions['gift_option'])) {
                            $itemOptions = unserialize($itemOptions['gift_option']->getValue());
                            if ($itemOptions['gift_product'] == 1) {
                                try {
                                    $quote->deleteItem($item);
                                } catch (Exception $ex) {
                                    Mage::logException($ex);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}