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
class MageWorx_SeoSuite_Model_Catalog_Layer_Filter_Item extends MageWorx_SeoSuite_Model_Catalog_Layer_Filter_Item_Abstract
{

    public function getUrl()
    {
        if($this->_out()){
            return parent::getUrl();
        }

        if ($this->getFilter() instanceof Mage_Catalog_Model_Layer_Filter_Category) {

            $category = Mage::getModel('catalog/category')->setId($this->getValue());
            $query = array(
                Mage::getBlockSingleton('page/html_pager')->getPageVarName() => null // exclude current page from urls
            );

            $suffix  = Mage::getStoreConfig('catalog/seo/category_url_suffix');

            /*
             * Fix suffix - break layer navigation category url
             */
            if($suffix == "/"){
                $suffix = '';
            }
            if($suffix && strpos($suffix, '.') === false){
                $suffix = '.' . $suffix;
            }

            /*
             * end fix
             */

            if(strlen($suffix) > 0 && strpos($suffix, '.') === false){
                $suffix = $suffix . '.';
            }

            $catpart = $category->getUrl();
            $catpart = ($suffix && substr($catpart, -(strlen($suffix))) == $suffix ? substr($catpart, 0,
                                    -(strlen($suffix))) : $catpart);

            if($this->_isCategoryAnchor($this->getValue())){
                $layeredNavIdentifier = Mage::helper('seosuite')->getLayeredNavigationIdentifier();

                if (preg_match("/\/$layeredNavIdentifier\/.+/", Mage::app()->getRequest()->getOriginalPathInfo(), $matches)) {
                    $layeredpart = ($suffix && substr($matches[0], -(strlen($suffix))) == $suffix ? substr($matches[0], 0,
                                            -(strlen($suffix))) : $matches[0]);
                }
                else {
                    $layeredpart = '';
                }
            }else{
                $layeredpart = '';
            }

            $catpart     = str_replace('?___SID=U', '', $catpart);
            $catpart     = trim($catpart);
            $layeredpart = trim($layeredpart);
            $catpart     = str_replace($suffix, '', $catpart);
            $url         = $catpart . $layeredpart . $suffix;

            /**
             * Fix double slash in category urls (layer navigation)
             */
            $url = str_replace("//", "/", $url);
            if(strpos($url, 'http:/') !== false){
                $url = str_replace("http:/", "http://", $url);
            }elseif(strpos($url, 'https:/') !== false){
                $url = str_replace("https:/", "https://", $url);
            }
            /*
             * end fix
             */

            return $url;
        }
        else {
            $var     = $this->getFilter()->getRequestVar();
            $request = Mage::app()->getRequest();

            $labelValue = strpos($request->getRequestUri(), 'catalogsearch') !== false ? $this->getValue() : $this->getLabel();

            $attribute = $this->getFilter()->getData('attribute_model'); //->getAttributeCode()

            if ($attribute) {
                if ($attribute->getAttributeCode() == 'price' || $attribute->getBackendType() == 'decimal') {
                    $value = $this->getValue();
                }
                else {
                    $value = $labelValue;
                }
            }
            else {
                $value = $labelValue;
            }
            $query = array(
                $var => $value,
                Mage::getBlockSingleton('page/html_pager')->getPageVarName() => null // exclude current page from urls
            );
            return Mage::helper('seosuite')->getLayerFilterUrl(array('_current'     => true,
                        '_use_rewrite' => true,
                        '_query'       => $query
            ));
        }
    }

    public function getRemoveUrl()
    {
        if($this->_out()){
            return parent::getRemoveUrl();
        }

        $query                  = array($this->getFilter()->getRequestVar() => $this->getFilter()->getResetValue());
        $params['_current']     = true;
        $params['_use_rewrite'] = true;
        $params['_query']       = $query;
        $params['_escape']      = true;
        return Mage::helper('seosuite')->getLayerFilterUrl($params);
    }

    /**
     * @TODO  Optimize: use collection from block.
     * @param int $id
     * @return bool
     */
    private function _isCategoryAnchor($id)
    {
        if(is_object(Mage::registry('current_category')) && !is_array(Mage::registry('mageworx_category_anchor'))){

            $collection = Mage::registry('current_category')->getChildrenCategories();

            if(is_object($collection) && is_callable(array($collection, 'toArray'))){
                $data = $collection->toArray();
                if(is_array($data) && count($data) > 0){
                    Mage::register('mageworx_category_anchor', $data);
                }
            }
        }

        $catData = Mage::registry('mageworx_category_anchor');
        if(is_array($catData) && !empty($catData[$id])){
            return !empty($catData[$id]['is_anchor']);
        }
        return false;
    }

    protected function _out()
    {
        if (!Mage::helper('seosuite')->isLNFriendlyUrlsEnabled()){
            return true;
        }

        if ((string)Mage::getConfig()->getModuleConfig('Amasty_Shopby')->active == 'true'){
            return true;
        }

        $request = Mage::app()->getRequest();
        if ($request->getModuleName() == 'catalogsearch') {
            return true;
        }

        if(Mage::helper('seosuite')->isIndividualLNFriendlyUrlsDisable()){
            return true;
        }

        return false;
    }
}