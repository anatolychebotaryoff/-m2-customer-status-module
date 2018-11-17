<?php

class Lyonscg_BusinessAccount_IndexController extends Mage_Core_Controller_Front_Action
{

    const XML_PATH_EMAIL_RECIPIENT      = 'lyonscg_businessaccount/email/recipient_email';
    const XML_PATH_EMAIL_RECIPIENT_INT  = 'lyonscg_businessaccount/email/recipient_email_international';
    const XML_PATH_EMAIL_SENDER         = 'lyonscg_businessaccount/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE       = 'lyonscg_businessaccount/email/email_template';
    const REDIRECT_URL = 'business-account.html';

    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('businessContactForm')
            ->setFormAction(Mage::getUrl('*/*/post'))
            ->setIsInternational(false);

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }

    public function internationalAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('businessContactForm')
            ->setFormAction(Mage::getUrl('*/*/post'))
            ->setIsInternational(true);

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }

    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        $backUrl = self::REDIRECT_URL;
        if ( $post ) {
            if (!empty($post['uenc']))
            {
                $backUrl = Mage::helper('core/url')->urlDecode($post['uenc']);
            }
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    throw new Exception();
                }
                $mailTemplate = Mage::getModel('core/email_template');

                $recipient = self::XML_PATH_EMAIL_RECIPIENT;
                if (isset($post['international']) && $post['international'] == 1)
                {
                    $recipient = self::XML_PATH_EMAIL_RECIPIENT_INT;
                }

                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig($recipient),
                        null,
                        array('data' => $postObject)
                    );

                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }

                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                $this->_redirect(self::REDIRECT_URL);

                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                $this->_redirect($backUrl);
                return;
            }

        } else {
            $this->_redirect($backUrl);
        }
    }

}
