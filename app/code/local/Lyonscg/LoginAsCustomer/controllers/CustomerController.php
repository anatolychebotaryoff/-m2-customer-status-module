<?php
/**
 * Override Inchoo_LoginAsCustomer_CustomerController to set admin id in customer/session
 *
 * @category  Lyons
 * @package   Lyonscg_LoginAsCustomer
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */
require_once 'Inchoo/LoginAsCustomer/controllers/CustomerController.php';

class Lyonscg_LoginAsCustomer_CustomerController extends Inchoo_LoginAsCustomer_CustomerController
{
    public function loginAction()
    {
        parent::loginAction();

        $info = unserialize(
            Mage::helper('core')->decrypt( /* important step; use Magento encryption key to decrypt/extract info */
                base64_decode(
                    $this->getRequest()->getParam('loginAsCustomer')
                )
            )
        );

        // Set admin user in customer session
        if (isset($info['admin_user'])) {
            Mage::getSingleton('customer/session')->setAdminId($info['admin_user']);
        }
    }
}
