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
class MageWorx_SeoSuite_Block_Page_Html_Head extends MageWorx_SeoSuite_Block_Page_Html_Head_Abstract
{
    /**
     * Crop params from baseUrl (as SID) in case of compilation canonical url.
     */
    const CROP_URL_PARAMS = true;

    protected $_helper;

    public function __construct()
    {
        $this->_helper = Mage::helper('seosuite');
        return parent::__construct();
    }

    public function getContentType()
    {
        $this->_data['content_type'] = $this->getMediaType() . '; charset=' . $this->getCharset();
        return $this->_data['content_type'];
    }

    public function getCssJsHtml()
    {
        $canonicalUrl = $this->getCanonicalUrl();

        $nextPrev = $this->getNextPrev();
        $og       = $this->getOpenGraphProtocolData($canonicalUrl);

        if (method_exists($this, 'addLinkRel')) {
           if ($nextPrev) {
                if (!empty($nextPrev['prev'])) {
                    $this->addLinkRel('prev', $nextPrev['prev']);
                }
                if (!empty($nextPrev['next'])) {
                    $this->addLinkRel('next', $nextPrev['next']);
                }
            } else if ($canonicalUrl) {
            }
 
        }
        else {
            $html = parent::getCssJsHtml();
            if ($nextPrev) {
                if (!empty($nextPrev['prev'])) {
                    $html = '<link rel="prev" href="' . $nextPrev['prev'] . '" />' . "\n" . $html;
                }
                if (!empty($nextPrev['next'])) {
                    $html = '<link rel="next" href="' . $nextPrev['next'] . '" />' . "\n" . $html;
                }
            } else if ($canonicalUrl) {
            }

        }

        $html = !empty($html) ? $html : parent::getCssJsHtml();
        $html = ($og) ? $og . $html : $html;

        return $html;
    }


    public function getCanonicalUrl()
    {
        if (Mage::registry('amshopby_current_params')) {
            return;
        }

        if (!Mage::getStoreConfig('mageworx_seo/seosuite/enabled')) {
            return;
        }

        if (Mage::app()->getRequest()->getRequestedActionName() == 'noRoute') {
            return;
        }

        /** Ignore pages section * */
        $ignorePages = array_filter(preg_split('/\r?\n/', Mage::getStoreConfig('mageworx_seo/seosuite/ignore_pages')));
        $ignorePages = array_map('trim', $ignorePages);

        if (in_array($this->getAction()->getFullActionName(), $ignorePages)) {
            return;
        }

        if ($this->_helper->isProductPage($this->getAction()->getFullActionName())) {
            $canonicalUrl = $this->getCanonicalProductUrl();
        }
        elseif ($this->_helper->isCategoryPage($this->getAction()->getFullActionName())) {
            $canonicalUrl = $this->getCanonicalCategoryUrl();
        }
        elseif ($this->getAction()->getFullActionName() == 'tag_product_list') {
            $canonicalUrl = $this->getCanonicalTagUrl();
        }
        else {
            $canonicalUrl = $this->_helper->trailingSlash(Mage::helper('core/url')->getCurrentUrl());
        }

        // apply crossDomainUrl
        $crossDomainStore = false;
        $product          = Mage::registry('current_product');
        if (is_object($product) && $product->getCanonicalCrossDomain()) {
            $crossDomainStore = $product->getCanonicalCrossDomain();
        }
        elseif (Mage::getStoreConfig('mageworx_seo/seosuite/cross_domain')) {
            $crossDomainStore = Mage::getStoreConfig('mageworx_seo/seosuite/cross_domain');
        }

        if ($crossDomainStore) {
            $url          = Mage::app()->getStore($crossDomainStore)->getBaseUrl();
            $canonicalUrl = str_replace(Mage::getUrl(), $url, $canonicalUrl);
        }

        $canonicalUrl = filter_var(filter_var($canonicalUrl, FILTER_SANITIZE_STRING), FILTER_SANITIZE_URL);

        return !empty($canonicalUrl) ? $canonicalUrl : false;
    }

    public function getCanonicalReviewUrl()
    {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $url        = $currentUrl;

        $toolbar = $this->getLayout()->getBlock('product_review_list.toolbar');
        if (is_object($toolbar) && ($toolbar instanceof Mage_Catalog_Block_Product_List_Toolbar)) {
            $availableLimit = $toolbar->getAvailableLimit();
        }
        else {
            $availableLimit = false;
        }

        if (is_array($availableLimit) && !empty($availableLimit['all'])) {
            $url = $this->_helper->trailingSlash($category->getUrl());
            $url = $this->addLimitAllToUrl($url, $toolbar);
        }
        else {
            $url = $this->deleteSortParametersFromUrl($url, $toolbar);
        }

        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            $canonicalUrl = $url;
        }
        else {
            $canonicalUrl = $currentUrl;
        }

