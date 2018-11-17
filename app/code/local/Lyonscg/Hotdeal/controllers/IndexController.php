<?php
/**
 * Controller for HotDeals
 *
 * @category   Lyons
 * @package    Lyonscg_HotDeal
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Valentin Ponomarenko <vponomarenko@lyonscg.com>
 * @author      Ashutosh Potdar <apotdar@lyonscg.com>
 */
class Lyonscg_Hotdeal_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $allParams = $this->getRequest()->getParams();
        
        $hotDealLinkParam = Mage::getStoreConfig('web/hotdeals/hotdeal_link_param');
        $groupId = $this->getRequest()->getParam($hotDealLinkParam);

        $redirectUrl = $this->getRequest()->getParam('url');

        if ($groupId) {

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
        if ($groupId) {
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
    
    protected function _getRedirectUrl($allParams)
    {
        $url = $this->getRequest()->getParam('url');

        // Fix for 'Fisher & Paykel' which has a space and an ampersand
        $url = str_replace(array(' ', '&'), array('+', '%26'), $url);
        
        $redirectUrl = '';
        if (strpos($url, '?') === false) {
            $redirectUrl = $url . '?';
        } else {
            $redirectUrl = $url . '&';
        }

        $numOfParams = count($allParams);
        $i = 0;
        foreach ($allParams as $key => $param) {
            $redirectUrl .= $key . '=' . $param;
            if(++$i != $numOfParams) {
                $redirectUrl .= '&';
            }
        }
        
        return $redirectUrl;
    }
}
