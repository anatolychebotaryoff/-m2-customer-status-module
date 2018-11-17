<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_FilterFinder
 * @copyright
 * @author
 */
require_once Mage::getModuleDir('controllers', 'Lyonscg_FilterFinder') . DS . 'IndexController.php';
class USWF_FilterFinder_IndexController extends Lyonscg_FilterFinder_IndexController {

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

        $this->initLayoutMessages(array('catalog/session'));

        $this->renderLayout();
    }

    /**
     * Function returns array with urls, attributes options ids and labels for next step,
     * also it returns HTML of product collection if there are 4 steps done,
     * also returns 404 page if not ajax request
     */
    public function stepAction()
    {
        $this->loadLayout(false);

        $filterFinderBlock = $this->getLayout()->createBlock('lyonscg_filterfinder/filterFinder');
        if ($this->getRequest()->isXmlHttpRequest()) {
            Mage::getSingleton('core/session')->setStepFilterParam(
                str_replace(Mage::getUrl('FridgeFilterFinder/index/step'),'',Mage::helper('core/url')->getCurrentUrl())
            );
            $responce = $filterFinderBlock->toGetJson();
            if ($responce !== false) {
                $this->getResponse()->setBody( $responce );
            } else {
                $productList = $this->getLayout()->createBlock('lyonscg_filterfinder/product_list');
                $collection = $filterFinderBlock->prepareProductCollection();
                $productList->setProductCollection($collection);
                $productList->setTemplate('filterfinder/list.phtml');

                $yotpoUpdateBlock = $this->getLayout()->createBlock('core/template');
                $yotpoUpdateBlock->setTemplate('uswf/filterfinder/yotpo_update.phtml');

                $this->getResponse()->setBody( Zend_Json::encode(array(
                    'listing' => Mage::helper('uswf_filterfinder')->getProductListing($collection),
                    'html' => $productList->toHtml() . $yotpoUpdateBlock->toHtml()
                )));
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
        $this->loadLayout(false);

        if ($this->getRequest()->isXmlHttpRequest()) {
            $filterFinderBlock = $this->getLayout()->createBlock('lyonscg_filterfinder/filterFinder');
            $responce = $filterFinderBlock->prepareProductCollection();
            $productList = $this->getLayout()->createBlock('lyonscg_filterfinder/product_list');
            $productList->setProductCollection($responce);
            $productList->setTemplate('filterfinder/list.phtml');

            $yotpoUpdateBlock = $this->getLayout()->createBlock('core/template');
            $yotpoUpdateBlock->setTemplate('uswf/filterfinder/yotpo_update.phtml');

            $this->getResponse()->setBody( Zend_Json::encode(array(
                'listing' => Mage::helper('uswf_filterfinder')->getProductListing($responce),
                'html' => $productList->toHtml() . $yotpoUpdateBlock->toHtml()
            )));
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
