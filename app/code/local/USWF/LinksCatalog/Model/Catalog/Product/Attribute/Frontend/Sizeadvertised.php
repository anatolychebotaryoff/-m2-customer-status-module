<?php

class USWF_LinksCatalog_Model_Catalog_Product_Attribute_Frontend_Sizeadvertised extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
    /**
     * Retreive attribute value
     *
     * @param $object
     * @return mixed
     */
    public function getValue(Varien_Object $object)
    {
        $values = $object->getData($this->getAttribute()->getAttributeCode());
        $values = array_map('trim', explode(',', $values));
        $conditions = array();
        foreach($values as $value){
            $conditions[] = array('like' => "%{$value}%");
        }
        $categoryByBrand = Mage::getResourceModel('catalog/category_collection')
            ->joinUrlRewrite()
            ->addAttributeToFilter('category_size_advertised',array($conditions),'left')
            ->getItems();
        if (count($categoryByBrand)) {
            $result = array();
            foreach ($values as $value) {
                foreach ($categoryByBrand as $category) {
                    $productBrand = array_map('trim', explode(',', $category->getData('category_size_advertised')));
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
    }

}
