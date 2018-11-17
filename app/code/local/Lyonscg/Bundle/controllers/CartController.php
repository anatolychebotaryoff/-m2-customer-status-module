<?php
/**
 * Controller for adding bundles from CLP
 *
 * @category   Lyons
 * @package    Lyonscg_Bundle
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Valentin Ponomarenko <vponomarenko@lyonscg.com>
 */
class Lyonscg_Bundle_CartController extends Mage_Core_Controller_Front_Action
{
    public function addAction()
    {
        $product = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('id'));
        $selectionCollection = $product->getTypeInstance(true)->getSelectionsCollection(
            $product->getTypeInstance(true)->getOptionsIds($product), $product
        );
        
        $bundleOptions = array();
        foreach ($selectionCollection as $option) {
            $bundleOptions[$option->getOptionId()] = $option->getSelectionId();
        }
        
        $params = array(
            'product'           => $product->getId(),
            'related_product'   => null,
            'bundle_option'     => $bundleOptions,
            'qty'               => 1
        );
        
        $cart = Mage::getSingleton('checkout/cart');
        $cart->addProduct($product, $params);
        $cart->save();
        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
        $message = $this->__('%s was added to your shopping cart.', $product->getName());
        Mage::getSingleton('checkout/session')->addSuccess($message);
        
        $this->getResponse()->setRedirect('/checkout/cart');
    }
}