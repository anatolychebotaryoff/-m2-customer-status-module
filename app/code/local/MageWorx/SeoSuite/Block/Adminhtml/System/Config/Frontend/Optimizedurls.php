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

class MageWorx_SeoSuite_Block_Adminhtml_System_Config_Frontend_Optimizedurls extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected $_off = false;

    public function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        if($this->_off){
            return 'Feature is ON by Magento since enterprise edition 1.13.0.0';
        }
        return parent::_getElementHtml($element);
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        if(Mage::helper('seosuite')->isEnterpriseSince113()){
            $element->setComment('');
            $this->_off = true;
        }elseif(version_compare(Mage::getConfig()->getModuleConfig("Mage_Catalog")->version, '1.6.0.0.14', '<' )){
            $element->setComment("<b><font color = 'orange'>You use old magento version. Please see Troubleshooting section of
                                     SEO Suite's User Guide prior to enabling or disabling the setting.</font></b><br><br>" .
                                     $element->getComment());
        }
        return parent::render($element);
    }
}