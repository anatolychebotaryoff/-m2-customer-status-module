<?php

class USWF_Uberfinder_IndexController extends Mage_Core_Controller_Front_Action {

    protected $productAttributes = array('sku', 'name', 'product_url', 'price', 'msrp', 'image', 'entity_id', 'brand');
    protected $filterAttributes = array('filter_finder_brand', 'filter_finder_style', 'filter_finder_location', 'filter_finder_removal');
    protected $priceAttributes = array('price', 'msrp');

    public function indexAction() {

        $response = array(
            "products" => Mage::helper("uswf_uberfinder")->getFilterProducts(),
            "attributes" => Mage::helper("uswf_uberfinder")->getAttributeInfo(),
            "partials" => Mage::helper("uswf_uberfinder")->getCmsBlock("uberfinder_fridge")
        );
        $this->getResponse()->setBody(Zend_Json::encode($response));
    }

    /*
     * Return products with finder attributes set
     */

    public function filterAction() {

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
        $out = array();
        foreach ($products as $product) {

            $_product = $product->getData();

            foreach ($this->filterAttributes as $attr) {
                $_product[$attr] = explode(",", $product[$attr] );
            }

            $_product["product_url"] = $product->getProductUrl();


            $out[] = $_product;

        }

        $this->getResponse()->setBody(Zend_Json::encode($out));

    }

    /**
     * Return attribute information for multi-select fields
     */
    public function attributeInfoAction()
    {
        $response = array();
        foreach ($this->filterAttributes as $code) {
            $attribute = Mage::getSingleton('eav/config')
                ->getAttribute(Mage_Catalog_Model_Product::ENTITY, $code);

            if ($attribute->usesSource()) {
                $options = $attribute->getSource()->getAllOptions(false);
                if (is_array($options)) {
                    foreach ($options as $val) {
                        $response[$code][] = (object)array('option_id' => $val['value'], 'option_value' => $val['label']);
                    }
                }
            }
        }



        $this->getResponse()->setBody(Zend_Json::encode(array($response)));

    }


}
