<?php

class USWF_SeoSuite_Block_Page_Html_Head extends MageWorx_SeoBase_Block_Page_Html_Head
{

    /**
     * Fixed 500 error when open category pages
     *
     * @param $url
     * @param $toolbar
     * @return string
     */
    public function deleteSortParametersFromUrl($url, $toolbar)
    {
        if (is_object($toolbar) && ($toolbar instanceof Mage_Catalog_Block_Product_List_Toolbar)) {
            $orderVarName     = $toolbar->getOrderVarName();
            $directionVarName = $toolbar->getDirectionVarName();
            $modeVarName      = $toolbar->getModeVarName();

            $orderVarName     = $orderVarName ? $orderVarName : 'order';
            $directionVarName = $directionVarName ? $directionVarName : 'dir';
            $modeVarName      = $modeVarName ? $modeVarName : 'mode';

            return $this->deleteParametrsFromUrl($url, array($orderVarName, $directionVarName, $modeVarName));
        } else {
            return $this->changePagerParameterToCurrentForCurrentUrl();
        }
    }

    /**
     * It does remove the pagination variable in the Canonical URL
     *
     * @return mixed|string
     */
    public function getCanonicalCategoryUrl()
    {
        $canonicalUrl = $this->getCustomCanonicalCategoryUrl();
        if ($canonicalUrl) {
            return $canonicalUrl;
        }
        $canonicalUrl = parent::getCanonicalCategoryUrl();
        if ($canonicalUrl === '' ) {
            $canonicalUrl = $this->getCanonicalCategoryUrlChanged();
        }
        $pager = $this->getLayout()->getBlock('product_list_toolbar_pager');
        if(is_object($pager)){
            if(!$this->_helper->getPagerUrlFormat()){
                $canonicalUrl = $this->deletePagerParameterFromUrl($canonicalUrl, $this->getLayout()->getBlock('product_list_toolbar'));
                $canonicalUrl = $this->deleteLimitParameterFromUrl($canonicalUrl, $this->getLayout()->getBlock('product_list_toolbar'));
            }
        }
        return $canonicalUrl;
    }

    protected function getCanonicalCategoryUrlChanged()
    {
        $category = Mage::registry('current_category');

        if (!is_object($category)) {
            return '';
        }

        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $url        = $currentUrl;

        $toolbar = $this->getLayout()->getBlock('product_list_toolbar');

        $availableLimit = $this->_getAvailableLimit($toolbar);

        ///LN URLS
        if ($this->_helper->applyedLayeredNavigationFilters()) {
            ///Disable canonical on layered navigation pages
            if ($this->_helper->isIncludeLNFiltersToCanonicalUrlByConfig() == MageWorx_SeoBase_Helper_Data::CATEGORY_LN_CANONICAL_OFF) {
                return '';
            }

            ///FRIENDLY LN URLS
            if ($this->_helper->isLNFriendlyUrlsEnabled()) {
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
                else {
                    if ($this->_helper->isIncludeLNFiltersToCanonicalUrl()) {
                        $url = $this->changePagerParameterToCurrentForCurrentUrl();
                        $url = $this->cropDefaultLimit($url, $toolbar);
                        $url = $this->deleteSortParametersFromUrl($url, $toolbar);
                    }
                    else {
                        //Maybe better without canonical url...?
                        $url = $this->_helper->trailingSlash($category->getUrl());
                    }
                }
            }
            ///DEFAULT LN URLS
            else {
                $subCategory = $this->getSubCategoryForCanonical($url);

                if (is_object($subCategory)) {
                    $url = $this->_convertSubCategoryUrl($url, $subCategory);
                    if ($subCategory->getDisplayMode() == 'PAGE') {
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
                else {
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
        else {

            ///Magento bug? For category with display mode = PAGE,
            /// If clear LN filters the pager will remain in the category URL
            if ($category->getDisplayMode() == 'PAGE') {
                return $this->_helper->trailingSlash($category->getUrl());
            }

            ///CATEGORY URLS WITH PAGE ALL
            if (is_array($availableLimit) && !empty($availableLimit['all'])) {
                $url = $this->_helper->trailingSlash($category->getUrl());
                $url = $this->addLimitAllToUrl($url, $toolbar);
            }
            ///CATEGORY URLS WITHOUT PAGE ALL
            else {
                $url = $this->changePagerParameterToCurrentForCurrentUrl();
                $url = $this->cropDefaultLimit($url, $toolbar);
                $url = $this->deleteSortParametersFromUrl($url, $toolbar);
            }
        }

        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            $canonicalUrl = $this->_helper->trailingSlash($url);
        }
        else {
            $canonicalUrl = $this->_helper->trailingSlash($currentUrl);
        }

        return $canonicalUrl;
    }

    protected function getCustomCanonicalCategoryUrl() {
        $category = Mage::registry('current_category');
        if (!is_object($category)) {
            return '';
        };
        $url = '';
        if ($category->getData('category_canonical_url') != '') {
            $url = Mage::getBaseUrl().$category->getData('category_canonical_url');
        }
        return $url;
    }

    protected function getCustomCanonicalCmsPageUrl() {
        $page = Mage::getSingleton('cms/page');
        if (!is_object($page)) {
            return '';
        };
        $url = '';
        $param = trim($page->getData('cms_canonical_url'));
        if ($param != '') {
            $url = Mage::getBaseUrl().$param;
        }
        return $url;
    }

    /**
     * Add cms page canonical_url ($this->isCmsPage())
     * @return bool|mixed|void
     * @throws Mage_Core_Exception
     */
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

        if (in_array($this->_helper->getCurrentFullActionName(), $ignorePages)) {
            return;
        }

        if ($this->_helper->isProductPage($this->_helper->getCurrentFullActionName())) {
            $canonicalUrl = $this->getCanonicalProductUrl();
        }
        elseif ($this->_helper->isCategoryPage($this->_helper->getCurrentFullActionName())) {
            $canonicalUrl = $this->getCanonicalCategoryUrl();
        }
        elseif($this->_helper->isHomePage($this->_helper->getCurrentFullActionName())) {
            $canonicalUrl = $this->getCanonicalHomePageUrl();
        }
        elseif ($this->_helper->getCurrentFullActionName() == 'tag_product_list') {
            $canonicalUrl = $this->getCanonicalTagUrl();
        }
        else {
            $canonicalUrl = $this->_helper->trailingSlash(Mage::helper('core/url')->getCurrentUrl());
        }

        if($this->isCmsPage($this->_helper->getCurrentFullActionName())) {
            $tmp = $this->getCustomCanonicalCmsPageUrl();
            if ($tmp != '') {
                $canonicalUrl = $this->getCustomCanonicalCmsPageUrl();
            }
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
            $crossDomainUrlParts = explode('?', Mage::app()->getStore($crossDomainStore)->getBaseUrl());
            $crossomainUrl = trim($crossDomainUrlParts[0], '/');

            $urlParts = explode('?', Mage::getUrl());
            $url = trim($urlParts[0], '/');

            $canonicalUrl = str_replace($url, $crossomainUrl, $canonicalUrl);
        }

        $canonicalUrl = filter_var(filter_var($canonicalUrl, FILTER_SANITIZE_STRING), FILTER_SANITIZE_URL);

        return !empty($canonicalUrl) ? $canonicalUrl : false;
    }

    public function isCmsPage($fullActionName)
    {
        return ('cms_page_view' == $fullActionName);
    }

}