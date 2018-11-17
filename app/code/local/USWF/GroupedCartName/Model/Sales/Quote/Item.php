<?php

class USWF_GroupedCartName_Model_Sales_Quote_Item extends Mage_Sales_Model_Quote_Item {

    /**
     * Not Represent options
     * Maximum quantity in cart setting for simple items
     *
     * @var array
     */
    protected $_notRepresentOptions = array('info_buyRequest', 'product_type');

    public function checkData() {
        parent::checkData();

        $notForSaleFlag = $this->getProduct()->getNotForSale();
        if (isset($notForSaleFlag) && $notForSaleFlag == 1 ){
            $this->setHasError(true)
                ->setMessage(Mage::helper('sales')->__('Not For Sale.'));
            $this->getQuote()->setHasError(true)
                ->addMessage(Mage::helper('sales')->__('Item \'%s\' error.', $this->getProduct()->getName()));
        }

    }
}