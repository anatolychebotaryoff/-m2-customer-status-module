<?php
/**
 * Lyonscg_RewriteParams
 *
 * @category  Lyonscg
 * @package   Lyonscg_RewriteParams
 * @copyright Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author    Todd Wolaver (twolaver@lyonscg.com)
 */

/**
 * Rewrite of Enterprise_UrlRewrite_Model_Url_Rewrite_Request
 *
 * Inject _GET params onto the target URL for redirected rewrites
 *
 * @category Lyons
 * @package  Lyons_RewriteParams
 */
class Lyonscg_RewriteParams_Model_Url_Rewrite_Request extends Enterprise_UrlRewrite_Model_Url_Rewrite_Request
{
    /**
     * Process redirect (R) and permanent redirect (RP)
     *
     * @return Enterprise_UrlRewrite_Model_Resource_Url_Rewrite
     */
    protected function _processRedirectOptions()
    {
        $isPermanentRedirectOption = $this->_rewrite->hasOption('RP');

        $external = substr($this->_rewrite->getTargetPath(), 0, 6);
        if ($external === 'http:/' || $external === 'https:') {
            $destinationStoreCode = $this->_app->getStore($this->_rewrite->getStoreId())->getCode();
            $this->_setStoreCodeCookie($destinationStoreCode);
            $this->_sendRedirectHeaders($this->_rewrite->getTargetPath(), $isPermanentRedirectOption);
        }

        $targetUrl = $this->_request->getBaseUrl() . '/' . $this->_rewrite->getTargetPath();

        $storeCode = $this->_app->getStore()->getCode();
        if (Mage::getStoreConfig('web/url/use_store') && !empty($storeCode)) {
            $targetUrl = $this->_request->getBaseUrl() . '/' . $storeCode . '/' . $this->_rewrite->getTargetPath();
        }

        if ($this->_rewrite->hasOption('R') || $isPermanentRedirectOption) {

            // START Lyonscg Edit: add allowed _GET params to the target URL
            $targetUrl = Mage::helper('lyonscg_rewriteparams')->processTargetUrl($targetUrl);
            // END Lyonscg Edit

            $this->_sendRedirectHeaders($targetUrl, $isPermanentRedirectOption);
        }

        $queryString = $this->_getQueryString();
        if ($queryString) {
            $targetUrl .= '?' . $queryString;
        }

        $this->_request->setRequestUri($targetUrl);
        $this->_request->setPathInfo($this->_rewrite->getTargetPath());

        return $this;
    }

}