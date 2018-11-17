<?php

/**
 * Product:       Xtento_TwoFactorAuth (1.0.8)
 * ID:            ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=
 * Packaged:      2016-07-20T14:39:11+00:00
 * Last Modified: 2015-12-11T14:31:28+01:00
 * File:          app/code/local/Xtento/TwoFactorAuth/Model/Observer.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TwoFactorAuth_Model_Observer
{

    public function attachHtml($observer)
    {
        // Attach the code field to the admin login.
        $response = Mage::app()->getResponse();
        $request = Mage::app()->getRequest();

        if ($request->getControllerName() == 'index' && $request->getActionName() == 'login') {
            if (!Mage::helper('twofactorauth')->getModuleEnabled()) {
                return;
            }
            $body = $response->getBody();

            // Add some custom CSS to the header.
            $body = preg_replace("/\<\/head\>/", "<style>.login-form .input-box input.input-text { width: 179px; }</style>\n</head>", $body);

            // Rename the password fields class so it's in the middle of the layout
            $body = preg_replace("/\<div class=\"input-box input-right\"\>\<label for=\"login\"\>/", '<div class="input-box input-left" style="padding-left: 5px;"><label for="login">', $body);

            // Add the security code input field
            $body = preg_replace("/\<div class=\"clear\"\>\<\/div\>(.*)\<div class\=\"form-buttons\"\>/s", "<div class=\"input-box input-right\" style=\"padding-left: 5px;\"><label for=\"code\">" . Mage::helper('twofactorauth')->__('Security Code') . ":</label><br />\n                        <input type=\"text\" id=\"code\" name=\"login[code]\" class=\"input-text\" value=\"\" style=\"width:81px;\"/></div>\n                    <div class=\"clear\"></div><div class=\"form-buttons\">", $body);

            // Set new output
            $response->setBody($body);
        }
    }

    public function addTokenValidation($observer)
    {
        // Username and password have been validated and they are correct. Now let's check the security code.
        if (!Mage::helper('twofactorauth')->getModuleEnabled()) {
            return $this;
        }

        $loginData = Mage::app()->getRequest()->getParam('login');
        $adminSession = Mage::getSingleton('admin/session');
        $user = $adminSession->getUser();

        if ($user->getUserId() && $user->getTokenLoginEnabled() == '1' && $user->getLoginTokenSecret() !== '') {
            // Is login attempt from an IP address that doesn't need TFA?
            if ($this->_isTfaDisabledForIP()) {
                return $this;
            }
            // Check token
            $loginTokenSecret = Mage::helper('core')->decrypt($user->getLoginTokenSecret());
            if (strlen($loginTokenSecret) !== 16 || preg_match("/[^a-zA-Z0-9\\+=]/", $loginTokenSecret)) {
                // The secret key is broken. Decryption fails, the Magento encryption key probably changed.
                Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('twofactorauth')->__("Two Factor Authentication - WARNING: Your secret key is broken. You have probably updated your Magento installation or have moved the database to another installation and forgot to use the same Magento encryption key.<br/><br/>Please go to System > Permissions > Users, select your account, select the 'Two Factor Authentication' tab on the left and click the 'Create New Secret Key' button to create a new secret key and scan it using the Google Authenticator application. This is a VERY important notice. Two-Factor Authentication has been disabled for this account until you've generated a new secret key."));
                return $this;
            } else {
                if (is_array($loginData) && array_key_exists('code', $loginData) && !empty($loginData['code'])) {
                    if (empty($loginData['code'])) {
                        $adminSession->unsetAll();
                        Mage::throwException(Mage::helper('twofactorauth')->__('Please enter your security code.'));
                    }
                    if ($user->getLastTokenUsed() == $loginData['code']) {
                        // This code can't be used anymore as it was used for the last login. Code was not empty.
                        $adminSession->unsetAll();
                        Mage::throwException(Mage::helper('twofactorauth')->__('The security code you have entered has been used for the last login and thus has been disabled. Please wait and login using a new security code.'));
                    } else {
                        $googleAuth = Mage::getModel('twofactorauth/authenticator_totp');
                        // Verify security code
                        if ($googleAuth->authenticateUser($loginData['code'], $loginTokenSecret)) {
                            $writeAdapter = Mage::getSingleton('core/resource')->getConnection('core_write');
                            $condition = $writeAdapter->quoteInto('user_id=?', $user->getUserId());
                            $writeAdapter->update(Mage::getSingleton('core/resource')->getTableName('admin/user'), array('last_token_used' => $loginData['code']), $condition);
                            // Success!
                            return $this;
                        } else {
                            $adminSession->unsetAll();
                            Mage::throwException(Mage::helper('twofactorauth')->__('Wrong security code.'));
                        }
                    }
                } else {
                    $adminSession->unsetAll();
                    // Send email with QR code
                    /*$adminUsername = preg_replace("/[^A-Za-z0-9 ]/", "", $user->getUsername());
                    $gaUrl = urlencode("otpauth://totp/$adminUsername@" . $_SERVER['SERVER_NAME'] . "?secret=" . strtoupper($loginTokenSecret));
                    $urlToQrCode = "https://chart.googleapis.com/chart?cht=qr&chl=$gaUrl&chs=200x200";
                    $mail = new Zend_Mail();
                    $mail->setBodyHtml(Mage::helper('twofactorauth')->__('Please open and scan the following QR code using the Google Authenticator application: <a href="%s">QR Code</a>', $urlToQrCode));
                    $mail->setFrom(Mage::getStoreConfig('trans_email/ident_general/email'), Mage::getStoreConfig('trans_email/ident_general/name'))
                        ->addTo($user->getEmail(), $user->getEmail())
                        ->setSubject(Mage::helper('twofactorauth')->__('Two-Factor Authentication QR Code'));
                    $mail->send();*/
                    //
                    Mage::throwException(Mage::helper('twofactorauth')->__('Please enter your security code.'));
                }
            }
        } else {
            if (is_array($loginData) && array_key_exists('code', $loginData) && $loginData['code'] !== '') {
                Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('twofactorauth')->__('You have entered a security code even though Two-Factor Authentication is not enabled for your account. You should go to System > Permissions > Users to enable Two-Factor Authentication for your account.'));
            }
        }
    }

    public function addTabToUserEdit($observer)
    {
        // Add tab to the user edit to set up the two factor authentication
        $block = $observer->getEvent()->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Permissions_User_Edit_Tabs) {
            if (!Mage::helper('twofactorauth')->getModuleEnabled()) {
                return;
            }
            if ($block->getLayout()->getBlock('head')) {
                $block->getLayout()->getBlock('head')->addJs('xtento/adminhtml_twofactorauth.js');
            }
            if (Xtento_TwoFactorAuth_Model_System_Config_Backend_Server::isEnabled()) {
                $block->addTab('tfa_section', array(
                    'label' => Mage::helper('twofactorauth')->__('Two-Factor Authentication'),
                    'title' => Mage::helper('twofactorauth')->__('Two-Factor Authentication'),
                    'content' => $block->getLayout()->createBlock('twofactorauth/adminhtml_permissions_user_edit_tab_twofactorauth')->toHtml(),
                    'after' => 'roles_section',
                ));
            }
        }
    }

    private function _isTfaDisabledForIP()
    {
        $disabled = true;

        $allowedIps = Mage::getStoreConfig('twofactorauth/general/allow_ips');
        $remoteAddr = Mage::helper('core/http')->getRemoteAddr();
        $httpHost = Mage::helper('core/http')->getHttpHost();
        $forwardedFor = 'XXXXXXXXX';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $forwardedFor = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (!empty($allowedIps) && !empty($remoteAddr)) {
            $allowedIps = preg_split('#\s*,\s*#', $allowedIps, null, PREG_SPLIT_NO_EMPTY);
            if (array_search($remoteAddr, $allowedIps) === false && array_search($httpHost, $allowedIps) === false && array_search($forwardedFor, $allowedIps) === false) {
                $disabled = false;
            }
        } else {
            $disabled = false;
        }

        return $disabled;
    }

    public function sendEmailNotificationAfterAdminSave($observer)
    {
        $user = $observer->getObject();
        if ($user->getId() && Mage::app()->getRequest()->getPost('token_login_send_mail', false) > 0) {
            /*if ($user->getTokenLoginEnabled() == 1 &&
                ($user->getTokenLoginEnabled() != $user->getOrigData('token_login_enabled'))
            ) {*/
            if ($user->getLoginTokenSecret() != '' && Mage::registry('tfa_token_email_sent') === null) {
                // TFA enabled, send email to user
                $adminUsername = preg_replace("/[^A-Za-z0-9 ]/", "", $user->getUsername());
                $gaUrl = urlencode(
                    "otpauth://totp/$adminUsername@" . $_SERVER['SERVER_NAME'] . "?secret=" . strtoupper(
                        Mage::helper('core')->decrypt($user->getLoginTokenSecret())
                    )
                );
                $urlToQrCode = "https://chart.googleapis.com/chart?cht=qr&chl=$gaUrl&chs=200x200";
                $mail = new Zend_Mail();
                $mail->setBodyHtml(
                    Mage::helper('twofactorauth')->__(
                        'Please open and scan the following QR code using the Google Authenticator application on your smartphone: <a href="%s">QR Code</a><br/><br/>The code that is shown in the Google Authenticator application needs to be entered when logging into the admin panel then.',
                        $urlToQrCode
                    )
                );
                $mail->setFrom(
                    Mage::getStoreConfig('trans_email/ident_general/email'),
                    Mage::getStoreConfig('trans_email/ident_general/name')
                )
                    ->addTo($user->getEmail(), $user->getEmail())
                    ->setSubject(Mage::helper('twofactorauth')->__('Two-Factor Authentication QR Code'));
                $mail->send();
                Mage::register('tfa_token_email_sent', true, true);
            }
            /*}*/
        }
    }

    /*
     * ALMOST (!) compatible with Magento version 1.3 as well.. didn't work though.
     */
    /*
    public function attachHtml($observer)
    {
        // Attach the code field to the admin login.
        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Mage_Adminhtml_Block_Template && $block->getTemplate() == 'login.phtml') {
            if (!Mage::helper('twofactorauth')->getModuleEnabled()) {
                return;
            }
            $body = $observer->getEvent()->getTransport()->getHtml();

            // Add some custom CSS to the header.
            $body = preg_replace("/\<\/head\>/", "<style>.login-form .input-box input.input-text { width: 179px; }</style>\n</head>", $body);

            // Rename the password fields class so it's in the middle of the layout
            $body = preg_replace("/\<div class=\"input-box input-right\"\>\<label for=\"login\"\>/", '<div class="input-box input-left" style="padding-left: 5px;"><label for="login">', $body);

            // Add the security code input field
            $body = preg_replace("/\<div class=\"clear\"\>\<\/div\>(.*)\<div class\=\"form-buttons\"\>/s", "<div class=\"input-box input-right\" style=\"padding-left: 5px;\"><label for=\"code\">" . Mage::helper('twofactorauth')->__('Security Code') . ":</label><br />\n                        <input type=\"text\" id=\"code\" name=\"login[code]\" class=\"input-text\" value=\"\" style=\"width:81px;\"/></div>\n                    <div class=\"clear\"></div><div class=\"form-buttons\">", $body);

            // Set new output
            $observer->getEvent()->getTransport()->setHtml($body);
        }
    }*/
}