        return $canonicalUrl;
    }

    public function getCanonicalProductUrl()
    {
        $useCategories = Mage::getStoreConfigFlag('catalog/seo/product_use_categories');
        $product       = Mage::registry('current_product');

        ///Check product canonical on review page
        if($this->getAction()->getFullActionName() == 'review_product_list'){
            if(!$this->_helper->isProductCanonicalUrlOnReviewPage()){
                return $this->getCanonicalReviewUrl();
            }
        }

        if ($product) {

            $canonicalUrl = $product->getCanonicalUrl();

            if ($canonicalUrl) {
                $secure = '';
                if (Mage::app()->getStore()->isFrontUrlSecure()) {
                    $secure = 's';
                }

                $urlRewrite = Mage::getModel('core/url_rewrite')->setStoreId(Mage::app()->getStore()->getId())->loadByIdPath($canonicalUrl);
                if (strpos($urlRewrite->getRequestPath(), "http" . $secure) !== true) {
                    $canonicalUrl = $urlRewrite->getRequestPath();
                }
                elseif (strpos($urlRewrite->getRequestPath(), "http") !== false) {
                    $canonicalUrl = $urlRewrite->getRequestPath();
                }
                else {
                    $canonicalUrl = $urlRewrite->getRequestPath();
                }
            }
            else {

                if(Mage::helper('seosuite')->isAssociatedCanonicalEnabled(Mage::app()->getStore()->getStoreId())){
                    if($this->_helper->isCompoundProductType($product->getTypeID()) === false){

                        $compoundProduct = $this->_helper->getLastCompoundProductByChildProductId($product->getId());

                        if(is_object($compoundProduct)){
                            $product = $compoundProduct;
                        }
                    }
                }

                $canonicalUrl = $this->_helper->getUrlRewriteCanonical($product);
                if (!$canonicalUrl) {
                    $canonicalUrl = $product->getProductUrl(false);
                    if (!$canonicalUrl) {  //|| $productCanonicalUrl == 0) {
                        $product->setDoNotUseCategoryId(!$useCategories);
                        $canonicalUrl = $product->getProductUrl(false);
                    }
                }
            }
        }

        if (strpos($canonicalUrl, 'http') === false) {
            if (self::CROP_URL_PARAMS) {
                list($urlWithoutParams) = explode('?', Mage::getUrl(''));
                $canonicalUrl = $this->_helper->trailingSlash($urlWithoutParams . $canonicalUrl);
            }
            else {
                $canonicalUrl = $this->_helper->trailingSlash(Mage::getUrl('') . $canonicalUrl);
            }
        }
        else {
            $canonicalUrl = $this->_helper->trailingSlash($canonicalUrl);
        }

        return $canonicalUrl;
    }

    public function getCanonicalCategoryUrl()
    {
        $category = Mage::registry('current_category');

        if(!is_object($category)){
            return '';
        }

        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $url        = $currentUrl;

        $toolbar = $this->getLayout()->getBlock('product_list_toolbar');
        if (is_object($toolbar) && ($toolbar instanceof Mage_Catalog_Block_Product_List_Toolbar)) {
            $availableLimit = $toolbar->getAvailableLimit();
        }
        else {
            $availableLimit = false;
        }

        ///LN URLS
        if($this->_helper->applyedLayeredNavigationFilters()){
            ///Disable canonical on layered navigation pages
            if ($this->_helper->isIncludeLNFiltersToCanonicalUrlByConfig() == MageWorx_SeoSuite_Helper_Data::CATEGORY_LN_CANONICAL_OFF) {
                return '';
            }

            ///FRIENDLY LN URLS
            if($this->_helper->isLNFriendlyUrlsEnabled()){
                ///FRIENDLY LN URLS WITH PAGE ALL
                if (is_array($availableLimit) && !empty($availableLimit['all'])) {
                    if ($this->_helper->isIncludeLNFiltersToCanonicalUrl()) {
                        $url = $this->deleteSortParametersFromUrl($url, $toolbar);
                        $url = $this->deleteLimitParameterFromUrl($url, $toolbar);
                        $url = $this->deletePagerParameterFromUrl($url, $toolbar);
                        $url = $this->addLimitAllToUrl($url, $toolbar);
                    }
                    else {
                        $url = $this->_helper->trailingSlash($category->getUrl());
                        $url = $this->addLimitAllToUrl($url, $toolbar);
                    }
                }
                ///FRIENDLY LN URLS WITHOUT PAGE ALL
                else{
                    if ($this->_helper->isIncludeLNFiltersToCanonicalUrl()) {
                        $url = $this->changePagerParameterToCurrentForCurrentUrl();
                        $url = $this->deleteSortParametersFromUrl($url, $toolbar);
                    }
                    else {
                        //Maybe better without canonical url...?
                        $url = $this->_helper->trailingSlash($category->getUrl());
                    }
                }
            }
            ///DEFAULT LN URLS
            else{
                $subCategory = $this->getSubCategoryForCanonical($url);

                if(is_object($subCategory)){
                    $url = $this->_convertSubCategoryUrl($url, $subCategory);
                    if($subCategory->getDisplayMode() == 'PAGE'){
                        return $this->_helper->trailingSlash($url);
                    }
                }

                ///DEFAULT LN URLS WITH PAGE ALL
                if (is_array($availableLimit) && !empty($availableLimit['all'])) {
                    if ($this->_helper->isIncludeLNFiltersToCanonicalUrl()) {
                        $url = $this->deleteSortParametersFromUrl($url, $toolbar);
                        $url = $this->deleteLimitParameterFromUrl($url, $toolbar);
                        $url = $this->deletePagerParameterFromUrl($url, $toolbar);
                        $url = $this->addLimitAllToUrl($url, $toolbar);
                    }
                    else {
                        $url = $this->_helper->trailingSlash($category->getUrl());
                        $url = $this->addLimitAllToUrl($url, $toolbar);
                    }
                }
                ///DEFAULT LN URLS WITHOUT PAGE ALL
                else{
                    if ($this->_helper->isIncludeLNFiltersToCanonicalUrl()) {
                        $url = $this->deleteSortParametersFromUrl($url, $toolbar);
                    }
                    else {
                        //Maybe without canonical url better...?
                        $url = $this->_helper->trailingSlash($category->getUrl());
                    }
                }
            }
        }
        ///CATEGORY URLS WITHOUT LN
        else{
            ///Magento bug? For category with display mode = PAGE,
            /// If clear LN filters the pager will remain in the category URL
            if($category->getDisplayMode() == 'PAGE'){
                return $this->_helper->trailingSlash($category->getUrl());
            }

            ///CATEGORY URLS WITH PAGE ALL
            if (is_array($availableLimit) && !empty($availableLimit['all'])) {
                $url = $this->_helper->trailingSlash($category->getUrl());
                $url = $this->addLimitAllToUrl($url, $toolbar);
            }
            ///CATEGORY URLS WITHOUT PAGE ALL
            else{
                $url = $this->changePagerParameterToCurrentForCurrentUrl();
                $url = $this->deleteSortParametersFromUrl($url, $toolbar);
            }
        }

        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            $canonicalUrl = $url;
        }
        else {
            $canonicalUrl = $currentUrl;
        }

        return $canonicalUrl;
    }

    public function getCanonicalTagUrl()
    {
        $toolbar = $this->getLayout()->getBlock('product_list_toolbar');

        if (is_object($toolbar) && ($toolbar instanceof Mage_Catalog_Block_Product_List_Toolbar)) {
            $availableLimit = $toolbar->getAvailableLimit();
        }
        else {
            $availableLimit = false;
        }

        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $url        = $currentUrl;

        if (is_array($availableLimit) && !empty($availableLimit['all'])) {
            $url = $this->deleteSortParametersFromUrl($url, $toolbar);
            $url = $this->deleteLimitParameterFromUrl($url, $toolbar);
            $url = $this->deletePagerParameterFromUrl($url, $toolbar);
            $url = $this->addLimitAllToUrl($url, $toolbar);
        }
        else {
            $url = $this->deleteSortParametersFromUrl($url, $toolbar);
        }

        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            $canonicalUrl = $url;
        }
        else {
            $canonicalUrl = $currentUrl;
        }
        return $canonicalUrl;
    }

    public function getSubCategoryForCanonical($url)
    {
        $parseUrl = parse_url($url);

        if (empty($parseUrl['query'])) {
            return $url;
        }

        parse_str(html_entity_decode($parseUrl['query']), $params);
        if(!empty($params['cat']) && is_numeric($params['cat'])){
            $catId = $params['cat'];
            $subCategory = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($catId);
        }
        return (!empty($subCategory)) ? $subCategory : false;
    }


    protected function _convertSubCategoryUrl($url, $category)
    {

        $parseUrl = parse_url($url);
        $categoryUrl = $category->getUrl();

        if(!empty($categoryUrl)){
            $url = $categoryUrl . '?' .  $parseUrl['query'];
            $url = $this->deleteParametrsFromUrl($url, array('cat'));
        }

        return $url;
    }

    public function deleteSortParametersFromUrl($url, $toolbar)
    {
        $orderVarName     = $toolbar->getOrderVarName();
        $directionVarName = $toolbar->getDirectionVarName();
        $modeVarName      = $toolbar->getModeVarName();

        $orderVarName     = $orderVarName ? $orderVarName : 'order';
        $directionVarName = $directionVarName ? $directionVarName : 'dir';
        $modeVarName      = $modeVarName ? $modeVarName : 'mode';
        return $this->deleteParametrsFromUrl($url, array($orderVarName, $directionVarName, $modeVarName));
    }

    /**
     * Retrive current URL with a specified pager: with parameter 'p =' or as URL part: '* [page_number] * '.html? =...
     * Example 1:
     *      Old url from google search: example.com/computers?p=2
     *      Retrive url: example.com/computers-page2.html (If friendly pager ON, etc.)
     * Example 2 (with layered, sort and mode params):
     *      Old url from google search: example.com/electronics/lnav/price:0-1000.html?p=3&limit=15&mode=list
     *      Retrive url:                example.com/electronics/lnav/price:0-1000-page3.html?limit=15&mode=list
     * @return string
     */
    public function changePagerParameterToCurrentForCurrentUrl()
    {

        $pageNum = $this->getPageNumFromUrl();
        $pager = $this->getLayout()->getBlock('product_list_toolbar_pager');

        //If friendly url disable
        //Canonical for ex.com/computers.html?p=1 is ex.com/computers.html?p=1,
        //Canonical for ex.com/computers.html     is ex.com/computers.html
        //If friendly url enable and use custom pager
        //Canonical for ex.com/computers.html     is ex.com/computers.html
        //Canonical for ex.com/computers.html?p=1 is ex.com/computers.html
        //Because for custom pager url we don't use '1'

        if(is_object($pager)){
            if(!$pageNum){
                return Mage::helper('core/url')->getCurrentUrl();
            }elseif($pageNum == 1 && $this->_helper->isLNFriendlyUrlsEnabled() && $this->_helper->getPagerUrlFormat()){
                return $this->deletePagerParameterFromUrl(Mage::helper('core/url')->getCurrentUrl(), $this->getLayout()->getBlock('product_list_toolbar'));
            }else{
                return $pager->getPageUrl($pageNum);
            }
        }

        return Mage::helper('core/url')->getCurrentUrl();
    }

    public function deleteLimitParameterFromUrl($url, $toolbar)
    {
        $limitVarName = $toolbar->getLimitVarName();
        $limitVarName = $limitVarName ? $limitVarName : 'limit';

        return $this->deleteParametrsFromUrl($url, array($limitVarName));
    }

    public function deletePagerParameterFromUrl($url, $toolbar)
    {
        //delete friendly pager
        $pagerFormat = $this->_helper->getPagerUrlFormat();
        if ($pagerFormat) {
            $pattern         = '#' . str_replace('[page_number]', '[0-9]+', $pagerFormat) . '#';
            $urlWithoutPager = preg_replace($pattern, '', $url);
            $url             = (is_null($urlWithoutPager)) ? $url : $urlWithoutPager;
        }
        //also delete standart pager
        $pageVarName = $toolbar->getPageVarName();
        $url         = $this->deleteParametrsFromUrl($url, array($pageVarName));

        return $url;
    }

    public function deleteParametrsFromUrl($url, array $cropParams)
    {
        $parseUrl = parse_url($url);

        if (empty($parseUrl['query'])) {
            return $url;
        }

        parse_str(html_entity_decode($parseUrl['query']), $params);

        foreach ($cropParams as $cropName) {
            if (array_key_exists($cropName, $params)) {
                unset($params[$cropName]);
            }
        }

        $queryString = '';
        foreach ($params as $name => $value) {
            if ($queryString == '') {
                $queryString = '?' . $name . '=' . $value;
            }
            else {
                $queryString .= '&' . $name . '=' . $value;
            }
        }

        $url = $parseUrl['scheme'] . '://' . $parseUrl['host'] . $parseUrl['path'] . $queryString;
        return $url;
    }

    public function addLimitAllToUrl($url, $toolbar)
    {
        $limitVarName = $toolbar->getLimitVarName();
        $limitVarName = $limitVarName ? $limitVarName : 'limit';

        if (strpos($url, '?') !== false) {
            $url = $url . '&' . $limitVarName . '=all';
        }
        else {
            $url = $url . '?' . $limitVarName . '=all';
        }
        return $url;
    }

    public function getOpenGraphProtocolData($canonicalUrl = null)
    {
        $ogs     = '';
        $product = Mage::registry('current_product');

        if (is_object($product) && Mage::helper('seosuite/richsnippet')->isOpenGraphProtocolEnabled()) {
            $product          = Mage::registry('current_product');
            $url              = $canonicalUrl ? $canonicalUrl : $product->getProductUrl();
            $doubleQuoteTitle = '"';
            $doubleQuoteDescr = '"';
            $descr            = strip_tags($product->getShortDescription() ? $product->getShortDescription() : $product->getDescription());
            $title            = strip_tags($product->getName());

            if (strpos($title, $doubleQuoteTitle) !== false) {
                $doubleQuoteTitle = "'";
            }
            elseif (strpos($descr, $doubleQuoteDescr) !== false) {
                $doubleQuoteDescr = "'";
            }

            $productTypeId = $product->getTypeId();

            if ($productTypeId == 'bundle') {
                $prices = Mage::helper('seosuite/richsnippet')->getBundlePrices();
            }
            elseif ($productTypeId == 'grouped') {
                $prices = Mage::helper('seosuite/richsnippet')->getGroupedPrices();
            }
            else {
                $prices = Mage::helper('seosuite/richsnippet')->getDefaultPrices();
            }

            if (!empty($prices) && is_array($prices)) {
                $price = $prices[0];
            }

            $currency = strtoupper(Mage::app()->getStore()->getCurrentCurrencyCode());
            $ogs  = "<meta property=\"og:type\" content=\"product\"/>\n";
            $ogs .= "<meta property=\"og:title\" content=$doubleQuoteTitle" . $title . "$doubleQuoteTitle/>\n";
            $ogs .= "<meta property=\"og:description\" content=$doubleQuoteDescr" . $descr . "$doubleQuoteDescr/>\n";
            $ogs .= "<meta property=\"og:url\" content=\"" . $url . "\"/>\n";

            if ($price) {
                $ogs .= "<meta property=\"product:price:amount\" content=\"" . $price . "\"/>\n";
            }
            if ($currency) {
                $ogs .= "<meta property=\"product:price:currency\" content=\"" . $currency . "\"/>\n";
            }
            $gallery = $product->getMediaGallery();
            if (isset($gallery['images'])) {
                foreach ($gallery['images'] as $_image) {
                    $ogs .="<meta property=\"og:image\" content=\"" . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/product' . $_image['file'] . "\"/>\n";
                }
            }
        }
        return $ogs;
    }

    public function getRobots()
    {
        // standart magento
        //$this->_data['robots'] = Mage::getStoreConfig('design/head/default_robots');
        //https_robots
        if (substr(Mage::helper('core/url')->getCurrentUrl(), 0, 8) == 'https://')
                $this->_data['robots'] = Mage::getStoreConfig('mageworx_seo/seosuite/https_robots');

        $noindexPatterns = explode(',', Mage::getStoreConfig('mageworx_seo/seosuite/noindex_pages'));
        $noindexPatterns = array_map('trim', $noindexPatterns);
        foreach ($noindexPatterns as $pattern) {
            //  $pattern = str_replace(array('\\','^','$','.','[',']','|','(',')','?','*','+','{','}'),array('\\\\','\^','\$','\.','\[','\]','\|','\(','\)','\?','\*','\+','\{','\}'),$pattern);
            if (preg_match('/' . $pattern . '/', $this->getAction()->getFullActionName())) {
                $this->_data['robots'] = 'NOINDEX, FOLLOW';
                break;
            }
        }

        $noindexPatterns = array_filter(preg_split('/\r?\n/',
                Mage::getStoreConfig('mageworx_seo/seosuite/noindex_pages_user')));
        $noindexPatterns = array_map('trim', $noindexPatterns);
        $noindexPatterns = array_filter ($noindexPatterns);
        foreach ($noindexPatterns as $pattern) {
            $pattern = str_replace('?', '\?', $pattern);
            $pattern = str_replace('*', '.*?', $pattern);
            //  $pattern = str_replace(array('\\','^','$','.','[',']','|','(',')','?','*','+','{','}'),array('\\\\','\^','\$','\.','\[','\]','\|','\(','\)','\?','\*','\+','\{','\}'),$pattern);

            if (preg_match('#' . $pattern . '#', $this->getAction()->getFullActionName()) || preg_match('#' . $pattern . '#',
                    $this->getAction()->getRequest()->getRequestString()) || preg_match('#' . $pattern . '#',
                    $this->getAction()->getRequest()->getRequestUri()) || preg_match('#' . $pattern . '#',
                    Mage::helper('core/url')->getCurrentUrl())
            ) {
                $this->_data['robots'] = 'NOINDEX, FOLLOW';
                break;
            }
        }

        $noindexNofollowPatterns = array_filter(preg_split('/\r?\n/',
                Mage::getStoreConfig('mageworx_seo/seosuite/noindex_nofollow_pages_user')));
        $noindexNofollowPatterns = array_map('trim', $noindexNofollowPatterns);
        $noindexNofollowPatterns = array_filter ($noindexNofollowPatterns);
        foreach ($noindexNofollowPatterns as $pattern) {
            $pattern = str_replace('?', '\?', $pattern);
            $pattern = str_replace('*', '.*?', $pattern);
            //  $pattern = str_replace(array('\\','^','$','.','[',']','|','(',')','?','*','+','{','}'),array('\\\\','\^','\$','\.','\[','\]','\|','\(','\)','\?','\*','\+','\{','\}'),$pattern);

            if (preg_match('%' . $pattern . '%', $this->getAction()->getFullActionName()) || preg_match('%' . $pattern . '%',
                    $this->getAction()->getRequest()->getRequestString()) || preg_match('%' . $pattern . '%',
                    $this->getAction()->getRequest()->getRequestUri()) || preg_match('%' . $pattern . '%',
                    Mage::helper('core/url')->getCurrentUrl())
            ) {
                $this->_data['robots'] = 'NOINDEX, NOFOLLOW';
                break;
            }
        }

        if (empty($this->_data['robots'])) {
            $this->_data['robots'] = Mage::getStoreConfig('design/head/default_robots');
        }

        return $this->_data['robots'];
    }

    public function isDefaultMetaTitle($title)
    {
        return ($this->getDefaultTitle() && $title == $this->getDefaultTitle()) ? true : false;
    }

    public function getTitle()
    {
        if (Mage::app()->getRequest()->getModuleName() == 'splash') {
            return parent::getTitle();
        }

        $this->_data['title'] = trim(parent::getTitle());

        ///PRODUCT TITLE
        if (Mage::registry('current_product')) {
            $metaDynamicTitle = $this->getProductDynamicMeta('title', Mage::registry('current_product'));

            if ($metaDynamicTitle) {
                $this->_data['title'] = $metaDynamicTitle;
            }

            if ($this->_data['title']) {
                if (!$this->_helper->isCutPrefixSuffixFromProductAndCategoryPages()) {
                    $this->_data['title'] = $this->_cutPrefixSuffix($this->_data['title']);
                    $this->_data['title'] =
                        Mage::getStoreConfig('design/head/title_prefix') . ' ' . $this->_data['title']
                        . ' ' . Mage::getStoreConfig('design/head/title_suffix');
                }
                else {
                    $this->_data['title'] = $this->_cutPrefixSuffix($this->_data['title']);
                }
            }

            if ($this->getAction()->getFullActionName() == 'review_product_list') {
                $this->_data['title'] = $this->__('Reviews for') . ' ' . $this->_data['title'];
            }
        }
        ///CATEGORY TITLE
        elseif (Mage::registry('current_category')) {

            $metaDynamicTitle = $this->getCategoryDynamicMeta('title', Mage::registry('current_category'));

            if ($metaDynamicTitle) {
                $this->_data['title'] = $metaDynamicTitle;
            }

            if ($this->_data['title']) {

                if (!$this->_helper->isCutPrefixSuffixFromProductAndCategoryPages()) {
                    $this->_data['title'] = $this->_cutPrefixSuffix($this->_data['title']);
                    $this->_data['title'] = trim(
                        Mage::getStoreConfig('design/head/title_prefix') . ' ' . $this->_data['title']
                        . ' ' . Mage::getStoreConfig('design/head/title_suffix')
                        );
                }
                else {
                    $this->_data['title'] = $this->_cutPrefixSuffix($this->_data['title']);
                }

                ///Add layered filters to meta
                $filtersPartForMeta = $this->getLayerFiltersMetaPart('title');
                if ($filtersPartForMeta) {
                    $this->_data['title'] = $this->_data['title'] . ', ' . $filtersPartForMeta;
                }
            }
        }
        ///CMS TITLE
        elseif (!Mage::registry('current_product') && Mage::app()->getRequest()->getModuleName() == 'cms') {

            if (Mage::getSingleton('cms/page')->getMetaTitle()) {
            	$this->_data['title'] = trim(Mage::getStoreConfig('design/head/title_prefix')
                        . ' ' . Mage::getSingleton('cms/page')->getMetaTitle()
                        . ' ' . Mage::getStoreConfig('design/head/title_suffix')
                );
            }

            if (Mage::getSingleton('cms/page')->getData('published_revision_id')) {
                $collection = Mage::getResourceModel('enterprise_cms/page_revision_collection');
                $collection->getSelect()->where('revision_id=?',
                    Mage::getSingleton('cms/page')->getData('published_revision_id'));
                $pageData   = $collection->getFirstItem();

                if(!$pageData->getMetaTitle()){
                    $this->_data['title'] = trim(Mage::getStoreConfig('design/head/title_prefix')
                        . ' ' . $pageData->getMetaTitle()
                        . ' ' . Mage::getStoreConfig('design/head/title_suffix')
                    );
                }
            }
        }
        ///RSS TITLE
        elseif (Mage::app()->getRequest()->getModuleName() == 'rss') {
            $this->_data['title'] = 'RSS Feed | ' . Mage::app()->getWebsite()->getName();
        }
        ///XSITEMAP TITLE
        elseif ($this->getAction()->getFullActionName() == 'xsitemap_index_index') {
            if (Mage::getStoreConfig('mageworx_seo/xsitemap/sitemap_meta_title') !== "") {
                $this->_data['title'] = Mage::getStoreConfig('mageworx_seo/xsitemap/sitemap_meta_title');
            }
        }

        $this->_data['title'] = $this->addPageNumToMeta('title', $this->_data['title']);

        $this->_data['title'] = trim(htmlspecialchars(html_entity_decode($this->_data['title'], ENT_QUOTES, 'UTF-8')));

        if (!$this->_data['title']) {
            $this->_data['title'] = $this->getDefaultTitle();
        }

        return $this->_data['title'];
    }

    public function getDescription()
    {
        if (Mage::app()->getRequest()->getModuleName() == 'splash') {
            return parent::getDescription();
        }

        $this->_data['description'] = trim(parent::getDescription());

        ///PRODUCT DESCRIPTION
        if (Mage::registry('current_product')) {
            $metaDynamic                = $this->getProductDynamicMeta('description', Mage::registry('current_product'));
            $this->_data['description'] = ($metaDynamic) ? $metaDynamic : $this->_data['description'];

            if ($this->getAction()->getFullActionName() == 'review_product_list') {
                $this->_data['description'] = $this->__('Reviews for') . ' ' . $this->_data['description'];
            }
        }
        ///CATEGORY DESCRIPTION
        elseif (Mage::registry('current_category')) {

            $metaDynamic                = $this->getCategoryDynamicMeta('description',
                Mage::registry('current_category'));
            $this->_data['description'] = ($metaDynamic) ? $metaDynamic : $this->_data['description'];

            ///Description from category object or dynamic added - add layered fulters to meta
            $filtersPartForMeta = $this->getLayerFiltersMetaPart('description');

            if(!empty($filtersPartForMeta)){
                if(!$this->_data['description']){
                    $this->_data['description'] = $filtersPartForMeta;
                }else{
                    $this->_data['description'] = $this->_data['description'] . ', ' . $filtersPartForMeta;
                }
            }
        }
        ///CMS DESCRIPTION
        elseif (Mage::app()->getRequest()->getModuleName() == 'cms') {
            $description                = Mage::getSingleton('cms/page')->getMetaDescription();
            $this->_data['description'] = ($description) ? $description : $this->_data['description'];
        }
        ///RSS DESCRIPTION
        elseif (Mage::app()->getRequest()->getModuleName() == 'rss') {
            $this->_data['description'] = 'RSS Feed | ' . Mage::app()->getWebsite()->getName();
        }
        ///XSITEMAP DESCRIPTION
        elseif ($this->getAction()->getFullActionName() == 'xsitemap_index_index') {
            if (Mage::getStoreConfig('mageworx_seo/xsitemap/sitemap_meta_desc') !== "") {
                $this->_data['description'] = Mage::getStoreConfig('mageworx_seo/xsitemap/sitemap_meta_desc');
            }
        }

        $this->_data['description'] = $this->addPageNumToMeta('description', $this->_data['description']);

        $stripTags = new Zend_Filter_StripTags();

        return $this->_data['description'] = htmlspecialchars(html_entity_decode(preg_replace(array('/\r?\n/', '/[ ]{2,}/'),
                    array(' ', ' '), $stripTags->filter($this->_data['description'])), ENT_QUOTES, 'UTF-8'));
    }

    public function getKeywords()
    {
        if (Mage::app()->getRequest()->getModuleName() == 'splash') {
            return parent::getKeywords();
        }

        $this->_data['keywords'] = trim(parent::getKeywords());

        ///PRODUCT KEYWORDS
        if (Mage::registry('current_product')) {
            $metaDynamic             = $this->getProductDynamicMeta('keywords', Mage::registry('current_product'));
            $this->_data['keywords'] = ($metaDynamic) ? $metaDynamic : $this->_data['keywords'];
        }
        ///CATEGORY KEYWORDS
        elseif (Mage::registry('current_category')) {
            $metaDynamic             = $this->getCategoryDynamicMeta('keywords', Mage::registry('current_category'));
            $this->_data['keywords']    = ($metaDynamic) ? $metaDynamic : $this->_data['keywords'];

            ///Keywords from category object or dynamic added - add layered fulters to meta
            if (!empty($this->_data['keywords'])) {
                $filtersPartForMeta = $this->getLayerFiltersMetaPart('keywords');

                if ($filtersPartForMeta) {
                    $this->_data['keywords'] .= $filtersPartForMeta;
                }
            }
        }
        ///XSITEMAP KEYWORDS
        elseif ($this->getAction()->getFullActionName() == 'xsitemap_index_index') {
            $this->_data['keywords'] = $this->_data['keywords'];
            if (Mage::getStoreConfig('mageworx_seo/xsitemap/sitemap_meta_keywords') !== "") {
                $this->_data['keywords'] = Mage::getStoreConfig('mageworx_seo/xsitemap/sitemap_meta_keywords');
            }
        }
        ///CMS KEYWORDS
        elseif (Mage::app()->getRequest()->getModuleName() == 'cms') {
            $keywords = Mage::getSingleton('cms/page')->getData('meta_keywords');
            if ($keywords) {
                $this->_data['keywords'] = $keywords;
            }
        }

        return trim(htmlspecialchars(html_entity_decode($this->_data['keywords'], ENT_QUOTES, 'UTF-8')));
    }

    protected function _cutPrefixSuffix($title)
    {
        $prefix = Mage::getStoreConfig('design/head/title_prefix');
        $suffix = Mage::getStoreConfig('design/head/title_suffix');
        if ($prefix && strpos($title, $prefix) !== false) {
            $title = trim(str_replace($prefix, '', $title));
        }
        if ($suffix && strpos($title, $suffix) !== false) {
            $title = trim(str_replace($suffix, '', $title));
        }
        return $title;
    }

    /**
     * Retrive dynamic data for metaType: title, description, keywords
     * If dynamic generation disable return false.
     * @param string $metaType
     * @param object $product
     * @return string | false
     */
    public function getProductDynamicMeta($metaType, $product)
    {
        if ($this->_helper->getStatusDynamicMetaType($metaType) == 'off') {
            return false;
        }

        //Use only if clear original meta
        if ($this->_helper->getStatusDynamicMetaType($metaType) == 'on_for_empty') {
            if ($metaType == 'title') {
                if (trim($product->getMetaTitle())) {
                    return false;
                }
            }
            elseif ($metaType == 'description') {
                if (trim($product->getMetaDescription())) {
                    return false;
                }
            }
            elseif ($metaType == 'keywords') {
                if (trim($product->getMetaKeyword())) {
                    return false;
                }
            }
        }

        if ($metaType == 'title') {
            $metaTemplate = Mage::getModel('seosuite/template')->loadTitle();
        }
        elseif ($metaType == 'description') {
            $metaTemplate = Mage::getModel('seosuite/template')->loadMetaDescription();
        }
        elseif ($metaType == 'keywords') {
            $metaTemplate = Mage::getModel('seosuite/template')->loadKeywords();
        }


        if (!empty($metaTemplate)) {
            $meta = $this->__compile(Mage::registry('current_product'), $metaTemplate, 'product');
        }

        return (!empty($meta)) ? trim($meta) : false;
    }

    public function getCategoryDynamicMeta($metaType, $category)
    {
        if ($this->_helper->getStatusDynamicMetaType($metaType) == 'off') {
            return false;
        }

        //Use only if clear original meta
        if ($this->_helper->getStatusDynamicMetaType($metaType) == 'on_for_empty') {
            if ($metaType == 'title') {
                if (trim($category->getMetaTitle())) {
                    return false;
                }
            }
            elseif ($metaType == 'description') {
                if (trim($category->getMetaDescription())) {
                    return false;
                }
            }
            elseif ($metaType == 'keywords') {
                if (trim($category->getMetaKeywords())) {
                    return false;
                }
            }
        }

        if ($metaType == 'title') {
            $metaTemplate = Mage::getModel('seosuite/template')->loadCategoryTitle();
        }
        elseif ($metaType == 'description') {
            $metaTemplate = Mage::getModel('seosuite/template')->loadCategoryMetaDescription();
        }
        elseif ($metaType == 'keywords') {
            $metaTemplate = Mage::getModel('seosuite/template')->loadCategoryMetaKeywords();
        }


        if (!empty($metaTemplate)) {
            $meta = $this->__compile(Mage::registry('current_category'), $metaTemplate, 'category');
        }

        return (!empty($meta)) ? $meta : false;
    }

    public function addPageNumToMeta($metaType, $metaValue)
    {
        $metaValue      = trim($metaValue);
        $statusPagerNum = $this->_helper->getStatusPagerNumForMeta($metaType);
        if ($statusPagerNum == 'end') {
            $pageNum = $this->getPageNumFromUrl();
            if ($pageNum) {
                $metaValue .= ' | ' . $this->_helper->__('Page') . " " . $pageNum;
            }
        }
        elseif ($statusPagerNum == 'begin') {
            $pageNum = $this->getPageNumFromUrl();
            if ($pageNum) {
                $metaValue = $this->_helper->__('Page') . " " . $pageNum . ' | ' . $metaValue;
            }
        }

        return $metaValue;
    }


    public function getLayerFiltersMetaPart($metaType)
    {
    	$metaPart = '';
    	if( ($metaType == 'title' && $this->_helper->isExtendedMetaTitleForLNEnabled()) ||
            ($metaType == 'description' && $this->_helper->isExtendedMetaDescriptionForLNEnabled())
        ){
        	$currentFiltersData = $this->_helper->getLayeredNavigationFiltersData();
        	if (is_array($currentFiltersData) && count($currentFiltersData) > 0) {
            	foreach ($currentFiltersData as $filter) {
                	$metaPart .= $filter['name'] . " " . strip_tags($filter['label'] . ', ');
            	}
        	}
    	}
    	return trim(trim($metaPart), ',');
    }

    /**
     * Parse url and retrive page number.
     * At first find by param '[?&]p=', then by part of url (E.g. ex.com/apparel-page2.html).
     * @return type
     */
    public function getPageNumFromUrl()
    {
        $params = Mage::app()->getFrontController()->getRequest()->getParams();
        if (!empty($params['p'])) {
            if (settype($params['p'], 'int') == $params['p']) {
                $num = $params['p'];
            }
        }

        if (empty($num)) {
            $pageFormat = $this->_helper->getPagerUrlFormat();
            if ($pageFormat != '-[page_number]') {
                $pattern = '(' . str_replace('[page_number]', '[0-9]+', $pageFormat) . ')';
                if (preg_match($pattern, $this->getAction()->getRequest()->getRequestString(), $matches)) {
                    $match = array_pop($matches);
                    if ($match) {
                        $lengthBeforeNum = strpos($pageFormat, '[page_number]');
                        $lengthAfterNum  = strlen($pageFormat) - (strpos($pageFormat, '[page_number]') + 13);
                        $num             = substr($match, $lengthBeforeNum);
                        $num             = substr($num, 0, strlen($num) - $lengthAfterNum);
                    }
                }
            }
        }
        return !empty($num) ? $num : false;
    }

    protected function __compile($object, $template, $type = 'product')
    {
        if (!$object) {
            return '';
        }
        $template = Mage::getModel('seosuite/catalog_' . $type . '_template_title')->getCompile($object, $template);
        return $template;
    }

}
