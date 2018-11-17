<?php
/**
 * Rewrite core google analtyics class to upgrade to google universal analytics
 *
 * @category   Lyons
 * @package    Lyonscg_GoogleAnalytics
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class Lyonscg_GoogleAnalytics_Block_Ga extends Mage_GoogleAnalytics_Block_Ga
{
    /**
     * Render regular page tracking javascript code
     * Added in optimizely universal analytics integration
     *
     * @link https://developers.google.com/analytics/devguides/collection/upgrade/reference/gajs-analyticsjs
     * @link https://help.optimizely.com/hc/en-us/articles/200039995-How-to-integrate-Optimizely-with-your-Google-Analytics-Account
     * @param string $accountId
     * @return string
     */
    protected function _getHeaderPageTrackingCode($accountId)
    {
        return "try {
ga('create', '{$this->jsQuoteEscape($accountId)}', 'auto');
ga('require', 'ec');
ga('require', 'displayfeatures');
} catch (e) {}

// Optimizely Universal Analytics Integration code
window.optimizely = window.optimizely || [];
window.optimizely.push(['activateUniversalAnalytics']);
";
    }

    /**
     * Send Page View Tracking Code
     *
     * @return string
     */
    protected function _getPageViewTrackingCode()
    {
        return "try {
    ga('send', 'pageview');
} catch (e) {}
";
    }

    /**
     * Render information about specified orders and their items
     *
     * @link https://developers.google.com/analytics/devguides/collection/upgrade/reference/gajs-analyticsjs
     * @return string
     */
    protected function _getOrdersTrackingCode()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds))
        ;
        $result = array();
        foreach ($collection as $order) {
            if ($order->getIsVirtual()) {
                $address = $order->getBillingAddress();
            } else {
                $address = $order->getShippingAddress();
            }
            $result[] = sprintf("ga('ec:setAction', 'purchase', {
                'id': '%s',
                'affiliation': '%s',
                'revenue': '%s',
                'tax': '%s',
                'shipping': '%s',
                'coupon': '%s'
                });",
                $order->getIncrementId(),
                $this->jsQuoteEscape(Mage::app()->getStore()->getFrontendName()),
                $order->getBaseGrandTotal(),
                $order->getBaseTaxAmount(),
                $order->getBaseShippingAmount(),
                $order->getCouponCode()
            );
            foreach ($order->getAllVisibleItems() as $item) {
                $result[] = sprintf("ga('ec:addProduct', {
                  'id': '%s',
                  'name': '%s',
                  'category': '%s',
                  'price': '%s',
                  'quantity': '%s'
                });",
                $item->getSku(),
                $this->jsQuoteEscape($item->getName()),
                null, // there is no "category" defined for the order item
                $item->getBasePrice(),
                $item->getQtyOrdered()
                );
            }
        }
        return implode("\n", $result);
    }
}
