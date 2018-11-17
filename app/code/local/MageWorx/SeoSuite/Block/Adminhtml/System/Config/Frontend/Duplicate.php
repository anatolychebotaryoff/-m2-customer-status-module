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

class MageWorx_SeoSuite_Block_Adminhtml_System_Config_Frontend_Duplicate extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        if (Mage::getSingleton('adminhtml/config_data')->getStore()){
            $storeId = Mage::getModel('core/store')->load(Mage::getSingleton('adminhtml/config_data')->getStore())->getId();
        }
        elseif (Mage::getSingleton('adminhtml/config_data')->getWebsite()){
            $websiteId = Mage::getModel('core/website')->load(Mage::getSingleton('adminhtml/config_data')->getWebsite())->getId();
            $storeId = Mage::app()->getWebsite($websiteId)->getDefaultStore()->getId();
        }
        else{
            $storeId = 0;
        }

        $element->setValue(Mage::getStoreConfigFlag('catalog/seo/product_use_categories', $storeId));
        return parent::render($element);
    }
}