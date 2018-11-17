<?php

require_once 'Mage/Adminhtml/controllers/Sales/Order/CreateController.php';
class USWF_Catalog_Adminhtml_Sales_Order_CreateController extends Mage_Adminhtml_Sales_Order_CreateController {

    /**
     * Additional initialization
     *
     */
    protected function _construct()
    {
        parent::_construct();

        Mage::helper('catalog/product')->setSkipSaleableCheck(false);
    }

}