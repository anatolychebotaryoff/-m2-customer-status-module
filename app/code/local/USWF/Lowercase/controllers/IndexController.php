<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author blabounty
 */
class USWF_Lowercase_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $uri = $this->getRequest()->getPathInfo();
        $lcUri = strtolower($uri);
        //If the URI is not lowercase, make it lowercase and preserve the parameters as-is
        if ($uri != $lcUri) {
            $params = http_build_query($this->getRequest()->getParams());
            $newUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . $lcUri;
            //Strip doubleslashes
            $newUrl = str_replace('//', '/', $lcUri);
            if ($params) {
                $newUrl .= "?$params";
            }
            $this->getResponse()->setRedirect($newUrl, $code = 301); //set a redirect using Zend response object
        }
        //If it's lowercase anyway, do what app/code/core/Mage/Cms/controllers/IndexController.php does
        else {
            $this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
            $this->getResponse()->setHeader('Status', '404 File not found');
            $pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
            if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
                $this->_forward('defaultNoRoute');
            }
        }
    }
}

?>
