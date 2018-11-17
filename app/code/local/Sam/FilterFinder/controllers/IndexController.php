<?php

class Sam_FilterFinder_IndexController extends Mage_Core_Controller_Front_Action
{

    protected $filterAttributes = array('filter_finder_brand', 'filter_finder_style', 'filter_finder_location', 'filter_finder_removal');
    protected $floatAttributes = array('msrp', 'price');

    public function indexAction()
    {

        $idProduct = Mage::app()->getRequest()->getParam('product_id');
        $IsProductView = Mage::app()->getRequest()->getParam('IsProductView');
        $params = Mage::app()->getRequest()->getParams();
        $qty = $params['qty'];
        $related = $this->getRequest()->getParam('related_product');
        unset($params['product_id']);
        unset($params['IsProductView']);
        if ($related) unset($params['related_product']);
        try {
        $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($idProduct);
        }
        catch (Exception $e){
            Mage::logException($e->getMessage());
        }
        if ($product->getId()) {
            $session = Mage::getSingleton('core/session', array('name'=>'frontend'));

            $cart = Mage::getSingleton('checkout/cart');
            try {

//                if (($product->getTypeId() == 'simple' && !($product->getRequiredOptions()
//                            || $product->getHasOptions()))
//                    || count($params) > 0 || ($product->getTypeId() == 'virtual')
//                ) {
//                    if (!array_key_exists('qty', $params)) {
//                        $params['qty'] = $product->getStockItem()->getMinSaleQty();
//                    }
//
//
//                    }else
                if($product->getTypeId() == 'grouped'){
                        $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
                        foreach($associatedProducts as $child){
                                $super_group[$child->getId()] = $qty;
                            break;
                        }
                        //Create params for grouped product
                        $params = array('super_group' => $super_group);
                    }
                    try{
                        $cart->addProduct($product, $params);
                        $cart->save();
                        $session->setLastAddedProductId($product->getId());
                        $session->setCartWasUpdated(true);


                    } catch (Exception $e) {
                        die($e->getMessage());
                        $message = $this->__('Error on adding product to cart! ');
                        Mage::logException($message .$e->getMessage());


                        $session->addError($message);

                    }
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
        $this->_redirect('checkout/cart/');
    }


    public function productAction()
    {

        $cacheId = 'sam_product_filter';
        if (false !== ($data = Mage::app()->getCache()->load($cacheId))) {
            $response = unserialize($data);
        } else {
            $attributes = array_merge(array('sku', 'name', 'product_url', 'price', 'msrp', 'image', 'entity_id'), $this->filterAttributes);
            $productCollection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect($attributes)
//                ->addAttributeToFilter('type_id', array('eq' => 'simple'))
                ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addFieldToFilter('visibility', Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->load();
            $i = 0;
            $response = array();
            foreach ($productCollection as $product) {
                $i++;
                $field = array();
                $skip = false;
                $values = array();
                foreach ($attributes as $attrCode) {
                    $value = $product->getData($attrCode);
                    if (is_null($value)) {
                        $value = '';
                    }
                    if (in_array($attrCode, $this->filterAttributes)) {
                        //do not use products with empty filtered attributes
                        if (empty($value)) {
                            $skip = true;
//                        break;
                        }
                        if (!$skip) {
                            $value = $this->formatFilterable($value);
                        }
                    } elseif ($attrCode == 'product_url') {
                        $attrCode = 'url';
                        $value = $product->getProductUrl();
                    } elseif (in_array($attrCode, $this->floatAttributes)) {
                        $value = sprintf("%.02lf", $value);

                    }

                    $field[$attrCode] = $value;
                }
                if (!$skip) $response[] = $field;
            }

            //cache for 1 hour
            Mage::app()->getCache()->save(serialize($response), $cacheId, array($cacheId), 60 * 60 * 3);


        }
        $this->getResponse()->setBody(Zend_Json::encode($response));
    }

    protected function formatFilterable($value){
        $values = array();
        $valueExp = explode(',', $value);
        foreach ($valueExp as $key => $val2) {
            $values[] = (int)$val2;
        }

        return $values;
    }

    /**
     * Return meta information for filtarable attributes.
     */
    public function metaAction()
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
