<?php
require_once  Mage::getModuleDir('controllers', 'Enterprise_Checkout') . DS . 'CartController.php';

class USWF_Checkout_CartController extends Enterprise_Checkout_CartController
{

    //TODO: As far as I can see - used only for customer account
    /**
     * Add to cart products, which SKU specified in request
     *
     * @return void
     */
    public function advancedAddAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*');
        }
        // check empty data
        /** @var $helper Enterprise_Checkout_Helper_Data */
        $helper = Mage::helper('enterprise_checkout');
        $items = $this->getRequest()->getParam('items');
        foreach ($items as $k => $item) {
            if (empty($item['sku'])) {
                unset($items[$k]);
            }
        }
        if (empty($items) && !$helper->isSkuFileUploaded($this->getRequest())) {
            $this->_getCustomerSession()->addError($helper->getSkuEmptyDataMessageText());
            $this->_redirectReferer();
            return;
        }
        //check product
        $bundleItems = array();
        foreach($items as $key => $_item){
            $_product = Mage::getModel('catalog/product')->loadByAttribute('sku',$_item['sku']);
            if(is_object($_product) && !$_product->isSaleable()){
                $this->_getCustomerSession()->addError("Item '{$_item['sku']}' error.");
                $this->_redirectReferer();
                return;
            }
            if(is_object($_product) && $_product->getTypeID() == 'bundle'){
                $selectionCollection = $_product->getTypeInstance(true)->getSelectionsCollection(
                    $_product->getTypeInstance(true)->getOptionsIds($_product), $_product
                );
                $bundleOptions = array();
                foreach ($selectionCollection as $option) {
                    $bundleOptions[$option->getOptionId()] = $option->getSelectionId();
                }
                $requestProduct = new Varien_Object();
                $requestProduct->setQty($_item['qty']);
                $requestProduct->setSku($_item['sku']);
                $requestProduct->setBundleOptions($bundleOptions);
                $bundleItems[$key] = $requestProduct;
                unset($items[$key]);
            }
        }

        try {
            // perform data
            if(count($bundleItems)){
                foreach($bundleItems as $bundleItem){
                    $this->_getFailedItemsCart()->prepareAddProductBySku($bundleItem->getSku(), $bundleItem->getQty(),
                        array(
                            'bundle_option' => $bundleItem->getBundleOptions()
                        ));
                }
            }
            $cart = $this->_getFailedItemsCart()
                ->prepareAddProductsBySku($items);
            $success = $cart->getSuccessedProductsCount();
            $cart->saveAffectedProducts();

            if ($success) {
                $this->_getSession()->addMessages($cart->getMessages());
            } else {
                $this->_getCustomerSession()->addMessages($cart->getMessages());
            }

            if ($cart->hasErrorMessage()) {
                Mage::throwException($cart->getErrorMessage());
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getCustomerSession()->addException($e, $e->getMessage());
        }

        if ($success) {
            $this->_redirect('checkout/cart');
        } else {
            $this->_redirectReferer();
        }
    }

    /**
     * Add to cart products from url
     * /checkout/cart/productAdd/sku/TIER1_D50S_612020_6_PACK/qty/2
     *
     * @return void
     */
    public function productAddAction()
    {
        $productSku = $this->getRequest()->getParam('sku');
        $qty = $this->getRequest()->getParam('qty' , 1);

        $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $productSku);
        //check product
        if (is_object($_product) && !$_product->isEmpty() ) {
            if(!$_product->isSaleable()){
                $this->_getCustomerSession()->addError(Mage::helper('enterprise_checkout')->__("Item %s not for sale.", $productSku));
                $this->_redirectReferer();
                return;
            }
        }
        try {
            // perform data
            /** @var $cart USWF_Checkout_Model_Cart */
            $cart = $this->_getFailedItemsCart();
            $this->_getFailedItemsCart()->prepareAddProductBySku($productSku, $qty, $this->getCartConfig($_product));
            $success = $cart->getSuccessedProductsCount();
            $cart->saveAffectedProducts();

            if ($success) {
                $this->_getSession()->addMessages($cart->getMessages());
            } else {
                $this->_getCustomerSession()->addMessages($cart->getMessages());
            }

            if ($cart->hasErrorMessage()) {
                Mage::throwException($cart->getErrorMessage());
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getCustomerSession()->addException($e, $e->getMessage());
        }

        if ($success) {
            $this->_redirect('checkout/cart');
        } else {
            $this->_redirectReferer();
        }
    }

    /**
     * Perform config
     *
     * @param $_product Mage_Catalog_Model_Product
     * @return array
     */
    public function getCartConfig($_product){
        $result = array();
        if($_product->getTypeID() == 'bundle'){
            $selectionCollection = $_product->getTypeInstance(true)->getSelectionsCollection(
                $_product->getTypeInstance(true)->getOptionsIds($_product), $_product
            );
            $bundleOptions = array();
            foreach ($selectionCollection as $option) {
                $bundleOptions[$option->getOptionId()] = $option->getSelectionId();
            }
            $result = array('bundle_option' => $bundleOptions);
        }
        return $result;
    }
}