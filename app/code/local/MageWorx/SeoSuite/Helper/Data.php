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
class MageWorx_SeoSuite_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_SEOSUITE_LN_FRIENDLY_URLS_ENABLED = 'mageworx_seo/seosuite/enable_ln_friendly_urls';
    const XML_PATH_SEOSUITE_OPTIMIZED_URLS_ENABLED   = 'mageworx_seo/seosuite/optimized_urls';
    const XML_PATH_SEOSUITE_PRODUCT_REPORT_STATUS    = 'mageworx_seo/seosuite/product_report_status';
    const XML_PATH_SEOSUITE_CATEGORY_REPORT_STATUS   = 'mageworx_seo/seosuite/category_report_status';
    const XML_PATH_SEOSUITE_CMS_REPORT_STATUS        = 'mageworx_seo/seosuite/cms_report_status';
    const XML_PATH_SEOSUITE_LNAVIGATION_IDENTIFIER   = 'mageworx_seo/seosuite/layered_identifier';
    const XML_PATH_SEOSUITE_PAGER_NUM_FOR_TITLE      = 'mageworx_seo/seosuite/pager_num_for_title';
    const XML_PATH_SEOSUITE_PAGER_DESC_FOR_TITLE     = 'mageworx_seo/seosuite/pager_num_for_description';
    const XML_PATH_ALLOW_FILTERS_CANONICAL           = 'mageworx_seo/seosuite/enable_canonical_tag_for_layered_navigation';
    const XML_PATH_USE_PRODUCT_CANONICAL_FOR_REVIEW  = 'mageworx_seo/seosuite/use_product_canonical_for_review';
    const XML_PATH_DYNAMIC_META_TITLE                = 'mageworx_seo/seosuite/status_dynamic_meta_title';
    const XML_PATH_DYNAMIC_META_DESCRIPTION          = 'mageworx_seo/seosuite/status_dynamic_meta_description';
    const XML_PATH_DYNAMIC_META_KEYWORDS             = 'mageworx_seo/seosuite/status_dynamic_meta_keywords';
    const XML_PATH_PAGE_NUM_FOR_TITLE                = 'mageworx_seo/seosuite/status_pager_num_for_title';
    const XML_PATH_PAGE_NUM_FOR_DESCRIPTION          = 'mageworx_seo/seosuite/status_pager_num_for_description';
    const XML_PATH_CUT_TITLE_PREFIX_SUFFIX           = 'mageworx_seo/seosuite/cut_title_prefix_and_suffix';
    const XML_PATH_EXTENDED_META_TITLE_FOR_LN_ENABLED       = 'mageworx_seo/seosuite/extended_category_layered_navigation_meta_title';
    const XML_PATH_EXTENDED_META_DESCRIPTION_FOR_LN_ENABLED = 'mageworx_seo/seosuite/extended_category_layered_navigation_meta_description';
    const XML_PATH_CANONICAL_ASSOCIATED_PRODUCT_ENABLED     = 'mageworx_seo/seosuite/canonical_associated_product';
    const XML_PATH_CANONICAL_FOR_CONF_PRODUCT        = 'mageworx_seo/seosuite/canonical_configurable';
    const XML_PATH_CANONICAL_FOR_BUNDLE_PRODUCT      = 'mageworx_seo/seosuite/canonical_bundle';
    const XML_PATH_CANONICAL_FOR_GROUPED_PRODUCT     = 'mageworx_seo/seosuite/canonical_grouped';

    /**
     * Admin config setting
     */
    const CATEGORY_LN_CANONICAL_OFF          = 0;
    const CATEGORY_LN_CANONICAL_USE_FILTERS  = 1;
    const CATEGORY_LN_CANONICAL_CATEGORY_URL = 2;

    /**
     * Attribut individual setting
     */
    const ATTRIBUTE_LN_CANONICAL_BY_CONFIG    = 0;
    const ATTRIBUTE_LN_CANONICAL_USE_FILTERS  = 1;
    const ATTRIBUTE_LN_CANONICAL_CATEGORY_URL = 2;

    protected $_enterpriseSince113 = null;

    public function showFullActionName()
    {
        return Mage::getStoreConfig('mageworx_seo/tools/show_action_name');
    }

    public function isEnterpriseSince113()
    {
        if (is_null($this->_enterpriseSince113)) {
            $mage = new Mage();
            if (is_callable(array($mage, 'getEdition')) && Mage::getEdition() == Mage::EDITION_ENTERPRISE
                && version_compare(Mage::getVersion(), '1.13.0.0', '>=')) {
                $this->_enterpriseSince113 = true;
            }
            else {
                $this->_enterpriseSince113 = false;
            }
        }
        return $this->_enterpriseSince113;
    }

    public function isAssociatedCanonicalEnabled($storeId)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_CANONICAL_ASSOCIATED_PRODUCT_ENABLED, $storeId);
    }

    public function getProductTypeForReplaceCanonical($storeId)
    {
        $types = array();
        switch ('use_parent'){
            case Mage::getStoreConfig(self::XML_PATH_CANONICAL_FOR_CONF_PRODUCT, $storeId):
                $types[] = Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE;
            case Mage::getStoreConfig(self::XML_PATH_CANONICAL_FOR_BUNDLE_PRODUCT, $storeId):
                $types[] = Mage_Catalog_Model_Product_Type::TYPE_BUNDLE;
            case Mage::getStoreConfig(self::XML_PATH_CANONICAL_FOR_GROUPED_PRODUCT, $storeId):
                $types[] = Mage_Catalog_Model_Product_Type::TYPE_GROUPED;
            break;
        }
        return $types;
    }

    public function isOptimizedUrlsEnabled($store = null)
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_SEOSUITE_OPTIMIZED_URLS_ENABLED, $store) && !$this->isEnterpriseSince113()) {
            return true;
        }
        return false;
    }

    public function isProductCanonicalUrlOnReviewPage()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_USE_PRODUCT_CANONICAL_FOR_REVIEW);
    }

    public function isLNFriendlyUrlsEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_SEOSUITE_LN_FRIENDLY_URLS_ENABLED);
    }

    /**
     * Disable LN Friendly URLs by conditions.
     * Used in classes:
     * MageWorx_SeoSuite_Block_Page_Html_Pager
     * MageWorx_SeoSuite_Block_Catalog_Product_List_Toolbar
     * MageWorx_SeoSuite_Model_Catalog_Layer_Filter_Item
     * MageWorx_SeoSuite_Model_Catalog_Layer_Filter_Attribute
     *
     * @return boolean
     */
    public function isIndividualLNFriendlyUrlsDisable()
    {
        return false;
    }

    public function getStatusPagerNumForMeta($metaType)
    {
        switch ($metaType) {
            case 'title':
                $ret = $this->getStatusPagerNumForMetaTitle();
                break;
            case 'description':
                $ret = $this->getStatusPagerNumForMetaDescription();
                break;
            default:
                $ret = null;
        }
        return $ret;
    }

    public function getStatusPagerNumForMetaTitle()
    {
        return (string) Mage::getStoreConfig(self::XML_PATH_PAGE_NUM_FOR_TITLE);
    }

    public function getStatusPagerNumForMetaDescription()
    {
        return (string) Mage::getStoreConfig(self::XML_PATH_PAGE_NUM_FOR_DESCRIPTION);
    }

    public function isCutPrefixSuffixFromProductAndCategoryPages()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_CUT_TITLE_PREFIX_SUFFIX);
    }

    public function getLayeredNavigationIdentifier()
    {
        $identifier = trim(Mage::getStoreConfig(self::XML_PATH_SEOSUITE_LNAVIGATION_IDENTIFIER));
        $identifier = strtolower(trim($identifier, '/'));
        if (preg_match('/^[a-z]+$/', $identifier)) {
            return $identifier;
        }
        return 'l';
    }

    /**
     * @param type $type
     * @return string
     */
    public function getStatusDynamicMetaType($metaType)
    {
        switch ($metaType) {
            case 'title':
                $ret = $this->getStatusDynamicMetaTitle();
                break;
            case 'description':
                $ret = $this->getStatusDynamicMetaDescription();
                break;
            case 'keywords':
                $ret = $this->getStatusDynamicMetaKeywords();
                break;
            default: $ret = null;
        }
        return $ret;
    }

    public function getStatusDynamicMetaTitle()
    {
        return ((string) Mage::getStoreConfig(self::XML_PATH_DYNAMIC_META_TITLE));
    }

    public function getStatusDynamicMetaDescription()
    {
        return ((string) Mage::getStoreConfig(self::XML_PATH_DYNAMIC_META_DESCRIPTION));
    }

    public function getStatusDynamicMetaKeywords()
    {
        return ((string) Mage::getStoreConfig(self::XML_PATH_DYNAMIC_META_KEYWORDS));
    }

    public function isPagerNumForMetaEnabled($type)
    {
        return ((string) Mage::getStoreConfig(self::XML_PATH_DYNAMIC_META_KEYWORDS));
    }

    public function isProductPage($fullActionName)
    {
        $product = Mage::registry('current_product');
        if (is_object($product) && $product->getId()) {

            $productActions = array(
                'catalog_product_view',
                'review_product_list',
                'review_product_view',
                'productquestions_show_index',
            );

            if (in_array($fullActionName, $productActions)) {
                return true;
            }
        }
        return false;
    }

    public function isCategoryPage($fullActionName)
    {
        $category = Mage::registry('current_category');
        if (is_object($category) && $category->getId()) {

            $categoryActions = array(
                'catalog_category_view',
            );

            if (in_array($fullActionName, $categoryActions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determines by global value from a config and to value (based on attributes setting and position)
     * existence of filters in canonical url.
     *
     * @return boolean
     */
    public function isIncludeLNFiltersToCanonicalUrl()
    {
        $enableByConfig  = $this->isIncludeLNFiltersToCanonicalUrlByConfig();
        $answerByFilters = $this->isIncludeLNFiltersToCanonicalUrlByFilters();

        if ($enableByConfig == self::CATEGORY_LN_CANONICAL_USE_FILTERS && $answerByFilters == self::ATTRIBUTE_LN_CANONICAL_CATEGORY_URL) {
            return false;
        }

        if ($enableByConfig == self::CATEGORY_LN_CANONICAL_CATEGORY_URL && $answerByFilters == self::ATTRIBUTE_LN_CANONICAL_USE_FILTERS) {
            return true;
        }
        if ($enableByConfig == self::CATEGORY_LN_CANONICAL_USE_FILTERS) {
            return true;
        }
        return false;
    }

    public function isIncludeLNFiltersToCanonicalUrlByConfig()
    {
        return (int) Mage::getStoreConfig(self::XML_PATH_ALLOW_FILTERS_CANONICAL);
    }

    public function isIncludeLNFiltersToCanonicalUrlByFilters()
    {
        $filtersData = $this->getLayeredNavigationFiltersData();

        if (!$filtersData) {
            return 'default';
        }
        usort($filtersData, array($this, "_cmp"));
        foreach ($filtersData as $data) {
            if (!empty($data['use_in_canonical'])) {
                return $data['use_in_canonical'];
            }
        }
        return false;
    }

    protected function _cmp($a, $b)
    {
        $a['position'] = (empty($a['position'])) ? 0 : $a['position'];
        $b['position'] = (empty($b['position'])) ? 0 : $b['position'];

        if ($a['position'] == $b['position']) {
            return 0;
        }
        return ($a['position'] < $b['position']) ? +1 : -1;
    }

    /**
     * @return bool
     */
    public function applyedLayeredNavigationFilters()
    {
        $appliedFilters = Mage::getSingleton('catalog/layer')->getState()->getFilters();
        return (is_array($appliedFilters) && count($appliedFilters) > 0) ? true : false;
    }

    /**
     * Retrive specific filters data as array (use for canonical url)
     * @return array | false
     */
    public function getLayeredNavigationFiltersData()
    {
        $filterData     = array();
        $appliedFilters = Mage::getSingleton('catalog/layer')->getState()->getFilters();
//        echo "<pre>";
//        print_r($appliedFilters);
//        echo "</pre>";
//        exit();

        if (is_array($appliedFilters) && count($appliedFilters) > 0) {
            foreach ($appliedFilters as $item) {


                if (is_null($item->getFilter()->getData('attribute_model'))) {
                    //Ex: If $item->getFilter()->getRequestVar() == 'cat'
                    $use_in_canonical = 0;
                    $position         = 0;
                }
                else {
                    $use_in_canonical = $item->getFilter()->getAttributeModel()->getLayeredNavigationCanonical();
                    $position         = $item->getFilter()->getAttributeModel()->getPosition();
                }

                $filterData[] = array(
                    'name'             => $item->getName(),
                    'label'            => $item->getLabel(),
                    'code'             => $item->getFilter()->getRequestVar(),
                    'use_in_canonical' => $use_in_canonical,
                    'position'         => $position
                );
            }
        }
        return (count($filterData) > 0) ? $filterData : false;
    }

    public function useSpecificPortInCanonical()
    {
        return Mage::getStoreConfigFlag('mageworx_seo/seosuite/add_canonical_url_port');
    }

    public function isDirectCategoryUrl($url)
    {
        return (strpos($url, 'catalog/category/view/id') !== false) ? true : false;
    }

    public function isCanonicalUrlEnabled($storeId = null)
    {
        return Mage::getStoreConfigFlag('mageworx_seo/seosuite/enabled', $storeId);
    }

    public function getProductCanonicalType($storeId = null)
    {
        if(!$this->useCategoriesPathInProductUrl($storeId)){
            return 3;
        }
        return Mage::getStoreConfig('mageworx_seo/seosuite/product_canonical_url', $storeId);
    }

    public function getTrailingSlashAction($storeId = null)
    {
        return Mage::getStoreConfig('mageworx_seo/seosuite/trailing_slash', $storeId);
    }

    public function trailingSlash($url)
    {
        $trailingSlash = $this->getTrailingSlashAction();

        if ($trailingSlash == 'add') {
            $url        = rtrim($url);
            $extensions = array('rss', 'html', 'htm', 'xml', 'php');
            if (substr($url, -1) != '/' && !in_array(substr(strrchr($url, '.'), 1), $extensions)) {
                $url.= '/';
            }
        }
        elseif ($trailingSlash == 'crop') {
            $url = rtrim(rtrim($url), '/');
        }
        elseif ($trailingSlash == 'default') {

        }
        else {

        }

        return $url;
    }

    public function getRssGenerator()
    {
        return base64_decode('TWFnZVdvcnggU0VPIFN1aXRlIChodHRwOi8vd3d3Lm1hZ2V3b3J4LmNvbS8p');
    }

    public function getAttributeValueDelimiter()
    {
        $delimeter = trim(Mage::getStoreConfig('mageworx_seo/seosuite/layered_separatort'));
        return $delimeter ? $delimeter : ':';
    }

    public function getAttributeParamDelimiter()
    {
        return Mage::getStoreConfigFlag('mageworx_seo/seosuite/layered_hide_attributes') ? '/' : $this->getAttributeValueDelimiter();
    }

    public function getPagerUrlFormat()
    {
        if ($this->isLNFriendlyUrlsEnabled()) {
            $pagerUrlFormat = trim(Mage::getStoreConfig('mageworx_seo/seosuite/pager_url_format'));
            if (strpos($pagerUrlFormat, '[page_number]') !== false) {
                return $pagerUrlFormat;
            }
        }
        return false;
    }

    /**
     * Add Link Rel="next/prev"
     * 0 : No
     * 1 : Yes
     * 2 : Yes, excepting pages with layered navigation
     * @return int
     */
    public function getStatusLinkRel()
    {
        return (int) Mage::getStoreConfig('mageworx_seo/seosuite/enable_link_rel');
    }

    public function _getFilterableAttributes($catId = false)
    {
        if (!is_null(Mage::registry('_layer_filterable_attributes'))) {
            return Mage::registry('_layer_filterable_attributes');
        }
        $attr = array();

        $layerModel = Mage::getModel('catalog/layer');
        if ($catId) {
            $layerModel->setCurrentCategory($catId);
        }
        $attributes = $layerModel->getFilterableAttributes();

        foreach ($attributes as $attribute) {
            $attr[$attribute->getAttributeCode()]['type'] = $attribute->getBackendType();
            $options                                      = $attribute->getSource()->getAllOptions();
            foreach ($options as $option) {
                $attr[$attribute->getAttributeCode()]['options'][$this->formatUrlKey($option['label'])] = $option['label'];
                $attr[$attribute->getAttributeCode()]['frontend_label']                                = $attribute->getFrontendLabel();
            }
        }
        Mage::register('_layer_filterable_attributes', $attr);
        return $attr;
    }

    public function getLayerFilterUrl($params)
    {
        if (!$this->isLNFriendlyUrlsEnabled()) {
            return Mage::getUrl('*/*/*', $params);
        }

        ///MageWorx Friendly layered OFF On search pages
        $fullActionName =
            Mage::app()->getRequest()->getRouteName() . '_' .
            Mage::app()->getRequest()->getControllerName() . '_' .
            Mage::app()->getRequest()->getActionName();

        if (in_array($fullActionName,
                array('catalogsearch_result_index', 'catalogsearch_advanced_index', 'catalogsearch_advanced_result'))) {
            return Mage::getUrl('*/*/*', $params);
        }
        ///

        $hideAttributes = Mage::getStoreConfigFlag('mageworx_seo/seosuite/layered_hide_attributes');
        $urlModel       = Mage::getModel('core/url');
        $queryParams    = $urlModel->getRequest()->getQuery();

        if (isset($queryParams['price']) && is_array($queryParams['price'])) {
            $queryParams['price'] = join(' ', $queryParams['price']);
        }
        if (isset($queryParams['price']) && strpos($queryParams['price'], '-') !== false) {
            $multipliers          = explode('-', $queryParams['price']);
            $priceFrom            = floatval($multipliers[0]);
//            $priceTo              = (!$multipliers[1] ? '' : floatval($multipliers[1]) - 0.01);
            $priceTo              = (!$multipliers[1] ? '' : floatval($multipliers[1]));
            $queryParams['price'] = $priceFrom . '-' . $priceTo;
        }

        foreach ($params['_query'] as $param => $value) {
            $queryParams[$param] = $value;
        }
        $queryParams = array_filter($queryParams);
        //$attr = Mage::registry('_layer_filterable_attributes');
        $attr        = $this->_getFilterableAttributes();

        $layerParams = array();
        foreach ($queryParams as $param => $value) {
            if ($param == 'cat' || isset($attr[$param])) {
                switch ($hideAttributes) {
                    case true:
                        $layerParams[$param == 'cat' ? 0 : $param] = ($param == 'cat' ? $this->formatUrlKey($value) : ($attr[$param]['type']
                                == 'decimal' ? $this->formatUrlKey($param) . $this->getAttributeValueDelimiter() . $value
                                        : $this->formatUrlKey($value)));
                        break;
                    default:
                        $layerParams[$param == 'cat' ? 0 : $param] = ($param == 'cat' ? $this->formatUrlKey($value) : $this->formatUrlKey($param) . $this->getAttributeValueDelimiter() . ($attr[$param]['type']
                                == 'decimal' ? $value : $this->formatUrlKey($value)));
                        break;
                }
                $params['_query'][$param] = null;
            }
        }
        $layer = null;
        if (!empty($layerParams)) {
            uksort($layerParams, 'strcmp');
            $layer = implode('/', $layerParams);
        }
        $url = Mage::getUrl('*/*/*', $params);
        if (!$layer) {
            return $url;
        }

        $urlParts = explode('?', $url, 2);
        $suffix   = Mage::getStoreConfig('catalog/seo/category_url_suffix');

        ///MageWorx fix
        if (strlen($suffix) > 1 and strpos($suffix, '.') === false) {
            $suffix = '.' . $suffix;
        }
        ///MageWorx fix end

        if ($suffix && substr($urlParts[0], -(strlen($suffix))) == $suffix) {
            $url = substr($urlParts[0], 0, -(strlen($suffix)));
        }
        else {
            $url = $urlParts[0];
        }

        $navIdentifier = $this->getLayeredNavigationIdentifier();
        return $url . '/' . $navIdentifier . '/' . $layer . $suffix . (isset($urlParts[1]) ? '?' . $urlParts[1] : '');
    }

    private function _sortUrlRewriteColletion($collection)
    {
        $list = array();
        foreach ($collection as $item) {
            $count = count(array_filter(explode('/', $item->getRequestPath())));
            if (!isset($list[$count])) {
                $list[$count] = array();
            }
            $list[$count][strlen($item->getRequestPath())] = $item->getRequestPath();
            ksort($list[$count]);
        }
        if (isset($list[1])) {
            unset($list[1]);
        }
        ksort($list);
        return $list;
    }

     public function getUrlRewriteCanonical($product) {

        $canonicalUrl = '';

        $productCanonicalUrl = $this->getProductCanonicalType();

        $collection = Mage::getResourceModel('seosuite/core_url_rewrite_collection')
                ->filterAllByProductId($product->getId(), $productCanonicalUrl)
                ->addStoreFilter(Mage::app()->getStore()->getId(), false);

        $urlRewrite = $collection->getFirstItem();
        if ($urlRewrite && $urlRewrite->getRequestPath()) {
                switch($productCanonicalUrl) {
                    case "1": //Use Longest by url
                    case "2": //Use Shortest  by url
                        $canonicalUrl = $urlRewrite->getRequestPath();
                        break;
                    case "3": // use root
                        foreach($collection as $urlRewrite){
                            if(empty($urlRewrite['category_id']) && $urlRewrite->getRequestPath()){
                                $canonicalUrl = $urlRewrite['request_path'];
                            }
                        }
                        break;
                    case "4": //Use Longest by category
                        $list = $this->_sortUrlRewriteColletion($collection);
                        $maxItem = array_pop($list);
                        if(is_array($maxItem)) {
                            $canonicalUrl = array_pop($maxItem);
                        } else {
                            $canonicalUrl = $maxItem;
                        }
                        break;
                    case "5": //Use Shortest by category
                        $list = $this->_sortUrlRewriteColletion($collection);
                        $minItem = array_shift($list);
                        if(is_array($minItem)) {
                            $canonicalUrl = array_shift($minItem);
                        } else {
                            $canonicalUrl = $minItem;
                        }
                        break;

                }
                $canonicalUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK) . $canonicalUrl;
                $canonicalUrl = trim($canonicalUrl, '/');
        }
        return $canonicalUrl;
    }

    public function getCanonicalUrl($product)
    {
        if (!Mage::getStoreConfig('mageworx_seo/seosuite/enabled')) {
            return;
        }
        $canonicalUrl        = null;
        $productCanonicalUrl = Mage::getStoreConfig('mageworx_seo/seosuite/product_canonical_url');

        $productActions = array(
            'catalog_product_view',
            'review_product_list',
            'review_product_view',
            'productquestions_show_index',
        );

        $useCategories = Mage::getStoreConfigFlag('catalog/seo/product_use_categories');

        $canonicalUrl = $product->getCanonicalUrl();
        $canonicalUrl = trim($canonicalUrl, '/');

        if ($canonicalUrl) {
            $urlRewrite   = Mage::getModel('core/url_rewrite')->setStoreId(Mage::app()->getStore()->getId())->loadByIdPath($canonicalUrl);
            $canonicalUrl = Mage::getUrl('') . $urlRewrite->getRequestPath();
        }
        else {
            $canonicalUrl = $this->getUrlRewriteCanonical($product);

            if (!$canonicalUrl) {
                $canonicalUrl = $product->getProductUrl('mw_false');        # fix recursion
                if (!$canonicalUrl || $productCanonicalUrl == 0) {
                    $product->setDoNotUseCategoryId(!$useCategories);
                    $canonicalUrl = $product->getProductUrl('mw_false'); # fix recursion
                }
            }
        }
        $canonicalUrl = trim($canonicalUrl, '/');
        if ($canonicalUrl) {
            $canonicalUrl = $this->trailingSlash($canonicalUrl);
        }

        // apply crossDomainUrl
        $crossDomainStore = false;
        if ($product->getCanonicalCrossDomain()) {
            $crossDomainStore = $product->getCanonicalCrossDomain();
        }
        elseif (Mage::getStoreConfig('mageworx_seo/seosuite/cross_domain')) {
            $crossDomainStore = Mage::getStoreConfig('mageworx_seo/seosuite/cross_domain');
        }

        if ($crossDomainStore) {
            $url          = Mage::app()->getStore($crossDomainStore)->getBaseUrl();
            $canonicalUrl = str_replace(Mage::getUrl(), $url, $canonicalUrl);
        }
        return $canonicalUrl;
    }

    public function isExtendedMetaTitleForLNEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_EXTENDED_META_TITLE_FOR_LN_ENABLED);
    }

    public function isExtendedMetaDescriptionForLNEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_EXTENDED_META_DESCRIPTION_FOR_LN_ENABLED);
    }

    public function formatUrlKey($str)
    {
        $str    = str_ireplace('�', 'a', $str);
        $urlKey = preg_replace('#[^0-9a-z]+#i', '-', Mage::helper('catalog/product_url')->format($str));
        $urlKey = strtolower($urlKey);
        $urlKey = trim($urlKey, '-');
        return $urlKey;
    }

    public function isCompoundProductType($typeId)
    {
        switch($typeId){
            case (Mage_Catalog_Model_Product_Type::TYPE_BUNDLE):
                $ret = true;
                break;
            case (Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE):
                $ret = true;
                break;
            case (Mage_Catalog_Model_Product_Type::TYPE_GROUPED):
                $ret = true;
                break;
            case (Mage_Catalog_Model_Product_Type::TYPE_SIMPLE):
                $ret = false;
                break;
            case (Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL):
                $ret = false;
                break;
        }

        return (isset($ret)) ? $ret : null;
    }

    public function getLastCompoundProductByChildProductId($id)
    {
        $ids = $this->getParentProductIds($id);
        $productTypes = $this->getProductTypeForReplaceCanonical(Mage::app()->getStore()->getStoreId());

        if(count($ids) && count($productTypes)){
            $visibilityStatuses = array(
                Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG,
                Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_SEARCH
            );

            $collection = Mage::getModel('catalog/product')->getCollection()
                ->addIdFilter($ids)
                ->addStoreFilter()
                ->addAttributeToFilter('status', array('eq' => 1))
                ->addFieldToFilter('visibility', array('in' => $visibilityStatuses))
                ->addAttributeToFilter('type_id', array('in' => $productTypes))
                ->setOrder('entity_id', 'DESC');

            if($collection->count()){
                $product = $collection->getFirstItem();
                return $product;
            }
        }
        return null;
    }

   /**
    * @todo replace to model
    */
    public function getParentProductIds($id)
    {
        $coreResource = Mage::getSingleton('core/resource');
        $conn = $coreResource->getConnection('core_read');
        $select = $conn->select()
            ->from($coreResource->getTableName('catalog/product_relation'), array('parent_id'))
            ->where('child_id = ?', $id);

        return $conn->fetchCol($select);
    }

    public function useCategoriesPathInProductUrl($store = null)
    {
        return Mage::getStoreConfigFlag('catalog/seo/product_use_categories', $store);
    }
}