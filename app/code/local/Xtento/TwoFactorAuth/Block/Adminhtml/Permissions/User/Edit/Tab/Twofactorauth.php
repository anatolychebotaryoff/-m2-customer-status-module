<?php

/**
 * Product:       Xtento_TwoFactorAuth (1.0.8)
 * ID:            ICP396wqk9khsjxTrTbiK7D1AGMzl30Dl+LUHA50d28=
 * Packaged:      2016-07-20T14:39:11+00:00
 * Last Modified: 2015-12-08T20:44:18+01:00
 * File:          app/code/local/Xtento/TwoFactorAuth/Block/Adminhtml/Permissions/User/Edit/Tab/Twofactorauth.php
 * Copyright:     Copyright (c) 2015 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TwoFactorAuth_Block_Adminhtml_Permissions_User_Edit_Tab_Twofactorauth extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('permissions_user');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('tfa_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('twofactorauth')->__('Two-Factor Authentication')));
        $secretKeyBrokenNoticeJs = '';

        $standbyToken = Mage::getModel('twofactorauth/authenticator_totp')->createBase32Key();
        $encryptedStandbyToken = Mage::helper('core')->encrypt($standbyToken);
        if ($model->getLoginTokenSecret() == '') {
            $loginTokenSecret = $standbyToken;
            $model->setLoginTokenSecret(Mage::helper('core')->encrypt($loginTokenSecret));
        } else {
            $loginTokenSecret = Mage::helper('core')->decrypt($model->getLoginTokenSecret());
            if (strlen($loginTokenSecret) !== 16 || preg_match("/[^a-zA-Z0-9\\+=]/", $loginTokenSecret)) {
                // The secret key is broken. Decryption fails, the Magento encryption key probably changed.
                $secretKeyBrokenNoticeJs = "<script>keyBrokenWarning();</script>";
            }
        }

        $model->setTextLastTokenUsed($model->getLastTokenUsed()); // So the last_token_used doesn't get updated in the database

        $urlToQrCode = $this->_getQrCodeUrl($model->getUsername(), $loginTokenSecret);
        $fieldset->addField('token_login_enabled_toggle', 'checkbox', array(
            'name' => 'token_login_enabled_toggle',
            'label' => Mage::helper('twofactorauth')->__('Enable for this user'),
            'id' => 'token_login_enabled_toggle',
            'title' => Mage::helper('twofactorauth')->__('Enable for this user'),
            'onchange' => 'toggleTokenLoginEnabled(\''.$urlToQrCode.'\')',
            'checked' => ($model->getTokenLoginEnabled() == '1') ? true : false,
        ));

        $fieldset->addField('token_login_send_mail_toggle', 'checkbox', array(
            'name' => 'token_login_send_mail_toggle',
            'label' => Mage::helper('twofactorauth')->__('Send QR code to admin email'),
            'id' => 'token_login_send_mail_toggle',
            'title' => Mage::helper('twofactorauth')->__('Send QR code to admin email'),
            'onchange' => 'toggleTokenSendMail()',
            'checked' => false,
        ));

        $fieldset->addField('text_last_token_used', 'text', array(
            'name' => 'text_last_token_used',
            'label' => Mage::helper('twofactorauth')->__('Last login code used'),
            'id' => 'text_last_token_used',
            'title' => Mage::helper('twofactorauth')->__('Last login code used'),
            'disabled' => true,
            'style' => 'background-color:#f0f0f0; width: 50px;'
        ));

        $urlToStandbyQrCode = $this->_getQrCodeUrl($model->getUsername(), $standbyToken);
        $fieldset->addField('generate_secret', 'note', array(
            // Dirty fix as the 'button' type seems to be not working.
            'name' => 'generate_secret',
            'id' => 'generate_secret',
            'label' => Mage::helper('twofactorauth')->__('Create new secret key'),
            'text' => $secretKeyBrokenNoticeJs.'<input type="button" id="tfa_generate_secret" class="form-button" value="' . Mage::helper('twofactorauth')->__('Create new secret key') . '" onclick="regenerateSecretKey(\''.$urlToStandbyQrCode.'\', \''.$encryptedStandbyToken.'\')"/><script>var loginTestUrl = \''.Mage::helper('adminhtml')->getUrl('*/twofactorauth_login/test', array('_secure' => Mage::app()->getStore()->isCurrentlySecure())).'\';</script>',
        ));

        $fieldset->addField('login_token_secret', 'hidden', array(
            'name' => 'login_token_secret',
            'id' => 'login_token_secret',
        ));

        $fieldset->addField('token_login_enabled', 'hidden', array(
            'name' => 'token_login_enabled',
            'id' => 'token_login_enabled',
        ));

        $fieldset->addField('token_login_send_mail', 'hidden', array(
            'name' => 'token_login_send_mail',
            'id' => 'token_login_send_mail',
        ));

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    private function _getQrCodeUrl($adminUsername, $loginTokenSecret)
    {
        $adminUsername = preg_replace("/[^A-Za-z0-9 ]/", "", $adminUsername);
        $gaUrl = urlencode("otpauth://totp/$adminUsername@" . $_SERVER['SERVER_NAME'] . "?secret=" . strtoupper($loginTokenSecret));
        $urlToQrCode = "//chart.googleapis.com/chart?cht=qr&chl=$gaUrl&chs=200x200";
        return $urlToQrCode;
    }
}
