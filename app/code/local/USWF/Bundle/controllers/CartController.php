<?php
/**
 * Controller for adding bundles from CLP
 *
 * @category   Lyons
 * @package    Lyonscg_Bundle
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Valentin Ponomarenko <vponomarenko@lyonscg.com>
 */
include_once Mage::getModuleDir('controllers', 'Mage_Checkout') . DS . 'CartController.php';
class USWF_Bundle_CartController extends Mage_Checkout_CartController
{

    protected function _validateFormKey() {
        return true;
    }

    public function addAction()
    {
        if (!$this->_validateFormKey()) {
            $backUrl = $this->_getRefererUrl();
            $this->getResponse()->setRedirect($backUrl);
            return;
        }
        try {
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

            $this->_getSession()->setCartWasUpdated(true);
            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
            if (!$this->_getSession()->getNoCartRedirect(true)) {
                if (!$cart->getQuote()->getHasError()) {
                    $message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
                    $this->_getSession()->addSuccess($message);
                }
                $this->_goBack();
            }
        } catch (Mage_Core_Exception $e) {
            if ($this->_getSession()->getUseNotice(true)) {
                $this->_getSession()->addNotice(Mage::helper('core')->escapeHtml($e->getMessage()));
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->_getSession()->addError(Mage::helper('core')->escapeHtml($message));
                }
            }

            $url = $this->_getSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            }
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
            Mage::logException($e);
            $this->_goBack();
        }
    }
}
