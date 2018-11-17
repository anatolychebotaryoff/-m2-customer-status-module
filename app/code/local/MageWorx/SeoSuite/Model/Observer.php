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
class MageWorx_SeoSuite_Model_Observer
{
    public function adminhtmlInitSystemConfig($observer)
    {
        if(Mage::app()->getRequest()->getParam('section') == 'mageworx_seo'){
            $this->_transferUrlSetting();
        }
    }

    public function coreConfigDataSaveBefore(Varien_Event_Observer $observer)
    {
        $config = $observer->getEvent()->getConfigData();

        if($config && $config->getPath() == 'mageworx_seo/seosuite/product_use_categories'){

            $mageConfig = Mage::getModel('core/config_data')->getCollection()
                ->addFieldToFilter('scope', $config->getScope())
                ->addFieldToFilter('scope_id', $config->getScopeId())
                ->addFieldToFilter('path', 'catalog/seo/product_use_categories')
                ->getFirstItem();

            $mageConfig
                ->setScope($config->getScope())
                ->setScopeId($config->getScopeId())
                ->setPath('catalog/seo/product_use_categories')
                ->setValue($config->getValue())
                ->setFlag('save_from_observer')
                ->save();

            $message = Mage::helper('seosuite')->__('You\'ve changed the setting "Use Categories Path for Product URLs".
                Please, pay attention that the dependent setting "SEO Suite -> Add Canonical URL Meta Header -> Product Canonical URL"
                could change as well.');

            Mage::getSingleton('adminhtml/session')->addNotice($message);
        }
        elseif($config && $config->getPath() == 'catalog/seo/product_use_categories' && !$config->hasFlag('save_from_observer')){

            $mageworxConfig = Mage::getModel('core/config_data')->getCollection()
                ->addFieldToFilter('scope', $config->getScope())
                ->addFieldToFilter('scope_id', $config->getScopeId())
                ->addFieldToFilter('path', 'mageworx_seo/seosuite/product_use_categories')
                ->getFirstItem();

            $mageworxConfig
                ->setScope($config->getScope())
                ->setScopeId($config->getScopeId())
                ->setPath('mageworx_seo/seosuite/product_use_categories')
                ->setValue($config->getValue())
                ->setFlag('save_from_observer')
                ->save();
        }
    }

    public function prepareAttributeEditForm($observer)
    {
        $helper = Mage::helper('seosuite');
        $form   = $observer->getEvent()->getForm();

        $fieldset = $form->getElements()->searchById('front_fieldset');
        if (!is_null($fieldset)) {
            $fieldset->addField('layered_navigation_canonical', 'select',
                    array(
                'name'   => 'layered_navigation_canonical',
                'label'  => $helper->__('Canonical Tag for Pages Filtered by Layered Navigation Leads to'),
                'title'  => $helper->__('Canonical Tag for Pages Filtered by Layered Navigation Leads to'),
                'values' => Mage::getModel('seosuite/system_config_source_layer_canonical')->toOptionArray(),
                    ), 'is_filterable_in_search');
        }
        return $this;
    }

    public function setMetaDescription(Varien_Event_Observer $observer)
    {
        $shortDescription = trim($observer->getEvent()->getProduct()->getShortDescription());
        if (Mage::getStoreConfigFlag('mageworx_seo/seosuite/product_meta_description') && !empty($shortDescription)) {
            Mage::getSingleton('catalog/session')->setData('seosuite_meta_description', strip_tags($shortDescription));
        }
    }

    public function registerProductId(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        Mage::unregister('seosuite_product_id');
        if ($product) Mage::register('seosuite_product_id', $product->getId());
    }

    public function redirectHome(Varien_Event_Observer $observer)
    {
        $front   = $observer->getEvent()->getFront();
        $origUri = $front->getRequest()->getRequestUri();
        $origUri = explode('?', $origUri, 2);
        $uri     = preg_replace('~(?:index\.php/+home/*|index\.php/*|(/)+home/*)$~i', '', $origUri[0]);
        // echo "<pre>"; print_r($origUri);
        //if ($uri=='/') return ; // fix Vladimir Z.
        if (strpos($origUri[0], '/downloader/index.php') !== false) {
            return;
        }
        if ($uri == $origUri[0]) {
            return;
        }
        $uri = rtrim($uri, '/') . '/';
        $uri .= ( (isset($origUri[1]) && $origUri[1] !== "___SID=U") ? '?' . $origUri[1] : '');
        $front->getResponse()
                ->setRedirect($uri)
                ->setHttpResponseCode(301)
                ->sendResponse();
        exit;
    }

    public function productSaveAfter(Varien_Event_Observer $observer)
    {
        if (Mage::helper('seosuite/report')->getProductReportStatus()) Mage::helper('seosuite/report')->setProductReportStatus(0);
    }

    public function categorySaveAfter(Varien_Event_Observer $observer)
    {
        if (Mage::helper('seosuite/report')->getCategoryReportStatus()) Mage::helper('seosuite/report')->setCategoryReportStatus(0);
    }

    public function cmsPageSaveAfter(Varien_Event_Observer $observer)
    {
        if (Mage::helper('seosuite/report')->getCmsReportStatus()) Mage::helper('seosuite/report')->setCmsReportStatus(0);
    }

    public function addJsToAttribute(Varien_Event_Observer $observer)
    {
        $form      = $observer->getEvent()->getForm();
        $eventElem = $form->getElement('canonical_url');
        $html      = "<div style='padding-top:5px;'>
                    <input type='text' value='' style='display:none; width:275px' name='canonical_url_custom' id='canonical_url_custom'>
                </div>\n
            <script type='text/javascript'>
            function listenCU() {
                if($('canonical_url').value=='custom') {
                    $('canonical_url_custom').show();
                }
                else {
                    $('canonical_url_custom').hide();
                }
           }
           $('canonical_url').observe('change',listenCU);
                </script>";
        if ($eventElem) {
            $eventElem->setAfterElementHtml($html);
        }
    }

    public function toHtmlBlockFrontAfter($observer)
    {
        if(Mage::app()->getFrontController()->getAction()->getFullActionName() == 'catalog_product_view'){
            Mage::getModel('seosuite/richsnippet_observer')->createRichsnippet($observer);
        }
        else{
            $this->addNextPrev($observer);
        }

        $actionName = Mage::app()->getFrontController()->getAction()->getFullActionName();

        if(Mage::helper('seosuite')->showFullActionName() == 'source_code'){
            $this->showFullActionNameInSourceCode($observer);
        }
    }

    public function showFullActionNameInSourceCode($observer)
    {
        $block = $observer->getBlock();

        if($block->getNameInLayout() == 'root'){

            $output = $observer->getTransport()->getHtml();
            $controller = Mage::app()->getFrontController();
            if($controller && is_callable(array($controller, 'getAction'))){
                $action = $controller->getAction();
                if($action && is_callable(array($action, 'getFullActionName'))){
                    $actionName = $action->getFullActionName();
                }
            }

            $actionName = empty($actionName) ? null : $actionName;

            if($actionName){
                $comment = "<!--MageWorx_SeoSuite: ACTION NAME IS '" . $actionName ."'-->";
                $output = str_replace('</head>', $comment . "\n" . '</head>', $output);
            }

            $observer->getTransport()->setHtml($output);
        }
    }

    public function addNextPrev($observer)
    {
        if (!Mage::helper('seosuite')->getStatusLinkRel()) {
            return false;
        }

        $block = $observer->getBlock();

        if($block->getNameInLayout() == 'root'){

            $output = $observer->getTransport()->getHtml();

            $actionName = Mage::app()->getFrontController()->getAction()->getFullActionName();

            // Category Page + Layer
            if ($actionName == 'catalog_category_view') {

                //If disable next/prev on layered navigation
                if (Mage::helper('seosuite')->getStatusLinkRel() == 2 && Mage::helper('seosuite')->applyedLayeredNavigationFilters()) {
                    return false;
                }

                //Disable next/prev on category without product, if is not layered navigation now.
                if (is_object(Mage::registry('current_category')) &&
                    Mage::registry('current_category')->getDisplayMode() == 'PAGE' &&
                    !Mage::helper('seosuite')->applyedLayeredNavigationFilters())
                {
                    return false;
                }


                $pager = Mage::app()->getLayout()->getBlock('product_list_toolbar_pager');

                if(!is_object($pager) || !$pager->getCollection()){
                    $toolbar = Mage::app()->getLayout()->getBlock('product_list_toolbar');
                    if(is_object($toolbar)){
                        $pager = $toolbar->getChild('product_list_toolbar_pager');
                    }
                }
            }
            //Search
            elseif ($actionName == 'catalogsearch_result_index') {
                $pager = Mage::app()->getLayout()->getBlock('product_list_toolbar_pager');
            }
            // Reviews
            elseif ($actionName == 'review_product_list') {
                $pager = Mage::app()->getLayout()->getBlock('product_review_list.toolbar');
            }
            // Tags
            elseif ($actionName == 'tag_product_list') {
                $pager = Mage::app()->getLayout()->getBlock('product_list_toolbar_pager');
            }

            if(!empty($pager) && is_object($pager) && is_object($pager->getCollection())){
                if($this->_nextPrevOut($pager)){
                    return false;
                }
                if ($pager->getCollection()->getSelectCountSql()) {
                    if ($pager->getLastPageNum() > 1) {
                        if (!$pager->isFirstPage()) {
                            $linkPrev = true;
                            if ($pager->getCurrentPage() == 2) {
                                // remove p=1
                                $prevUrl = str_replace(array('?p=1&amp;', '?p=1&', '&amp;p=1&amp;', '&p=1&'),
                                    array('?', '?', '&amp;', '&'), $pager->getPreviousPageUrl());
                                if (substr($prevUrl, -4) == '?p=1') {
                                    $prevUrl = substr($prevUrl, 0, -4);
                                    $prevUrl = Mage::helper('seosuite')->trailingSlash($prevUrl);
                                }
                                elseif (substr($prevUrl, -8) == '&amp;p=1') {
                                    $prevUrl = substr($prevUrl, 0, -8);
                                }
                                elseif (substr($prevUrl, -4) == '&p=1') {
                                    $prevUrl = substr($prevUrl, 0, -4);
                                }
                            }
                            else {
                                $prevUrl = $pager->getPreviousPageUrl();
                            }
                        }
                        if (!$pager->isLastPage()) {
                            $linkNext = true;
                            $nextUrl  = $pager->getNextPageUrl();
                        }
                    }
                }

                if($output && (!empty($linkPrev) || !empty($linkNext))){

                    $output = str_replace('</head>', "\n" . '<!--MageWorx_SeoSuite Next/Prev section begin-->' . '</head>', $output);

                    if(!empty($linkPrev)){
                        if(!empty($prevUrl)){
                            $prevStr = '<link rel="prev" href="' . $prevUrl . '" />';
                            $output = str_replace('</head>', "\n" . $prevStr . '</head>', $output);
                        }
                    }

                    if(!empty($linkNext)){
                        if(!empty($nextUrl)){
                            $nextStr = '<link rel="next" href="' . $nextUrl . '" /> ';
                            $output = str_replace('</head>', "\n" . $nextStr . '</head>', $output);
                        }
                    }

                    $output = str_replace('</head>', "\n" . '<!--MageWorx_SeoSuite Next/Prev section end-->' . '</head>', $output);
                    $output = str_replace('</head>', "\n" . '</head>', $output);

                    $observer->getTransport()->setHtml($output);
                }
            }
        }
    }

    protected function _nextPrevOut($pager)
    {
        $availableLimit = $pager->getAvailableLimit();

        if (!is_array($availableLimit)) {
            return true;
        }

        if (is_array($availableLimit) && !empty($availableLimit['all'])) {
            return true;
        }
    }

}