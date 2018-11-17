<?php

//require_once 'Mage/Checkout/controllers/CartController.php';
require_once  Mage::getModuleDir('controllers', 'Idev_OneStepCheckout').DS.'CartController.php';

//class Sam_CartCustomOptions_CartController extends Mage_Checkout_CartController
class Sam_CartCustomOptions_CartController extends Idev_OneStepCheckout_CartController
{

  public function deloptionAction() {

    $id = (int) $this->getRequest()->getParam('id');
    $option_id = (int) $this->getRequest()->getParam('option_id');

    $quoteItem = null;
    $cart = $this->_getCart();

    if ($id && $option_id) {

        $quoteItem = $cart->getQuote()->getItemById($id);
        if ($quoteItem) {

          $optionIds = $quoteItem->getOptionByCode('option_ids');

          if ($optionIds) {
            $option_id =  $optionIds->getValue();

            if (!empty($option_id)) {

              $option = $quoteItem->getOptionByCode('option_' .  $option_id );
              if ($option) {

                $option->delete();
                $optionIds->delete();

                $info_buy_req = $quoteItem->getOptionByCode('info_buyRequest');
                if ($info_buy_req) {

                  $unserialized = unserialize($info_buy_req->getValue());

                  if (!empty($unserialized['options'][$option_id])) {

                    $unserialized['options'][$option_id] = '';
                    $info_buy_req->setValue(serialize($unserialized));

                  }

                }

                $quoteItem->save();
                $cart->getQuote()->save();
                $message = $this->__('Option has been deleted.');
                $this->_getSession()->addSuccess($message);

              }

            }

          }

        }

    }

    $this->getResponse()->setRedirect(Mage::helper('checkout/cart')->getCartUrl());


  }


  public function setoptionAction() {

    $id = (int) $this->getRequest()->getParam('id');
    $option_id = (int) $this->getRequest()->getParam('option_id');
    $value_id = (int) $this->getRequest()->getParam('value_id');

    $quoteItem = null;
    $cart = $this->_getCart();

    if ($id && $option_id && $value_id) {

        $quoteItem = $cart->getQuote()->getItemById($id);
        if ($quoteItem) {

          foreach ($quoteItem->getProduct()->getOptions() as $option) {

              //var_dump($option->getData());

              foreach ($option->getValues() as $v) {

                 if ($v['option_id'] == $option_id
                    && $v['option_type_id'] == $value_id) {

                   $quoteItem->addOption(array(

                     'item_id' => $id,
                     'product_id'=> $option['product_id'],
                     'code'=> 'option_ids',
                     'value'=> $v['option_id']

                   ))->save();


                    $quoteItem->addOption(array(

                      'item_id' => $id,
                      'product_id'=> $option['product_id'],
                      'code'=> 'option_' . $v['option_id'],
                      'value'=> $v['option_type_id']

                    ))->save();

                    $info_buy_req = $quoteItem->getOptionByCode('info_buyRequest');
                    if ($info_buy_req) {

                      $unserialized = unserialize($info_buy_req->getValue());

                      if (!empty($unserialized['options'][$v['option_id']])) {

                        $unserialized['options'][$v['option_id']] = $v['option_type_id'];
                        $info_buy_req->setValue(serialize($unserialized));


                      }

                    }

                    $quoteItem->save();
                    $cart->getQuote()->save();
                    $message = $this->__('Option has been added.');
                    $this->_getSession()->addSuccess($message);

                 }


              }


          }

          /*foreach ($quoteItem->getOptions() as $key => $option) {
            var_dump($option->getData());
          }*/

        }

    }

    $this->getResponse()->setRedirect(Mage::helper('checkout/cart')->getCartUrl());


  }





}
