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
 * Storelocator Model
 *
 * @category 	Magestore
 * @package 	Magestore_Storelocator
 * @author  	Magestore Developer
 */
class Magestore_Storelocator_Model_Gmap extends Varien_Object {

    const GEOURL = 'maps.googleapis.com/maps/api/geocode/json?address=';
    const GPARAM = "&sensor=true&key=";
    const FOMAT_ADDRESS = "{{street}}";

    /**
     * @param $address
     * @return null
     */
    public function getCoordinates($address) {
        $address = $address ? $address : $this->getAddress();
        $this->setAddress($address);

        if (!$address)
            return;

        $address = $this->getFormualAddress();

        if (Mage::app()->getStore()->isCurrentlySecure()) {
            $url = 'https://';
        } else {
            $url = 'http://';
        }

        $url .= self::GEOURL;
        $url .= $address;
        $url .= self::GPARAM;

        try {
            $result = Mage::helper('storelocator')->getResponseBody($url);
            $result = Zend_Json_Decoder::decode($result);
            if ($result['status'] != 'OK') {
                $url .= $this->getGoogleAPI();
                $result = Mage::helper('storelocator')->getResponseBody($url);
                $result = Zend_Json_Decoder::decode($result);
                if ($result['status'] == 'OK') {
                    return $result['results']['0']['geometry']['location'];
                }
                return null;
            } else {
                return $result['results']['0']['geometry']['location'];
            }
        } catch (Exception $e) {
            
        }

        return null;
    }

    /**
     * return formual address
     */
    public function getFormualAddress() {
        $address = $this->getAddress();
        if ($address['zipcode'])
            $str = $address['street'] . ' ' . $address['zipcode'] . ' ' . $address['city'] . ' ' . $address['region'] . ' ' . $address['country'];
        else
            $str = $address['street'] . ' ' . $address['city'] . ' ' . $address['region'] . ' ' . $address['country'];

        $formatedaddress = self::FOMAT_ADDRESS;
        $formatedaddress = str_replace(
                '{{street}}', $str, $formatedaddress
        );

        $formatedaddress = str_replace(' ', '+', $formatedaddress);
        return $formatedaddress;
    }

    /**
     * return google api
     */
    public function getGoogleAPI() {

        return Mage::helper('storelocator')->getConfig('gkey');
    }

}
