<?php

class USWF_Bestseller_Block_Widget extends CapacityWebSolutions_Bestseller_Block_Widget {

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->addPriceBlockType('grouped', 'core/template', 'bestseller/price.phtml');
        $this->addPriceBlockType('simple', 'core/template', 'bestseller/price.phtml');
        return $this;
    }

    public function getBestsellerProductNew() {
        $productSku = array_map('trim', explode(',',$this->getUswfChooseProducts()));
        if ($this->getChooseProducts() == 4 && count($productSku)) {
            $productCount = $this->getLimit();
            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('sku', array('in' => $productSku))
                ->setPageSize($productCount);
            return $collection;
        } else {
            return $this->getBestsellerProduct();
        }
    }

}