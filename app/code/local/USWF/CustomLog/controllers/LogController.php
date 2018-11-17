<?php

class USWF_CustomLog_LogController extends Mage_Core_Controller_Front_Action
{
    public function addAction()
    {
        if ($this->getRequest()->isPost()) {
            $postFormKey = $this->getRequest()->getParam('form_key', null);
            $postUrl = $this->getRequest()->getParam('url', null);
            if (Mage::getSingleton('core/session')->getFormKey() === $postFormKey) {
                Mage::log('bad url_image: '.$postUrl, null, 'uswf_custom.log');
            }
        }
    }
}