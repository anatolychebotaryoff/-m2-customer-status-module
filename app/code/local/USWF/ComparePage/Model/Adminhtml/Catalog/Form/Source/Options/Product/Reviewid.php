<?php

class USWF_ComparePage_Model_Adminhtml_Catalog_Form_Source_Options_Product_Reviewid extends Varien_Object
{

    public function toOptionArrayId()
    {
        $result = array();
        $storeId = $this->getStoreId();
        $product = $this->getProduct();
        if (!$storeId || !isset($product)) {
            $result = array_merge(array('' => Mage::helper('uswf_comparepage')->__('-- None --')), $result);
            return $result;
        }
        $review = Mage::helper('uswf_comparepage')->getYotpoReviewId($product, $storeId);
        foreach ($review as $key =>$val) {
            $result[] = array('value' => $key, 'label' => $key);
        }
        $result = array_merge(array('' => Mage::helper('uswf_comparepage')->__('-- None --')), $result);
        return $result;
    }

}