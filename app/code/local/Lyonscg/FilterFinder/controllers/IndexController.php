<?php
/**
 * Current controller class is responsive for accepting and giving away ajax data
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 *
 */

/**
 * Index controller
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 */

class Lyonscg_FilterFinder_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Rendering layout
     */
    public function indexAction()
    {
        $this->loadLayout(array('default'));

        // Set Title for page
        $this->getLayout()->getBlock('head')->setTitle($this->__('Refrigerator Water Filter Finder – DiscountFilterStore.com'));

        // Set Meta Description for page
        $this->getLayout()->getBlock('head')->setDescription($this->__('Find the refrigerator water filter you need using the DiscountFilterStore.com Refrigerator Filter Finder. All major brands & sizes offered.'));

        $this->renderLayout();
    }

    /**
     * Function returns array with urls, attributes options ids and labels for next step,
     * also it returns HTML of product collection if there are 4 steps done,
     * also returns 404 page if not ajax request
     */
    public function stepAction()
    {
        $filterFinderBlock = $this->getLayout()->createBlock('lyonscg_filterfinder/filterFinder');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $responce = $filterFinderBlock->toGetJson();
            if ($responce !== false) {
                $this->getResponse()->setBody( $responce );
            } else {
                $productList = $this->getLayout()->createBlock('lyonscg_filterfinder/product_list');
                $productList->setProductCollection($filterFinderBlock->prepareProductCollection());
                $productList->setTemplate('filterfinder/list.phtml');
                $this->getResponse()->setBody( Zend_Json::encode(array('data' => $productList->toHtml())));
            }
        } else {
            $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
            $this->getResponse()->setHeader('Status','404 File not found');
            $pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
            if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
                $this->_forward('defaultNoRoute');
            }
        }
    }

    /**
     * Returns HTML of product collection with non default offset
     */
    public function collectionAction()
    {
        $page = $this->getRequest()->getParam('page');
        if ($page && ($this->getRequest()->isXmlHttpRequest())) {
            $filterFinderBlock = $this->getLayout()->createBlock('lyonscg_filterfinder/filterFinder');
            $responce = $filterFinderBlock->prepareProductCollection($page);
            $productList = $this->getLayout()->createBlock('lyonscg_filterfinder/product_list');
            $productList->setProductCollection($responce);
            $productList->setTemplate('filterfinder/list.phtml');
            $this->getResponse()->setBody( $productList->toHtml() );
        } else {
            $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
            $this->getResponse()->setHeader('Status','404 File not found');
            $pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
            if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
                $this->_forward('defaultNoRoute');
            }
        }
    }
}
