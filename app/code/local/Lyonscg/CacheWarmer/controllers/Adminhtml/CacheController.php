<?php

/**
 * Cache Controller Model
 *
 * @category    Lyonscg
 * @package     Lyonscg_CacheWarmer
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author      Richard Loerzel (rloerzel@lyonscg.com)
 */

class Lyonscg_CacheWarmer_Adminhtml_CacheController extends Mage_Adminhtml_Controller_Action
{
    public function reheatAction()
    {
        try {
            $message = Mage::getModel('cachewarmer/cache')->reheat('manual');
            if ($message['type'] == 'success') {
                $this->_getSession()->addSuccess($message['content']);
            } else {
                $this->_getSession()->addError($message['content']);
            } 
        } catch (Exception $e) {
            $this->_getSession()->addError('Error warming cache: ' . $e->getMessage());
        }
        $this->getResponse()->setRedirect(Mage::helper('adminhtml')->getUrl("adminhtml/cache"));
    }
      
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cachewarmer/reheat');
    }
}	