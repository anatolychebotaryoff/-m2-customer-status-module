<?php
/**
 * Attribute Selection for Product Compare Widget
 *
 * @category  Lyons
 * @package   Lyonscg_ComparedTo
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 

class Lyonscg_ComparedTo_Model_Catalog_Product_Attribute_Widget_Chooser
{
    /**
     * Banner types getter
     * Invokes translations to labels.
     *
     * @param bool $sorted
     * @param bool $withEmpty
     * @return array
     */
    public function getTypes($sorted = true, $withEmpty = false)
    {
        $result = array();

        $notNeeded = array('has_options', 'old_id', 'created_at', 'weight_type', 'links_exist', 'sku_type',
                            'required_options', 'category_ids', 'updated_at', 'price_type', 'url_path');

        $attributes = Mage::getResourceModel('catalog/product_attribute_collection')->getItems();
        foreach ($attributes as $attribute) {
            if (in_array($attribute->getAttributeCode(), $notNeeded)) {
                continue;
            }
            $result[$attribute->getAttributeCode()] = $attribute->getFrontendLabel();
        }
        if ($sorted) {
            asort($result);
        }
        if ($withEmpty) {
            return array_merge(array('' => Mage::helper('enterprise_banner')->__('-- None --')), $result);
        }
        return $result;
    }

    /**
     * Get types as a source model result
     *
     * @param bool $simplified
     * @param bool $withEmpty
     * @return array
     */
    public function toOptionArray($simplified = false, $withEmpty = true)
    {
        $types = $this->getTypes(true, $withEmpty);
        if ($simplified) {
            return $types;
        }
        $result = array();
        foreach ($types as $key => $label) {
            $result[] = array('value' => $key, 'label' => $label);
        }
        return $result;
    }
}
