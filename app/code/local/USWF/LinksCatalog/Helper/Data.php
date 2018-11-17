<?php

class USWF_LinksCatalog_Helper_Data extends Mage_Core_Helper_Abstract {
    const CONFIG_PATH_MERV_RATING = 'uswf_linkscatalog/general/links_to_merv_rating';
    const CONFIG_PATH_MPR = 'uswf_linkscatalog/general/links_to_mpr';
    const CONTAMINANTS_SUBSIDIARY = 'contaminants_subsidiary';
    const PRIMARY_FILTER_MEDIA = 'primary_filter_media';

    public function getAttrContaminantsUrl($attributeCode){
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', USWF_LinksCatalog_Helper_Data::CONTAMINANTS_SUBSIDIARY);
        $attribute->setStoreId(0);
        $optionId = $attribute->getSource()->getOptionId($attributeCode);
        $attribute->setStoreId(Mage::app()->getStore()->getId());
        $value = $attribute->getSource()->getOptionText($optionId);
        if ($value == $attributeCode) {
            $value = null;
        }
        return $value;
    }
}
