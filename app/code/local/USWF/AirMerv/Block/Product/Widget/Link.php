<?php

class USWF_AirMerv_Block_Product_Widget_Link extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{


    protected function _beforeToHtml() {

        $ids = $this->getData('ids');
        if ($ids) {
            $ids = explode('}{', $ids);
            $cleanIds = array();
            foreach ($ids as $id) {
                $id = str_replace('{', '', $id);
                $id = str_replace('}', '', $id);
                $cleanIds[] = $id;
            }
            if (count($cleanIds)) {
                $products = $this->_getProductsByIDs($cleanIds);
                if ($products) {
                    $this->setProductCollection($products);
                }
            }
        }
        return parent::_beforeToHtml();

    }

    protected function _getProductsByIDs($ids) {
        $products = Mage::getModel('catalog/product')->getResourceCollection();
        $products->addAttributeToSelect('*');
        $products->addStoreFilter(Mage::app()->getStore()->getId());
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($products);
        $products->addFieldToFilter('entity_id', array('in' => $ids));
        $products->load();
        return $products;
    }

    /**
     * Load attribute by code to used on frontend
     *
     * @param $attributeName
     *
     * @return Mage_Eav_Model_Entity_Attribute_Abstract
     * @throws Mage_Core_Exception
     */
    protected function getAttribute($attributeName)
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, $attributeName);
        return $attribute;
    }





}
