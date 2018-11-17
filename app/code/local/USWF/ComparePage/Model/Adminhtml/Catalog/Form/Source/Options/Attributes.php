<?php

/**
 * Attribute Selection for Product Compare Widget
 */
class USWF_ComparePage_Model_Adminhtml_Catalog_Form_Source_Options_Attributes extends Varien_Object
{
    public static $_attributeSetDefault = array(
        'Fridge Filters' => array('certifications', 'capacity_gallons', 'life_months', 'media_primary_filter', 'warranty_guarantee'),
        'Air Filters'    => array('merv', 'dust', 'pet_dander', 'mold_spores', 'pollen', 'dust_mite_debris', 'smoke', 'tobacco_smoke_odor', 'bacteria', 'odor'),
        'Pool and Spa'   => array('certifications', 'capacity_gallons', 'life_months', 'media_primary_filter', 'warranty_guarantee'),
        'Water Filters'  => array('certifications', 'capacity_gallons', 'life_months', 'media_primary_filter', 'warranty_guarantee')
    );

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

    /**
     * Get types by default
     * @return array
     */
    public function getDefaultInForms()
    {
        $result = array();
        $_product = $this->getProduct();
        if (isset($_product)) {
            $attributeSetModel = Mage::getModel("eav/entity_attribute_set");
            $attributeSetModel->load($this->getProduct()->getAttributeSetId());
            $attributeSetName = $attributeSetModel->getAttributeSetName();
            if (array_key_exists($attributeSetName, self::$_attributeSetDefault)) {
                $result = implode(',', self::$_attributeSetDefault[$attributeSetName]);
            }
        }
        return $result;
    }

}
