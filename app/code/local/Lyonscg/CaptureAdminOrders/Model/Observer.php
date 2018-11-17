<?php
/**
 * Cart observer on add to cart
 *
 * @category   Lyonscg
 * @package    Lyonscg_CaptureAdminOrders
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Capture Admin Orders Observer to capture Admin Username and Admin User id.
 *
 * @category   Lyons
 * @package    Lyonscg_CaptureAdminOrders
 */
class Lyonscg_CaptureAdminOrders_Model_Observer
{

    /**
     * File name to capture error messages.
     * 
     * @var type
     */
    public $filename = 'lyonscg_captureadminorders_debug';

    /**
     * Observer to Log admin activiy for orders placed through admin panel.
     * 
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function captureAdminInfo(Varien_Event_Observer $observer)
    {
        try {
            $adminName = '';
            $adminId = '';
            $event = $observer->getEvent();

            if ($event->getOrderCreateModel()) {
                $adminUser = Mage::getSingleton('admin/session')->getData('user')->getData();
                $adminName = $adminUser['firstname'] . ' ' . $adminUser['lastname'];
                $adminId = $adminUser['username'];

                $event->getOrderCreateModel()->getQuote()->setAdminUsername($adminName);
                $event->getOrderCreateModel()->getQuote()->setAdminUserid($adminId);
            } elseif ($order = $event->getOrder()) {
                if ($adminUserId = Mage::getSingleton('customer/session')->getAdminId()) {
                    $adminId = $adminUserId;
                }
                $order->setAdminUserid($adminId)->save();
            }
        } catch (Exception $e) {
            $this->filename .= '_' . date("Y-m") . '.log';
            Mage::log('Error occured while adding admin info for ' .
                    $adminName . ' with id: ' . $adminId
                    . '.  Here is the error: ' . $e->getMessage(), null, $this->filename);
        }
    }

}
