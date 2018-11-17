<?php

class USWF_Uberfinder_Helper_Data extends Mage_Core_Helper_Abstract {

    protected $productAttributes = array('sku', 'name', 'product_url', 'price', 'msrp', 'image', 'entity_id', 'brand_actual');
    protected $filterAttributes = array('filter_finder_brand', 'filter_finder_style', 'filter_finder_location', 'filter_finder_removal');
    protected $priceAttributes = array('price', 'msrp');

    public function getCmsBlock( $blockId , $blockParams = null) {

        $block = Mage::getModel("cms/block")
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($blockId);

        if ($block->getId()) {

            if ( $blockParams ) {
                $filter = Mage::getModel("cms/template_filter");
                $filter->setVariables($blockParams);
                return $filter->filter($block->getContent());
            }
            return $block->getContent();

        }

    }

    public function getFilterProducts() {

        $attributes = array_merge( $this->productAttributes, $this->filterAttributes );

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED )
            ->addAttributeToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->addAttributeToFilter('not_for_sale', 0);

        foreach ($this->filterAttributes as $filterAttribute) {
            $products->addAttributeToFilter($filterAttribute, array('notnull' => true));
        }

        $products->addAttributeToSelect($attributes);
        $products->addAttributeToSelect("not_for_sale");
        $products->addMinimalPrice();
        $out = array();

        foreach ($products as $product) {
            $_product = $product->getData();
            foreach ($this->filterAttributes as $attr) {
                $_product[$attr] = array();
                $_product[$attr."_text"] = (array) $product->getAttributeText($attr);
                $attributeOptionList = explode(",", $product[$attr] );
                foreach ($attributeOptionList as $option) {
                    $_product[$attr][] = (int) $option;
                }
            }
            foreach ($this->priceAttributes as $attr) {
                $_product[$attr] = number_format( $product->getData( $attr ), 2);
            }
            $_product["product_url"] = $product->getProductUrl();
            $_product["image"] = (string)Mage::helper('catalog/image')->init($product->load( $product->getId() ), 'thumbnail')->resize(300);
            $out[] = $_product;
        }

        return $out;

    }

    public function getAttributeInfo() {

        $out = array();
        foreach ($this->filterAttributes as $code) {
            $attribute = Mage::getSingleton('eav/config')
                ->getAttribute(Mage_Catalog_Model_Product::ENTITY, $code);

            if ($attribute->usesSource()) {
                $options = $attribute->getSource()->getAllOptions(false);
                if (is_array($options)) {
                    foreach ($options as $val) {
                        $out[$code][] = (object)array('option_id' => $val['value'], 'option_value' => $val['label'], 'option_img' => Mage::helper('attributeoptionimage')
                            ->getAttributeOptionImage($val['value']));
                    }
                }
            }
        }


        return $out;
    }
}
