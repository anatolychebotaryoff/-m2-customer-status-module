<?php
/**
 * Air Filter landing page block
 *
 * @category    Lyonscg
 * @package     Lyonscg_AirFilter
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 */

class Lyonscg_AirFilter_Block_Airfilter extends Mage_Core_Block_Template
{
    /**
     * preparing data for each category in brand selection area
     *
     * @return array
     */
    public function brandSelectData()
    {
        $_catNames = array();
        $_buffer = array();
        foreach($this->getSubCatIdsArray() as $catId){
            $_son = Mage::getModel('catalog/category')->load($catId);
            $_buffer['name'] = $_son->getName();
            $_buffer['url'] = $_son->getUrlPath();
            $_catNames[] = $_buffer;
        }
        return $_catNames;
    }

    /**
     * preparing data for each category in brand list area
     *
     * @return array
     */
    public function brandListData()
    {
        $_sortedCatList = $this->getChildrenCollection($this->getSubCatIdsArray(), true, "position");
        $resultData = array();
        $_buffer = array();
        foreach($_sortedCatList as $thing)
        {
            $category = $thing->getData();
            if(isset($category['air_filter_enabled']) && $category['air_filter_enabled']){
                $_son = Mage::getModel('catalog/category')->load($category['entity_id']);
                $_buffer['name'] = $_son->getName();
                $_buffer['url'] = $_son->getUrlPath();
                $_buffer['img_url'] = $_son->getImageUrl();
                $resultData[] = $_buffer;
            }
        }
        return $resultData;
    }

    /**
     * returns array of subcategories
     *
     * @return array
     */
    private function getSubCatIdsArray()
    {
        $configValue = Mage::getStoreConfig('lyonscg_airfilter/air_filter_details/dfs_brand_category');
        $_cat = Mage::getModel('catalog/category')->load($configValue);
        $_catList = $_cat->getChildren();
        return explode(",", $_catList);
    }

    /**
     * parsing each attribute option to find out its depth, list of depths are taken from config
     *
     * @return array
     */
    public function prepareSizesForFilter()
    {
        $attribute_code = Mage::getStoreConfig('lyonscg_airfilter/air_filter_details/dfs_size_attr_code');
        $attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $attribute_code);
        $depthList = $this->getConfigList();
        $options = $attribute_details->getSource()->getAllOptions(false);
        $formatDummy = " x ";
        $result = array();
        foreach($depthList as $depth){
            $bufferArray = array();
            foreach($options as $option){
                $endOfLabel = substr($option['label'], -4);
                if ($endOfLabel == $formatDummy.$depth){
                    $bufferArray[] = $option['label'];
                }
            }
            $result[$depth] = $bufferArray;
        }
        return $result;
    }

    /**
     * current function takes data from store configuration
     * with this function can be taken depth list, mprs list, categories list
     *
     * @param string $list
     * @return array
     */
    public function getConfigList($list = "depth")
    {
        $lookFor = "dfs_" . $list . "_list";
        $list = Mage::getStoreConfig('lyonscg_airfilter/air_filter_details/'.$lookFor);
        return explode(",", $list);
    }

    /**
     * returns collection of categories with passed attributes, alows to sort
     *
     * @param array $childrenIdArray
     * @param bool $sort
     * @param string $order
     * @return mixed
     */
    private function getChildrenCollection(array $childrenIdArray, $sort=true,$order='name')
    {
        $collection = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToFilter('entity_id', array('in' => $childrenIdArray))
            ->addAttributeToSelect('air_filter_enabled')
            ->addAttributeToSelect('entity_id');
        if ($sort) {
            return $collection->addOrderField($order);
        }
        return $collection;
    }
}
