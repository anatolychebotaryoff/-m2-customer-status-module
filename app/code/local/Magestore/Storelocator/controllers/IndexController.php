<?php

/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category 	Magestore
 * @package 	Magestore_Storelocator
 * @copyright 	Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license 	http://www.magestore.com/license-agreement.html
 */

/**
 * Storelocator Index Controller
 * 
 * @category 	Magestore
 * @package 	Magestore_Storelocator
 * @author  	Magestore Developer
 */
class Magestore_Storelocator_IndexController extends Mage_Core_Controller_Front_Action {

    /**
     * index action
     */
    public function indexAction() {
      
        if (Mage::helper('storelocator')->getConfig('enable') != 1) {
            Mage::getSingleton('core/session')->addError($this->__("Storelocator program is disabled or doesn't exist"));
            $this->getResponse()->setRedirect(Mage::getBaseUrl());
        }
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('storelocator')->getConfig('page_title'));
        $this->renderLayout();
    }

    public function viewAction() {
        if (Mage::helper('storelocator')->getConfig('enable') != 1) {
            Mage::getSingleton('core/session')->addError($this->__("Storelocator program is disabled or doesn't exist"));
            $this->getResponse()->setRedirect(Mage::getBaseUrl());
        }
        $id = $this->getRequest()->getParam('id');
        $storeId = Mage::app()->getStore()->getStoreId();
        $collection = Mage::getModel('storelocator/storelocator')->setStoreId($storeId)->load($id);
      
        $metaTitle = $collection->getMetaTitle() ? $collection->getMetaTitle() : $collection->getName();
        $metaContents = $collection->getMetaContents() ? $collection->getMetaContents() : $collection->getName();
        $metaKeywords = $collection->getMetaKeywords() ? $collection->getMetaKeywords() : $collection->getName();
        
        $this->loadLayout();
        $head = $this->getLayout()->getBlock('head');
        $head->setTitle($metaTitle);
        $head->setDescription($metaContents);
        $head->setKeywords($metaKeywords);
        $this->renderLayout();
    }

    public function loadstoreAction() {
        $collections = Mage::getBlockSingleton('storelocator/storelocator')->getListStore();
        if ($this->getRequest()->getParam('type') != 'map') {
            $storeId = Mage::app()->getStore()->getStoreId();
            
            $html = '';
            foreach ($collections as $row) {
                $urlrewrite = Mage::getModel('storelocator/storelocator')->loadByRequestPath($row->getRewriteRequestPath(), $storeId);
               
                if($urlrewrite->getId()){
                  $urlStore = Mage::getBaseUrl().$row->getRewriteRequestPath();
                }else{
                    $urlStore = Mage::app()->getStore()->getUrl('storelocator/index/view', array('id' => $row->getStorelocatorId()));
                }
                
                $store_image = Mage::helper('storelocator')->getBigImagebyStore($row->getStorelocatorId(), true);
                $html .= "<li id='s_store-" . $row->getStorelocatorId() . "' class='item'>";
                $html .= "<div class='istore'>";
                $html .= "<div onmouseover='hoverStart(" . $row->getStorelocatorId() . ")'  onmouseout='hoverStop(" . $row->getStorelocatorId() . ")'>";
                $html .= "<div  onclick='focusAndPopup(" . $row->getStorelocatorId() . "); return false;' class='info'>";
                $html .= "<p class='store_name'>" . $row->getName() . "</p>";
                $html .= "<p>" . $row->getAddress() . ", " . $row->getCity() . ", " . $row->getState() . "</p>";
                $html .= "<p>" . $row->getCountry() . ", " . $row->getZipcode() . "</p>";
                $html .= "<p>" . $row->getPhone() . "</p>";
                $html .= "</div>";
                $html .= "<p class='store_detail'><a href='" . $urlStore . "'>View Details</a></p>";
                $html .= "</div>";
                $html .= "</div>";
                if ($store_image) {
                    $html .= "<div class='istore-image'>";
                    $html .= "<img src='" . $store_image . "'  />";
                    $html .= "</div>";
                }
                $html .= "<p style='clear:both'><input onmouseover='hoverStart(" . $row->getStorelocatorId() . ")' class='position' type='text' value=''  placeholder='".$this->__('Enter a location')."' id='s_position-" . $row->getStorelocatorId() . "' /><input class='sbutton' onclick='calcRoute(" . $row->getStorelocatorId() . "," . $row->getLatitude() . "," . $row->getLongtitude() . ",1); return false;' type='image' src='" . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . "frontend/default/default/images/gobutton.gif'/></p>";
                $html .= "<div class='nav' onclick='navigation(" . $row->getStorelocatorId() . ")'></div>";
                $html .= "<div class='store_navigation' id='store_navigation-" . $row->getStorelocatorId() . "'></div>";
                $html .= "</li>";
            }

            $this->getResponse()->setBody($html);
        } else {
            $collections->getSelect()
                    ->reset(Zend_Db_Select::COLUMNS)
                    ->columns('storelocator_id')
                    ->columns('latitude')
                    ->columns('image_icon')
                    ->columns('longtitude')
                    ->columns('zoom_level')
            ;
            $results = array('stores' => $collections->getData());
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($results));
        }
    }

}
