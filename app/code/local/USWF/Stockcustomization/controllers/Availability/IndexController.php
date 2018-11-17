<?php

class USWF_Stockcustomization_Availability_IndexController extends Mage_Core_Controller_Front_Action
{
    public function updateAction()
    {
        $productId = (int)Mage::app()->getRequest()->getParam('product', null);
        $product = Mage::getModel('catalog/product')->load($productId);
        $product = Mage::helper('uswf_stockcustomization')->groupedSimpleItem($product);

        if (is_object($product)) {

        if (!$product->isEmpty()) {
            $block = $this->getLayout()
                ->createBlock('core/template')
                ->setTemplate('uswf/catalog/product/availability.phtml');
            $block->setProduct($product);
            $html = $block->toHtml();
            $this->getResponse()->setBody($html);
        }
        }
    }

}
