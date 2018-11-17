<?php
/**
 * Override Inchoo_LoginAsCustomer_Adminhtml_Inchoo_LoginAsCustomerController class for adding admin user to request
 *
 * @category  Lyons
 * @package   Lyonscg_LoginAsCustomer
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */
require_once 'Inchoo/LoginAsCustomer/controllers/Adminhtml/Inchoo/LoginAsCustomerController.php';

class Lyonscg_LoginAsCustomer_Adminhtml_Inchoo_LoginAsCustomerController extends Inchoo_LoginAsCustomer_Adminhtml_Inchoo_LoginAsCustomerController
{
    /**
     * Override to add admin_user to request
     */
    public function loginAction()
    {
        $info = Mage::helper('core')->encrypt(serialize(array(
            'website_id' => $this->getRequest()->getParam('website_id'),
            'customer_id' => $this->getRequest()->getParam('customer_id'),
            'timestamp' => time(),
            'admin_user' => Mage::getSingleton('admin/session')->getData('user')->getUsername()
        )));

        $this->_redirectUrl(Mage::app()->getWebsite($this->getRequest()->getParam('website_id'))->getConfig('web/unsecure/base_url').'index.php/inchoo_loginAsCustomer/customer/login?loginAsCustomer='.base64_encode($info));
    }
}
