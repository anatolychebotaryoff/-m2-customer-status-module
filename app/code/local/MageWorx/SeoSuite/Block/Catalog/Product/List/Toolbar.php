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
class MageWorx_SeoSuite_Block_Catalog_Product_List_Toolbar extends MageWorx_SeoSuite_Block_Catalog_Product_List_Toolbar_Abstract
{

    public function getPagerUrl($params = array())
    {
        if($this->_out()){
            return parent::getPagerUrl($params);
        }

        $urlParams                 = array();
        $urlParams['_current']     = true;
        $urlParams['_escape']      = true;
        $urlParams['_use_rewrite'] = true;
        $urlParams['_query']       = $params;
        return Mage::helper('seosuite')->getLayerFilterUrl($urlParams);
    }

    private function _out()
    {
        if (!Mage::helper('seosuite')->isLNFriendlyUrlsEnabled()){
            return true;
        }

        if ((string)Mage::getConfig()->getModuleConfig('Amasty_Shopby')->active == 'true'){
            return true;
        }

        if(Mage::helper('seosuite')->isIndividualLNFriendlyUrlsDisable()){
            return true;
        }

        return false;
    }

}
