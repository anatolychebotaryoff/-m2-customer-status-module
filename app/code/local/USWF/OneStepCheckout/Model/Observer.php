<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_OneStepCheckout
 * @copyright
 * @author
 */
class USWF_OneStepCheckout_Model_Observer
{

    const XML_STORE_ROUTERS_PATH = 'web/uswf_routers';

    /**
     * Observer to check item added to cart and throw exception if customer address matches ship_no_<location> attribute
     *
     * @param Varien_Event_Observer $observer
     * @return USWF_OneStepCheckout_Model_Observer
     */
    public function checkoutCartProductAddAfter($observer)
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $shipping = Mage::getSingleton('customer/session')->getCustomer()->getDefaultShipping();
            $regionId = Mage::getModel('customer/address')->load($shipping)->getRegionId();
            if (empty($regionId)) {
                $billing = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling();
                $regionId = Mage::getModel('customer/address')->load($billing)->getRegionId();
            }
            if ($regionId) {
                $result = Mage::helper('lyonscg_checkout')->checkItems($regionId, $observer->getProduct(), false);
            }
            if (isset($result['error'])) {
                $messages = '';
                foreach($result['message'] as $message) {
                    $messages .= $message . "\n";
                    
                }
                throw new Mage_Core_Exception($message);
            }
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function controllerFrontInitBefore(Varien_Event_Observer $observer)
    {
        $routersInfo = Mage::app()->getStore()->getConfig(self::XML_STORE_ROUTERS_PATH);
        $front = $observer->getEvent()->getFront();

        foreach ($routersInfo as $routerCode => $routerInfo) {
            if (isset($routerInfo['disabled']) && $routerInfo['disabled']) {
                continue;
            }
            if (isset($routerInfo['class'])) {
                $router = new $routerInfo['class'];
                if (isset($routerInfo['area'])) {
                    $router->collectRoutes($routerInfo['area'], $routerCode);
                }
                $front->addRouter($routerCode, $router);
            }
        }
    }

    /**
     * Set customer comment visible on frontend
     *
     * @param Varien_Event_Observer $observer
     */
    public function setCustomerCommentOnFrontend(Varien_Event_Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $history = $order->getStatusHistoryCollection();
        if (!is_null($history)) {
            foreach($history as $item){
                $item->setIsVisibleOnFront(true);
                $item->save();
            }
        }
    }

}