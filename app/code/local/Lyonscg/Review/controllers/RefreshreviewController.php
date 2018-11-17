<?php
/**
 * Lyonscg Review
 *
 * @category    Lyonscg
 * @package     Lyonscg_Review
 * @copyright   Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 * @author      Logan Montgomery (lmontgomery@lyonscg.com)
 */

class Lyonscg_Review_RefreshreviewController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('core/template');
        $block->setTemplate('lyonscg/refreshreview/index.phtml');
        $this->_addContent($block);
        $this->renderLayout();
    }
    public function refreshAction()
    {
        $helper = Mage::helper('lyonscg_review');
        $count = $helper->refreshReviews();
        if ($count !== false) {
            $message = $helper->__('%d Reviews aggregated', $count);
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        }
        else {
            Mage::getSingleton('adminhtml/session')->addError($helper->__('There was a problem refreshing reviews'));
        }

        $this->getResponse()->setRedirect(Mage::helper('adminhtml')->getUrl('adminhtml/refreshreview/index'));
    }
}