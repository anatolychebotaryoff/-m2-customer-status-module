<?php
/**
 * Lyonscg_RewriteParams
 *
 * @category  Lyonscg
 * @package   Lyonscg_RewriteParams
 * @copyright Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author    Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Rewrite of Mage_Core_Model_Url_Rewrite
 *
 * Inject _GET params onto the target URL for redirected rewrites
 *
 * @category Lyonscg
 * @package  Lyonscg_RewriteParams
 */
class Lyonscg_RewriteParams_Model_Url_Rewrite extends Mage_Core_Model_Url_Rewrite
{

    /**
     * Implement logic of custom rewrites
     *
     * @param   Zend_Controller_Request_Http $request
     * @param   Zend_Controller_Response_Http $response
     * @return  Mage_Core_Model_Url
     */
    public function rewrite(Zend_Controller_Request_Http $request = null, Zend_Controller_Response_Http $response = null)
    {
        if (!Mage::isInstalled()) {
            return false;
        }
        if (is_null($request)) {
            $request = Mage::app()->getFrontController()->getRequest();
        }
        if (is_null($response)) {
            $response = Mage::app()->getFrontController()->getResponse();
        }
        if (is_null($this->getStoreId()) || false === $this->getStoreId()) {
            $this->setStoreId(Mage::app()->getStore()->getId());
        }

        /**
         * We have two cases of incoming paths - with and without slashes at the end ("/somepath/" and "/somepath").
         * Each of them matches two url rewrite request paths - with and without slashes at the end ("/somepath/" and "/somepath").
         * Choose any matched rewrite, but in priority order that depends on same presence of slash and query params.
         */
        $requestCases = array();
        $targetUrl = '';
        $pathInfo = $request->getPathInfo();
        $origSlash = (substr($pathInfo, -1) == '/') ? '/' : '';
        $requestPath = trim($pathInfo, '/');

        // If there were final slash - add nothing to less priority paths. And vice versa.
        $altSlash = $origSlash ? '' : '/';

        $queryString = $this->_getQueryString(); // Query params in request, matching "path + query" has more priority

        if ($queryString) {
            $requestCases[] = $requestPath . $origSlash . '?' . $queryString;
            $requestCases[] = $requestPath . $altSlash . '?' . $queryString;
        }
        $requestCases[] = $requestPath . $origSlash;
        $requestCases[] = $requestPath . $altSlash;

        $this->loadByRequestPath($requestCases);

        /**
         * Try to find rewrite by request path at first, if no luck - try to find by id_path
         */
        if (!$this->getId() && isset($_GET['___from_store'])) {
            try {
                $fromStoreId = Mage::app()->getStore($_GET['___from_store'])->getId();
            } catch (Exception $e) {
                return false;
            }

            $this->setStoreId($fromStoreId)->loadByRequestPath($requestCases);
            if (!$this->getId()) {
                return false;
            }
            $currentStore = Mage::app()->getStore();
            $this->setStoreId($currentStore->getId())->loadByIdPath($this->getIdPath());

            Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME, $currentStore->getCode(), true);
            $targetUrl = $request->getBaseUrl() . '/' . $this->getRequestPath();

            // START Lyonscg Edit: add allowed _GET params to the target URL
            $targetUrl = Mage::helper('lyonscg_rewriteparams')->processTargetUrl($targetUrl);
            // END Lyonscg Edit

            $this->_sendRedirectHeaders($targetUrl, true);
        }

        if (!$this->getId()) {
            return false;
        }


        $request->setAlias(self::REWRITE_REQUEST_PATH_ALIAS, $this->getRequestPath());
        $external = substr($this->getTargetPath(), 0, 6);
        $isPermanentRedirectOption = $this->hasOption('RP');
        if ($external === 'http:/' || $external === 'https:') {
            $destinationStoreCode = Mage::app()->getStore($this->getStoreId())->getCode();
            Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME, $destinationStoreCode, true);

            $targetUrl = $this->getTargetPath();

            // START Lyonscg Edit: add allowed _GET params to the target URL
            $targetUrl = Mage::helper('lyonscg_rewriteparams')->processTargetUrl($targetUrl);
            // END Lyonscg Edit

            $this->_sendRedirectHeaders($targetUrl, $isPermanentRedirectOption);
        } else {
            $targetUrl = $request->getBaseUrl() . '/' . $this->getTargetPath();
        }
        $isRedirectOption = $this->hasOption('R');
        if ($isRedirectOption || $isPermanentRedirectOption) {
            if (Mage::getStoreConfig('web/url/use_store') && $storeCode = Mage::app()->getStore()->getCode()) {
                $targetUrl = $request->getBaseUrl() . '/' . $storeCode . '/' . $this->getTargetPath();
            }

            // START Lyonscg Edit: add allowed _GET params to the target URL
            $targetUrl = Mage::helper('lyonscg_rewriteparams')->processTargetUrl($targetUrl);
            // END Lyonscg Edit

            $this->_sendRedirectHeaders($targetUrl, $isPermanentRedirectOption);
        }

        if (Mage::getStoreConfig('web/url/use_store') && $storeCode = Mage::app()->getStore()->getCode()) {
            $targetUrl = $request->getBaseUrl() . '/' . $storeCode . '/' . $this->getTargetPath();
        }

        // START Lyonscg Edit: add allowed _GET params to the target URL
        $targetUrl = Mage::helper('lyonscg_rewriteparams')->processTargetUrl($targetUrl);
        // END Lyonscg Edit
        // If targetUrl is null, then append the query string if present.
        // This will be a rare case.
        if (!isset($targetUrl)) {
            $queryString = $this->_getQueryString();
            if ($queryString) {
                $targetUrl .= '?' . $queryString;
            }
        }

        $request->setRequestUri($targetUrl);
        $request->setPathInfo($targetUrl);

        return true;
    }

}
