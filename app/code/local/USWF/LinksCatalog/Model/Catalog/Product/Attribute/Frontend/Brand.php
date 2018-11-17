<?php

class USWF_LinksCatalog_Model_Catalog_Product_Attribute_Frontend_Brand extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
    /**
     * Retreive attribute value
     *
     * @param $object
     * @return mixed
     */
    public function getValue(Varien_Object $object)
    {
        return Mage::helper('uswf_brandcategory')->getBrandHtml($object);

        /*
         * Old way, a complete feature was developed for brands previously,
         * but this one was committed by Sergei anyway without using the module
         * it has some performance concerns with loading  categories and rewrites which is
         * very expensive DB operation. 
         *

        $values = $object->getData($this->getAttribute()->getAttributeCode());
        $values = array_map('trim', explode(',', $values));
        $conditions = array();
        foreach($values as $value){
            $conditions[] = array('like' => "%{$value}%");
        }
        $categoryByBrand = Mage::getResourceModel('catalog/category_collection')
            ->joinUrlRewrite()
            ->addAttributeToFilter('category_brand',array($conditions),'left')
            ->getItems();
        if (count($categoryByBrand)) {
            $result = array();
            foreach ($values as $value) {
                foreach ($categoryByBrand as $category) {
                    $productBrand = array_map('trim', explode(',', $category->getData('category_brand')));
                    $key = array_search($value, $productBrand);
                    if ($key !== false){
                        $url = Mage::helper('catalog/category')->getCategoryUrl($category);
                        $text = $this->getOption($value);
                        $result[$text] = '<a href="' . $url . '">' . $text . '</a>';
                    }
                }
            }
            $value = parent::getValue($object);
            $value  = str_replace(array_keys($result), array_values($result), $value);
        } else {
            $value = parent::getValue($object);
        }
        return $value;

        */

    }

}
