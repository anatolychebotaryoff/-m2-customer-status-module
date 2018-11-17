<?php

/**
 * Controller for HotDeals
 *
 **/

require_once  Mage::getModuleDir('controllers', 'Lyonscg_Hotdeal') . DS . 'IndexController.php';
class USWF_Hotdeal_IndexController extends Lyonscg_Hotdeal_IndexController {

    public function indexAction()
    {
        $allParams = $this->getRequest()->getParams();

        $hotDealLinkParam = Mage::getStoreConfig('web/hotdeals/hotdeal_link_param');
        $groupId = (int)$this->getRequest()->getParam($hotDealLinkParam, -1);

        $redirectUrl = $this->getRequest()->getParam('url');

        $collectionGroup = Mage::getModel('customer/group')->getCollection();
        $collectionGroup->addFieldToSelect('customer_group_id');
        $collectionGroup->addFieldToFilter('customer_group_id', $groupId);
        $collectionGroupCount = $collectionGroup->count();

        if ($groupId && $collectionGroupCount) {

            $cookieLifetime = Mage::getStoreConfig('web/hotdeals/cookie_customer_group');
            $cookie = Mage::getSingleton('core/cookie');
            $cookie->set('hd_groupid', $groupId, $cookieLifetime);

            $productUrlKey = str_replace(".html", "", $redirectUrl);

            $productsCollection = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->getCollection();

            $productEntity = $productsCollection->addAttributeToFilter('url_key', $productUrlKey )->getFirstItem();

            if ($productEntity) {
                $cookie->set('hd_groupid_'.$productEntity->getId(), $groupId, $cookieLifetime);
            }

            $customer_session = Mage::getSingleton('customer/session');
            $customer_session->setCustomerGroupId($groupId);
            Mage::getModel('sales/quote')->setCustomerGroupId($groupId);

        }


        // Ashutosh Potdar - Lyons Addition.
        // The FPC is not working at the moment as it should.
        // This fix will properly display Catalog Price Rules
        // but will have an additional parameter at the end of url
        if ($groupId && $collectionGroupCount) {
            $allParams['hotdeal'] = $groupId;
        }
        // Lyonscg Addition done.

        unset($allParams[$hotDealLinkParam]);
        unset($allParams['url']);
        if (!empty($allParams)) {
            $redirectUrl = $this->_getRedirectUrl($allParams);
        }

        $this->getResponse()->setRedirect('/' . $redirectUrl);
    }

}