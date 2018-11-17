<?php
/**
 * Air Filter result page block
 *
 * @category    Lyonscg
 * @package     Lyonscg_AirFilter
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 */

class Lyonscg_AirFilter_Block_Resultset extends Mage_Catalog_Block_Product_Abstract
{
    public $size = '';
    public $currentProduct = NULL;
    public $sliderPosition = 2;

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }


    public function setSliderPosition($sliderPosition)
    {
        $this->sliderPosition = $sliderPosition;
    }

    public function getSliderPosition()
    {
        return $this->sliderPosition;
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
     * taking store options of particular mpr attribute
     *
     * @param $key
     * @return mixed
     */
    public function getMervOptionsById($key){
        $attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", "mpr_compare_".$key);
        return $attribute_details->getSource()->getAllOptions(false);
    }

    /**
     * taking admin options labels of particular mpr attribute
     *
     * @param $key
     * @return array
     */
    public function getMervAdminLabel($key){
        $attribute = Mage::getSingleton("eav/config")->getAttribute("catalog_product", "mpr_compare_".$key);
        $_collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setStoreFilter(0)
            ->setAttributeFilter($attribute->getId())
            ->load();
        $items = $_collection->getItems();
        $result = array();
        $buffer = array();
        $position = array();
        foreach($items as $item){
            $buffer['label'] = $item->getValue();
            $buffer['position'] = $item->getSortOrder();
            $position[] = $item->getSortOrder();
            $result[] = $buffer;
        }
        array_multisort($position, SORT_ASC, $result);
        return $result;
    }

    /**
     * preparing product collection with given attributes and taking the first one
     *
     * @param $catId
     * @param $mervSuffix
     * @param $sizeAttrValue
     * @return bool
     */
    public function prepareProduct($catId, $mervSuffix, $sizeAttrValue)
    {
        $_sizeAttrCode = Mage::getStoreConfig('lyonscg_airfilter/air_filter_details/dfs_size_attr_code');
        $_category = Mage::getModel('catalog/category')->load($catId);
        $_productCollection = $_category->getProductCollection();
        $_productCollection->addAttributeToFilter($_sizeAttrCode,
            array('eq' => Mage::getResourceModel('catalog/product')
                ->getAttribute($_sizeAttrCode)
                ->getSource()
                ->getOptionId($sizeAttrValue)))
            ->addAttributeToFilter('mpr',
                array('eq' =>
                Mage::getResourceModel('catalog/product')
                    ->getAttribute('mpr')
                    ->getSource()
                    ->getOptionId("MPR:".$mervSuffix)))
            ->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds())
            ->load();
        $_products = $_productCollection->getItems();
        if($_products && is_array($_products)){
            $_firstProduct = array_shift($_products);
            $_product = Mage::getModel('catalog/product')->load($_firstProduct->getEntityId());
            $this->currentProduct = $_product;
            return true;
        } else {
            return false;
        }
    }

    /**
     * this function makes "text" from "text[text]"
     *
     * @param $text
     * @return string
     */
    public function removeFormatText($text){
        $text = substr($text, 5);
        return substr($text, 0, -1);
    }

    /**
     * do not save cache
     *
     * @param string $data
     * @return bool|Mage_Core_Block_Abstract
     */
    protected function _saveCache($data)
    {
        return false;
    }
}