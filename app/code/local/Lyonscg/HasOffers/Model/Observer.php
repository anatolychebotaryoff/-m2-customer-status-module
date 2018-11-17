<?php
/**
 * Add support for HasOffers integration
 *
 * @category  Lyons
 * @package   Lyonscg_HasOffers
 * @author    Logan Montgomery <lmontgomery@lyonscg.com>
 * @copyright Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_HasOffers_Model_Observer
{
    /**
     * Check for presence of 'Has Offers' url parameters and save them in user session
     *
     * @param $observer
     */
    const COOKIE_LIFETIME = 15552000;    // 30 days in seconds: 30days * 24hours * 60mins * 60sec
    public function onControllerActionPredispatch($observer)
    {
        // these parameters are expected from the query string only, i.e. $_GET
        // that is why Mage::app()->getRequest()->getParam() is not used
        $_transactionId = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : false;
        $_affiliateId = isset($_GET['affiliate_id']) ? $_GET['affiliate_id'] : false;
        $_offerId = isset($_GET['offer_id']) ? $_GET['offer_id'] : false;

        if ($_transactionId === false || $_affiliateId === false || $_offerId === false)
        {
            return;
        }

        /** @var Mage_Core_Model_Cookie $cookie */
        $cookie = Mage::getSingleton('core/cookie');
        $cookieData = Mage::helper('lyonscg_hasoffers')->encryptCookie(array(
            'transaction_id' => $_transactionId,
            'affiliate_id' => $_affiliateId,
            'offer_id' => $_offerId,
        ));

        $cookie->set('hasoffers', $cookieData, self::COOKIE_LIFETIME);

        return;
    }

    public function onSalesOrderPlaceAfter($observer)
    {
        /** @var Mage_Core_Model_Cookie $cookie */
        $cookie = Mage::getSingleton('core/cookie');
        $encryptedData = $cookie->get('hasoffers');
        if (empty($encryptedData)) {
            return $this;
        }
        $cookieData = Mage::helper('lyonscg_hasoffers')->decryptCookie($encryptedData);
        if (empty($cookieData)) {
            return $this;
        }

        $order = $observer->getEvent()->getOrder();
        if (!$order || !$order->getId()) {
            return $this;
        }

        $hoOrder = Mage::getModel('lyonscg_hasoffers/order')->load($order->getId(), 'order_id');

        $hoOrder->setData('transaction_id', $cookieData['transaction_id']);
        $hoOrder->setData('affiliate_id', $cookieData['affiliate_id']);
        $hoOrder->setData('offer_id', $cookieData['offer_id']);
        $hoOrder->setData('order_id', $order->getId());

        $hoOrder->save();

        $cookie->delete('hasoffers');
    }
}
