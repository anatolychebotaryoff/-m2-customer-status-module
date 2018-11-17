<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_OneStepCheckout
 * @copyright
 * @author
 */
class USWF_OneStepCheckout_Helper_Customer_Address extends Mage_Catalog_Helper_Data
{
    protected $attributes = array();
    
    /**
     * Returns additional parts of validate class for attribute
     * 
     * @param string $attrCode
     * @return string
     */
    public function getAttrValidationClass($attrCode) 
    {
        /** @var $attribute Mage_Customer_Model_Attribute */
        $attribute = isset($this->attributes[$attrCode]) ? $this->attributes[$attrCode]
            : Mage::getSingleton('eav/config')->getAttribute('customer_address', $attrCode);
        $rules      = $attribute->getValidateRules();
        $classes = array();
        if (!empty($rules['min_text_length'])) {
            $classes[] = 'validate-length';
            $classes[] = 'minimum-length-' . $rules['min_text_length'];
        }
        if (!empty($rules['max_text_length'])) {
            if (!in_array('validate-length', $classes)) {
                $classes[] = 'validate-length';
            }
            $classes[] = 'maximum-length-' . $rules['max_text_length'];
        }

        return implode(' ', $classes);
    }
}