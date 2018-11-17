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
class MageWorx_SeoSuite_Model_Catalog_Layer_Filter_Attribute extends MageWorx_SeoSuite_Model_Catalog_Layer_Filter_Attribute_Abstract
{

    protected function _getOptionId($label)
    {
        if ($source = $this->getAttributeModel()->getSource()) {
            return $source->getOptionId($label);
        }
        return false;
    }

    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
        if($this->_out()){
            return parent::apply($request, $filterBlock);
        }

        $text = $request->getParam($this->_requestVar);
        if (is_array($text)) {
            return $this;
        }

        $filter = $this->_getOptionId($text);

        if ($filter && $text) {

            if (method_exists($this, '_getResource')) {
                $this->_getResource()->applyFilterToCollection($this, $filter);
            }
            else {
                Mage::getSingleton('catalogindex/attribute')->applyFilterToCollection(
                        $this->getLayer()->getProductCollection(), $this->getAttributeModel(), $filter
                );
            }
            $this->getLayer()->getState()->addFilter($this->_createItem($text, $filter));
            $this->_items = array();
        }
        return $this;
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
