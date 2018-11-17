<?php
/**
 * Current class overrides core Product_List and allows to set product collection manually
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 *
 */

class Lyonscg_FilterFinder_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    /**
     * Setting of collection to private field
     *
     * @param $collection
     */
    public function setProductCollection($collection)
    {
        $this->_productCollection = $collection;
    }

    /**
     * Avoiding default class behavior when getting collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getProductCollection()
    {
        return $this->_productCollection;
    }

    /**
     * Ignoring default _beforeHtml() events for current block
     *
     * @return $this|Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        $this->_getProductCollection()->load();
        return $this;
    }

    /**
     * Retrieve Add Product to Compare Products List URL
     *
     * @param Mage_Catalog_Model_Product $product
     * @return string
     */
    public function getAddToCompareUrl($product)
    {
        return Mage::getUrl('catalog/product_compare/add', $this->_getUrlParams($product));
    }

    /**
     * Get parameters used for build add product to compare list urls
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  array
     */
    protected function _getUrlParams($product)
    {
        $param = Mage::getSingleton('core/session')->getStepFilterParam();
        return array(
            'product' => $product->getId(),
            Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED =>
                Mage::helper('core/url')->getEncodedUrl(Mage::getUrl('FridgeFilterFinder').$param)
        );
    }
}