<?php

class USWF_LinksCatalog_Model_Catalog_Product_Attribute_Frontend_Merv extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{

    /**
     * Retreive attribute value
     *
     * @param $object
     * @return mixed
     */
    public function getValue(Varien_Object $object)
    {
        $value = parent::getValue($object);
        $merv = str_replace('MERV:','',$value);
        if(is_numeric($merv)){
            $value = '<a href="' . Mage::getBaseUrl() . 'merv-' . $merv . '-rating.html">' . $value . '</a>';

        }
        return $value;
    }

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
            $mervRatingUrl = Mage::getStoreConfig(USWF_LinksCatalog_Helper_Data::CONFIG_PATH_MERV_RATING);
            if (!empty($mervRatingUrl)) {
                $label = '<a href="' . $mervRatingUrl . '">' . $label . '</a>';
            }
        }
        return $label;
    }

}
