<?php

class USWF_PreviewCart_Adminhtml_ConfigController extends Mage_Adminhtml_Controller_Action
{
  public function chooserAction()
    {
        switch ($this->getRequest()->getParam('attribute')) {
            case 'sku':
                $type = 'adminhtml/promo_widget_chooser_sku';
                break;
        }
        if (!empty($type)) {
            $block = $this->getLayout()->createBlock($type,'',array('js_form_object'=>'uswf_previewcart_general_upsell_product'));
            if ($block) {
                $this->getResponse()->setBody($block->toHtml());
            }
        }
    }
}
