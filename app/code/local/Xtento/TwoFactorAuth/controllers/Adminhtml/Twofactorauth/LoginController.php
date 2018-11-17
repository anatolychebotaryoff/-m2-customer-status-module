<?php

/**
 * Product:       Xtento_TwoFactorAuth (1.0.8)
 * ID:            ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=
 * Packaged:      2016-07-20T14:39:11+00:00
 * Last Modified: 2015-12-08T20:48:05+01:00
 * File:          app/code/local/Xtento/TwoFactorAuth/controllers/Adminhtml/Twofactorauth/LoginController.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TwoFactorAuth_Adminhtml_TwoFactorAuth_LoginController extends Mage_Adminhtml_Controller_Action
{
    /*
     * Function to test whether the supplied login code is valid. Only works if the user is logged in.
     */
    public function testAction()
    {
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $googleAuth = Mage::getModel('twofactorauth/authenticator_totp');
            $enteredCode = $this->getRequest()->getPost('entered_code');
            $secretKey = Mage::helper('core')->decrypt($this->getRequest()->getPost('secret_key'));
            if ($googleAuth->authenticateUser($enteredCode, $secretKey)) {
                echo $this->_jsonEncode(array('error' => false, 'message' => Mage::helper('twofactorauth')->__('Login code correct. Congratulations! Please click \'Save User\' to enable Two-Factor Authentication for this user.')));
            } else {
                echo $this->_jsonEncode(array('error' => true, 'message' => Mage::helper('twofactorauth')->__('Login failed, wrong code. If this error keeps occurring, this could be caused by a wrong time setting on either your smartphone or on your server. Please synchronize the time of your smartphone and if that does not help, get in touch with your server administrator so they make sure the server time is correct.')));
            }

        } else {
            echo $this->_jsonEncode(array('error' => true, 'message' => Mage::helper('twofactorauth')->__('You are not logged in and thus not allowed to validate a secret key.')));
        }
        return;
    }

    private function _jsonEncode($data)
    {
        if (Mage::helper('xtcore/utils')->mageVersionCompare(Mage::getVersion(), '1.4.0.0', '>=')) {
            return Mage::helper('core')->jsonEncode($data);
        } else {
            return Zend_Json::encode($data);
        }
    }

    protected function _isAllowed()
    {
        return true;
    }
}