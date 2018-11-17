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
 * Storelocator Block
 * 
 * @category 	Magestore
 * @package 	Magestore_Storelocator
 * @author  	Magestore Developer
 */
class Magestore_Storelocator_Block_Storelocator extends Mage_Core_Block_Template {

    /**
     * prepare block's layout
     *
     * @return Magestore_Storelocator_Block_Storelocator
     */
    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getGoogleApiKey() {
        //return google Api Key
        return Mage::helper('storelocator')->getConfig('gkey');
    }

    public function getFacebookApiKey() {
        //return Facebook Api key
        return Mage::helper('storelocator')->getConfig('facekey');
    }

    public function cutLink($link) {
        if (strlen($link) > 12) {
            $link = substr($link, 0, 12) . "...";
        }
        return $link;
    }

    public function getListStore() {
        if ($this->hasData('stores')) {
            return $this->getData('stores');
        }

        $state = $this->getRequest()->getParam('state');
        $city = $this->getRequest()->getParam('city');
        $zipcode = $this->getRequest()->getParam('zipcode');
        $country_id = $this->getRequest()->getParam('country');
        $storeId = Mage::app()->getStore()->getStoreId();
        $collections = Mage::getModel('storelocator/storelocator')->getCollection()
                ->setStoreId($storeId)
                ->addFieldToFilter('status', 1);
        //Filter City               
        if (isset($city) && ($city != null)) {
            $city = trim($city);
            $collections->addFieldToFilter('city', array('like' => '%' . $city . '%'));
        }
        //Filter Country      
        if ($country_id != "nothing") {
            $country_id = trim($country_id);
            $collections->addFieldToFilter('country', array('like' => '%' . $country_id . '%'));
        }
        if (isset($state) && ($state != null)) {
            $state = trim($state);
            $collections->addFieldToFilter('state', array('like' => '%' . $state . '%'));
        }
        if (isset($zipcode) && ($zipcode != null)) {
            $zipcode = trim($zipcode);
            $collections->addFieldToFilter('zipcode', array('like' => '%' . $zipcode . '%'));
        }
        if ($this->getSortDefaultContry() == 'alphabeta') {
            $collections->setOrder('name', 'ASC');
        } else {
            $collections->setOrder('sort', 'DESC');
        }


        $this->setData('stores', $collections);
        return $collections;
    }

   

    function getTagList() {
        $storeCollection = Mage::getBlockSingleton('storelocator/storelocator')->getListStore();
        if (!$storeCollection->getSize()) {
            return null;
        }
        $storeIds = $storeCollection->getAllIds();
        $tagCollection = Mage::getModel('storelocator/tag')->getCollection()
                ->addFieldToFilter('storelocator_id', $storeIds);

        $tagCollection->getSelect()->group('value');
        $list = array();
        foreach ($tagCollection as $tag) {
            $list[] = array(
                'value' => $tag->getValue(),
                'ids' => trim($this->getIdsToTag($tag->getValue()), ',')
            );
        }

        return $list;
    }

    public function getIdsToTag($value) {
        $storeCollection = Mage::getBlockSingleton('storelocator/storelocator')->getListStore();
        $storeIds = $storeCollection->getAllIds();
        $tagCollection = Mage::getModel('storelocator/tag')->getCollection()
                ->addFieldToFilter('storelocator_id', $storeIds)
                ->addFieldToFilter('value', $value);
        $ids = '';
        foreach ($tagCollection as $tag) {
            $ids .= $tag->getStorelocatorId() . ',';
        }
        return $ids;
    }

    public function getStoreById() {
        $id = $this->getRequest()->getParam('id');
        $storeId = Mage::app()->getStore()->getStoreId();
        $collection = Mage::getModel('storelocator/storelocator')->setStoreId($storeId)->load($id);

        if (!$collection) {
            $this->_redirectUrl('storelocator/index');
        }
      
        return $collection;
    }

    public function isFbCommentEnable() {
        return Mage::helper('storelocator')->getConfig('allow_face');
    }

    public function addTopLinkStores() {
        if (Mage::helper('storelocator')->getConfig('enable') == 1) {
            $toplinkBlock = $this->getParentBlock();

            if ($toplinkBlock)
                $toplinkBlock->addLink($this->__('Store Locator'), 'storelocator/index/index', 'Store Locator', true, array(), 1);
        }
    }

    public function getListCountry() {
        return Mage::helper('storelocator')->getOptionCountry();
    }

    public function getImagebyStore($id_storelocator) {

        $collection = Mage::getModel('storelocator/image')->getCollection()->addFieldToFilter('storelocator_id', $id_storelocator)->addFieldToFilter('image_delete', 2);
        $url = array();
        foreach ($collection as $item) {
            if ($item->getData('name')) {
                $url[] = Mage::getBaseUrl('media') . 'storelocator/images/' . $item->getData('name');
            }
        }
        return $url;
    }

    public function getSearchConfig() {
        $choose_search = Mage::helper('storelocator')->getConfig('choose_search');
        $search_config = explode(',', $choose_search);
        return $search_config;
    }

    public function getImageIconByStore($id, $name) {
        return Mage::getBaseUrl('media') . 'storelocator/images/icon/' . $id . '/resize/' . $name;
    }

    public function getLanguage() {
        return Mage::helper('storelocator')->getConfig('language');
    }

    public function chekRadiusDefault() {
        return Mage::helper('storelocator')->getConfig('search_radius_default');
    }

    public function getRadius() {
        $radius = Mage::helper('storelocator')->getConfig('search_radius');
        $radius = explode(',', $radius);
        return $radius;
    }

    public function getUnitRadius() {
        return Mage::helper('storelocator')->getConfig('distance_unit');
    }

    public function getCoordinatesCurrent() {
        $address = array();
        $country_id = $this->getRequest()->getParam('country');
        $state = $this->getRequest()->getParam('state');
        $city = $this->getRequest()->getParam('city');
        $zipcode = $this->getRequest()->getParam('zipcode');
        $street = $this->getRequest()->getParam('address');
        if ($street) {
            $address['street'] = $street;
            $address['city'] = $city;
            $address['region'] = $state;
            $address['zipcode'] = $zipcode;
            if ($country_id != 'nothing') {
                $address['country'] = $country_id;
            }
            $coordinates = Mage::getModel('storelocator/gmap')
                    ->getCoordinates($address);
            if ($coordinates) {
                return $coordinates;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getLevelRadius() {
        $radius = (int) $this->getRequest()->getParam('radius');
        return $radius;
    }

    public function getLeveRadiusConvert() {
        $radius = (int) $this->getRequest()->getParam('radius');
        return $radius * $this->getUnitDistance();
    }

    public function getPageTitle() {
        return Mage::helper('storelocator')->getConfig('page_title');
    }

    public function getUnitDistance() {
        $unit = Mage::helper('storelocator')->getConfig('distance_unit');

        return ($unit == 'mi') ? 1609.3 : 1000;
    }

    public function getDefaultCountry() {
        return Mage::helper('storelocator')->getConfig('default_country');
    }

    public function getSortDefaultContry() {
        return Mage::helper('storelocator')->getConfig('sort_store');
    }

    public function getLatAndLng($country = null) {
        $geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$country&sensor=false");

        $output_deals = json_decode($geocode_stats);

        $latLng = $output_deals->results[0]->geometry->location;

        if ($latLng->lat && $latLng->lng) {
            return array($latLng->lat, $latLng->lng);
        }
        return null;
    }

}
