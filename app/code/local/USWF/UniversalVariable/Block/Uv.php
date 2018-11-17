<?php 
class USWF_UniversalVariable_Block_Uv extends QuBit_UniversalVariable_Block_Uv {

   protected function _construct()
    {

        $cacheKeys = array(Mage::helper('core/url')->getCurrentUrl());
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        if ($customerGroupId) {
            $cacheKeys[] = $customerGroupId;
        }

        $this->addData(array(
            'cache_lifetime'    => 86400,
            'cache_tags'        => array(Mage_Catalog_Model_Product::CACHE_TAG),
            'cache_key'         => "UV_" . implode("_", $cacheKeys),
        ));
    }



}
