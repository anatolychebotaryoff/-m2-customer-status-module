<?php
/*------------------------------------------------------------------------
# Websites: http://www.magentothem.com/
-------------------------------------------------------------------------*/ 
class Wagento_Custom_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $skuCharity = Mage::getStoreConfig('cms/watercharity/sku');
        $response = array();
        $cart = Mage::getSingleton('checkout/cart');
        $product_id = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->getIdBySku($skuCharity);

        if ($product_id) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($product_id);

            if ($product) {
                $cart->addProduct($product, array($cart->getItemsCount() + 1));
                $cart->save();

                $number = Mage::helper('checkout/cart')->getSummaryCount();
                $total = Mage::getSingleton('checkout/session')->getQuote()->getGrandTotal();
                $totalPrice = Mage::helper('checkout')->formatPrice($total, false);
                $response['status'] = 'success';
                $response['number'] = $number;
                $response['totalprice'] = $totalPrice;
            }
            else {
                $response['status'] = 'fail';
                error_log("can't find product id: $product_id");
            }
        }
        else {
            $response['status'] = 'fail';
            error_log("can't find product sku: charity-product1");
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;

    }
}