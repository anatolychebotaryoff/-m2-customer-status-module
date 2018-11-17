<?php
/**
 * Override Lyonscg_LoginAsCustomer_Adminhtml_Inchoo_LoginAsCustomerController class for adding admin user to request
 *
 * @category  USWF
 * @package   USWF_CaptureAdminOrders
 * @author    USWF
 */

require_once 'Lyonscg/LoginAsCustomer/controllers/Adminhtml/Inchoo/LoginAsCustomerController.php';

class USWF_CaptureAdminOrders_Adminhtml_Inchoo_LoginAsCustomerController extends Lyonscg_LoginAsCustomer_Adminhtml_Inchoo_LoginAsCustomerController
{
    /**
     * Override to add admin_user to request
     */
    public function loginAction()
    {
        $adminUser = Mage::getSingleton('admin/session')->getData('user');
        $info = Mage::helper('core')->encrypt(serialize(array(
            'website_id' => $this->getRequest()->getParam('website_id'),
            'customer_id' => $this->getRequest()->getParam('customer_id'),
            'timestamp' => time(),
            'admin_user' => array('admin_id'=>$adminUser->getData('user_id'),'admin_name'=>$adminUser->getData('username'))
        )));

        $this->_redirectUrl(Mage::app()->getWebsite($this->getRequest()->getParam('website_id'))->getConfig('web/unsecure/base_url').'index.php/inchoo_loginAsCustomer/customer/login?loginAsCustomer='.base64_encode($info));
    }
}
