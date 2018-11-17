<?php

class USWF_LinksCatalog_Block_Adminhtml_Catalog_Product_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Attributes {

    /**
     * Hide the contaminants_subsidiary attribute on Product attributes tab
     *
     * @param $attributes
     * @return $this
     */
    public function setGroupAttributes($attributes){
        foreach ($attributes as $key => $attribute) {
            if ($attribute->getAttributeCode() == USWF_LinksCatalog_Helper_Data::CONTAMINANTS_SUBSIDIARY) {
                unset($attributes[$key]);
            }
        }
        $this->setData('group_attributes', $attributes);
        return $this;
    }

}