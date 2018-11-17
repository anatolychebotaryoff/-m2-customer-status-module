<?php

class USWF_LinksCatalog_Model_Catalog_Product_Attribute_Frontend_Primaryfiltermedia extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
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

        if ($value !='No')  {

          $url =  Mage::getBaseUrl() . str_replace(' ', '-', $value) . '.html';
          $value = '<a href="' . $url . '">' . $value . '</a>';
        }

        return $value;
    }



}
