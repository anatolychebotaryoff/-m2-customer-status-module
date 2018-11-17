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
 * Storelocator Resource Model
 * 
 * @category 	Magestore
 * @package 	Magestore_Storelocator
 * @author  	Magestore Developer
 */
class Magestore_Storelocator_Model_Mysql4_Storelocator extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct() {
        $this->_init('storelocator/storelocator', 'storelocator_id');
    }

    public function import($overwrite_store) {
        $write = $this->_getWriteAdapter();
        $write->beginTransaction();
        $fileName = $_FILES['csv_store']['tmp_name'];
        $csvObject = new Varien_File_Csv();
        $csvData = $csvObject->getData($fileName);
        $number = array('insert' => 0, 'update' => 0);
        $dataStore = array();
        $tags = array();
        $csvFields = array(
            0 => 'Name',
            1 => 'Status',
            2 => 'Address',
            3 => 'City',
            4 => 'State',
            5 => 'Country',
            6 => 'Zipcode',
            7 => 'Latitude',
            8 => 'Longtitude',
            9 => 'Fax',
            10 => 'Phone',
            11 => 'Email',
            12 => 'Link',
            13 => 'Zoom level',
            14 => 'Image name',
            15 => 'Tag store'
        );

        $resource = Mage::getSingleton('core/resource');
        $storeTable = $resource->getTableName('storelocator/storelocator');

        $collectionRewrite = Mage::getModel('storelocator/storelocator')->getCollection();
        $urlPathArr = array();
        foreach ($collectionRewrite as $collection) {
            $urlPathArr[] = $collection->getRewriteRequestPath();
        }

        if ($csvData[0] == $csvFields) {
            $arrayUpdate = $this->csvGetArrName($csvData);

            try {
                foreach ($csvData as $k => $v) {
                    if ($k == 0) {
                        continue;
                    }
                    if (count($v) <= 1 && !strlen($v[0])) {
                        continue;
                    }

                    if (!empty($v[0])) {
                        $data = array(
                            'name' => trim($v[0]),
                            'status' => strtolower($v[1]) == 'enabled' ? 1 : 2,
                            'address' => trim($v[2]),
                            'city' => trim($v[3]),
                            'state' => trim($v[4]),
                            'country' => trim($v[5]),
                            'zipcode' => trim($v[6]),
                            'latitude' => trim($v[7]),
                            'longtitude' => trim($v[8]),
                            'fax' => trim($v[9]),
                            'phone' => trim($v[10]),
                            'email' => trim($v[11]),
                            'link' => trim($v[12]),
                            'zoom_level' => trim($v[13]),
                            'image_icon' => trim($v[14])
                        );

                        $urlRewrite = $data['name'];
                        $urlRewrite = strtolower(trim($urlRewrite));
                        $urlRewrite = Mage::helper('storelocator')->characterSpecial($urlRewrite);

                        $data['rewrite_request_path'] = $urlRewrite;

                        if (in_array($v[0], $arrayUpdate)) {
                            if ($overwrite_store) {
                                $number['update'] ++;
                                $write->update($storeTable, $data, 'name = "' . $data['name'] . '"');
                                $model = Mage::getModel('storelocator/storelocator');
                                $collection = $model->getCollection()
                                        ->addFieldToFilter('name', array('eq' => $data['name']))
                                        ->getLastItem();
                                 $flag = false;
                                while (true) {
                                    if (!in_array($urlRewrite, $urlPathArr)) {
                                        break;
                                    }
                                    $urlRewrite .= '-' . $collection->getId();
                                    $flag = true;
                                }
                                 if ($flag) {
                                    $model->setId( $collection->getId());
                                    $model->setRewriteRequestPath($urlRewrite);
                                    $model->save();
                                }
                                $urlPathArr[] = $urlRewrite;
                                $stores = Mage::app()->getStores();
                                $model->setId($collection->getId());
                                foreach ($stores as $store) {
                                    $model->setStoreId($store->getStoreId())
                                            ->updateUrlKey($urlRewrite);
                                }

                                Mage::helper('storelocator')->deleteTagFormStore($collection->getId());
                                $tags = trim($v[15]);
                                $tag_arr = explode(',', $tags);
                                foreach ($tag_arr as $item) {
                                    $tag = Mage::getModel('storelocator/tag');
                                    $tagItem = trim($item);
                                    if (isset($tagItem)) {
                                        $tag->setData('value', $tagItem);
                                        $tag->setData('storelocator_id', $collection->getId());
                                        $tag->save();
                                    }
                                }
                            }
                            continue;
                        }

                        $dataStore[] = $data;
                        $tags[] = $v[15];
                        $number['insert'] ++;
                        if (count($dataStore) >= 200) {
                            $write->insertMultiple($storeTable, $dataStore);
                            $model = Mage::getModel('storelocator/storelocator');
                            $collection = $model->getCollection()
                                    ->getLastItem();
                            $storeId = $collection->getStorelocatorId() ? $collection->getStorelocatorId() : 1;

                            $tags = array_reverse($tags);
                            foreach ($tags as $tag) {
                                $tag = explode(',', $tag);
                                Mage::helper('storelocator')->saveTagToStore($tag, $storeId);
                                $collection = $model->load($storeId);
                                $urlRewrite = $collection->getRewriteRequestPath();
                                $flag = false;
                                while (true) {
                                    if (!in_array($urlRewrite, $urlPathArr)) {
                                        break;
                                    }
                                    $urlRewrite .= '-' . $collection->getId();
                                    $flag = true;
                                }
                                if ($flag) {
                                    $model->setId($storeId);
                                    $model->setRewriteRequestPath($urlRewrite);
                                    $model->save();
                                }
                                $urlPathArr[] = $urlRewrite;

                                $stores = Mage::app()->getStores();
                                $model->setId($storeId);
                                foreach ($stores as $store) {
                                    $model->setStoreId($store->getStoreId())
                                            ->updateUrlKey($urlRewrite);
                                }

                                $storeId--;
                            }
                            $dataStore = array();
                        }
                    }
                }
                if (!empty($dataStore)) {

                    $write->insertMultiple($storeTable, $dataStore);

                    $model = Mage::getModel('storelocator/storelocator');
                    $collection = $model->getCollection()
                            ->getLastItem();
                    $storeId = $collection->getStorelocatorId() ? $collection->getStorelocatorId() : 1;

                    $tags = array_reverse($tags);
                    foreach ($tags as $tag) {

                        $tag = explode(',', $tag);
                        Mage::helper('storelocator')->saveTagToStore($tag, $storeId);

                        $collection = $model->load($storeId);
                        $urlRewrite = $collection->getRewriteRequestPath();
                        $flag = false;
                        while (true) {
                            if (!in_array($urlRewrite, $urlPathArr)) {
                                break;
                            }
                            $urlRewrite .= '-' . $collection->getId();
                            $flag = true;
                        }
                        if ($flag) {
                            $model->setId($storeId);
                            $model->setRewriteRequestPath($urlRewrite);
                            $model->save();
                        }
                        $urlPathArr[] = $urlRewrite;
                        $stores = Mage::app()->getStores();
                        $model->setId($storeId);
                        foreach ($stores as $store) {
                            $model->setStoreId($store->getStoreId())
                                    ->updateUrlKey($urlRewrite);
                        }
                        $storeId--;
                    }
                }
                $write->commit();
            } catch (Exception $e) {
                $write->rollback();
                throw $e;
            }
        } else {
            Mage::throwException(Mage::helper('storelocator')->__('Please follow the sample file\'s format to import stores properly.'));
        }
        return $number;
    }

    public function csvGetArrName($csvData) {
        $array = array();
        foreach ($csvData as $k => $v) {
            if ($k == 0) {
                continue;
            }
            $array[] = $v[0];
        }
        $collections = Mage::getModel('storelocator/storelocator')
                ->getCollection()
                ->addFieldToFilter('name', array('in' => $array))
                ->getAllField('name');
        return $collections;
    }

}
