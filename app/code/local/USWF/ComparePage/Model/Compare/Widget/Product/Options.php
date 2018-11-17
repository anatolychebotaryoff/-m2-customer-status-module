<?php

class USWF_ComparePage_Model_Compare_Widget_Product_Options extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('uswf_comparepage/compare_widget_product_options');
    }

    /**
     * @param $productId
     * @param $storeId
     * @return $this
     */
    public function loadByProductId($productId, $storeId) {
        $this->getResource()->loadByProductId($this, $productId, $storeId);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        return $this;
    }

}