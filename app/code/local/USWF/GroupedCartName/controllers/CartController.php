<?php
/**
 * Overwrite Itoris_GroupedProductConfiguration_CartController controller
 * Overwrite Lyonscg_GroupedProductConfiguration_CartController controller
 * @category   USWF
 * @package    USWF_GroupedProductConfiguration
 * This file is an override of an override
 */

require_once 'Lyonscg/GroupedProductConfiguration/controllers/CartController.php';

class USWF_GroupedCartName_CartController extends Lyonscg_GroupedProductConfiguration_CartController
{

	public function addAction() {

        try {
            $this->_getSession()->getMessages(true);
            $url = $this->getRequest()->getParam('back_url');
            $nameUpdated = false;
            $this->_getSession()->setRedirectUrl($url);
            $params = $this->getRequest()->getParams();
            $associatedProductParams = array();
            $cart = $this->_getCart();
            $qtyCount = 0;
            foreach ($params as $paramName => $value) {
                if ($paramName == 'super_group' && is_array($params['super_group'])) {
                    foreach ($value as $productId => $qty) {
                        if ($qty >= 1) {
                            $product = Mage::getModel('catalog/product')->load((int)$productId);
                            $productOptions = $product->getOptions();
                            $options = '';
                            foreach ($productOptions as $optionId => $option) {
                                $options .=  $optionId . ',';
                            }
                            $options = substr($options, 0, -1);
                            $optionArray = array();
                            if (array_key_exists('options', $params)) {
                                foreach ($params['options'] as $idOption => $checkValue) {
                                    if (strpos($options, (string)$idOption) !== false) {
                                        $optionArray[$idOption] = $checkValue;
                                    }
                                }
                            }
                            $bundleOptions = array();
                            $bundleOptionsQty = array();
                            $nfsProduct = array_key_exists('nfs-product', $params) ? 1 : 0;
                            $related = array_key_exists('related_product', $params) ? $params['related_product'] : null;
                            $groupedParams = array();
                            if ($product->getTypeId() == 'simple' && !$nameUpdated && isset($params['grouped-product-name']) && isset($params['grouped-product-id']) && isset($params['grouped-product-url'])) {
                                $groupedParams = array(
                                    'grouped-product-name' => str_replace( '(3 Pack)', '', $params['grouped-product-name']) . ' ( 1 Pack )',
                                    'grouped-product-id' => $params['grouped-product-id'],
                                    'grouped-product-url' => $params['grouped-product-url']
                                );
                                $this->getRequest()->setParams($groupedParams);
                                $nameUpdated = true;
                            }
                            if ($product->getTypeId() == 'bundle') {
                                $selectionCollection = $product->getTypeInstance(true)->getSelectionsCollection(
                                    $product->getTypeInstance(true)->getOptionsIds($product), $product
                                );
                                foreach ($selectionCollection as $option) {

                                    //If this is a bundle product and it is an NFS page we want to update the name
                                    //stored in the quote item table as its used instead of product name from cart_item_renderer
                                    //USWF uses bundle product for a quantity > 1 and the name needs to reflect the qty increase
                                    if (isset($params['grouped-product-name']) && !$nameUpdated and $option->getSelectionQty()) {
                                        $groupedParams = array(
                                            'grouped-product-name' => str_replace( '(3 Pack)', '', $params['grouped-product-name']) . ' (' . floatval($option->getSelectionQty()) . ' Pack)',
                                            'grouped-product-id' => $params['grouped-product-id'],
                                            'grouped-product-url' => $params['grouped-product-url']
                                        );
                                        $this->getRequest()->setParams($groupedParams);
                                        $nameUpdated = true;
                                    }
                                }
			    }
                            if (array_key_exists('bundle_option', $params) && array_key_exists($productId, $params['bundle_option'])) {
                                $bundleOptions = $params['bundle_option'][$productId];
                            }
                            if (array_key_exists('bundle_option_qty', $params) && array_key_exists($productId, $params['bundle_option_qty'])) {
                                $bundleOptionsQty = $params['bundle_option_qty'][$productId];
                            }
                            $associatedProductParams = array(
                                //'uenc' => $params['uenc'],
                                'product' => (string)$productId,
                                'related_product' => $related,
                                'options' => $optionArray,
                                'super_attribute' => isset($params['super_product'][$productId]['super_attribute'])
                                    ? $params['super_product'][$productId]['super_attribute'] : null,
                                'bundle_option' => $bundleOptions,
                                'bundle_option_qty' => $bundleOptionsQty,
                                'qty' => $qty,
                                'nfs-product' => $nfsProduct
                            );
                            $associatedProductParams = array_merge($associatedProductParams, $groupedParams);
                            $cart->addProduct($product, $associatedProductParams);
							$cart->getQuote()->getItemsCollection()->getLastItem()->addOption(array(
									'code' => 'product_type',
									'value' => 'grouped',
									'product_id' => intval($productId),
								)
							);

                            if (!empty($related)) {
                                $cart->addProductsByIds(explode(',', $related));
                            }
                            $qtyCount++;
                        
                    }
                }
            }
	}
            if ($qtyCount) {
                $cart->save();
                Mage::dispatchEvent('checkout_cart_add_product_complete',
                    array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
                );
                if (!$this->_getSession()->getNoCartRedirect(true)) {
                    if (isset($params['product'])) {
                        $product = Mage::getModel('catalog/product')->load($params['product']);
                        if ($product->getId()) {
                            if ($nameUpdated) {
                                $message = Mage::helper('checkout')->__('%s was added to your shopping cart.', Mage::helper('core')->htmlEscape($params['grouped-product-name']));
                            } else {
                                $message = Mage::helper('checkout')->__('%s was added to your shopping cart.', Mage::helper('core')->htmlEscape($product->getName()));
                            }
                            Mage::getSingleton('core/session')->addSuccess($message);
                        }
                    }
                    if (!!intval(Mage::getStoreConfig('checkout/cart/redirect_to_cart'))) $this->_redirect('checkout/cart'); else $this->getResponse()->setRedirect($url);
                }
            } else {
                Mage::getSingleton('core/session')->addNotice('Please specify the quantity of product(s)');
                if ($url) {
                    $this->getResponse()->setRedirect($url);
                } else if (isset($params['product'])) {
                    $product = Mage::getModel('catalog/product')->load($params['product']);
                    $this->_redirectUrl($product->getProductUrl());
                } else {
                    $this->_redirect('checkout/cart');
                }
            }
	
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->getResponse()->setRedirect($url);
        } catch (Exception $e) {
            Mage::logException($e);
            $this->getResponse()->setRedirect($url);
        }
	
    }
}
