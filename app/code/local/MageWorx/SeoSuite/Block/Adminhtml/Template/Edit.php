<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */
class MageWorx_Seosuite_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_objectId   = 'template_id';
        $this->_blockGroup = 'seosuite';
        $this->_controller = 'adminhtml_template';

        parent::__construct();
        $this->_removeButton('reset');
        $this->_removeButton('delete');
        $this->_updateButton('save', 'label', Mage::helper('salesrule')->__('Save Template'));
        //$this->_updateButton('delete', 'label', Mage::helper('salesrule')->__('Delete Rule'));
        //$template = $this->getSeoTemplate();
        #$this->setTemplate('promo/quote/edit.phtml');
    }

    public function getSeoTemplate()
    {
        return Mage::registry('seosuite_template_edit');
    }

    public function getHeaderText()
    {
        $template = $this->getSeoTemplate();
        if ($storeId  = $this->getRequest()->getParam('store')) {
            $storeview = Mage::app()->getStore($storeId)->getName();
        }
        else {
            $storeview = $this->__('Default');
        }

        if ($template->getTemplateId()) {
            return Mage::helper('salesrule')->__("Edit Template '%s' for '%s' Store View",
                            $this->htmlEscape($template->getTemplateName()), $storeview);
        }
    }

}
