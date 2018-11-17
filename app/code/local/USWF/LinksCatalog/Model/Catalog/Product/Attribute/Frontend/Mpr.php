<?php

class USWF_LinksCatalog_Model_Catalog_Product_Attribute_Frontend_Mpr extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{

    /**
     * Retreive lable
     *
     * @return string
     */
    public function getLabel()
    {
        $label = $this->getAttribute()->getFrontendLabel();
        if (($label === null) || $label == '') {
            $label = $this->getAttribute()->getAttributeCode();
        }
        if(!Mage::app()->getStore()->isAdmin()){
            $mprUrl = Mage::getStoreConfig(USWF_LinksCatalog_Helper_Data::CONFIG_PATH_MPR);
            if (!empty($mprUrl)) {
                $label = '<a href="' . $mprUrl . '">' . $label . '</a>';
            }
        }
        return $label;
    }

}
