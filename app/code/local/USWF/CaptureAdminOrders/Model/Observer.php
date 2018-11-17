<?php
/**
 * Cart observer on add to cart
 *
 */

/**
 * Capture Admin Orders Observer to capture Admin Username and Admin User id.
 *
 * @category   USWF
 * @package    USWF_CaptureAdminOrders
 */
class USWF_CaptureAdminOrders_Model_Observer extends Lyonscg_CaptureAdminOrders_Model_Observer
{

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
                $adminName = $adminUser['username'];
                $adminId = $adminUser['user_id'];

                $event->getOrderCreateModel()->getQuote()->setAdminUsername($adminName);
                $event->getOrderCreateModel()->getQuote()->setAdminUserid($adminId);
            } elseif ($order = $event->getOrder()) {
                if ($adminUser = Mage::getSingleton('customer/session')->getAdminId()) {
                    $admin_data = array('admin_username' => $adminUser["admin_name"], 'admin_userid'=>$adminUser["admin_id"]);
                    $model = $order->addData($admin_data);
                    $model->save();
                }
            }
        } catch (Exception $e) {
            $this->filename .= '_' . date("Y-m") . '.log';
            Mage::log('Error occured while adding admin info for ' .
                    $adminName . ' with id: ' . $adminId
                    . '.  Here is the error: ' . $e->getMessage(), null, $this->filename);
        }
    }

}
