<?php

class USWF_ComparePage_Model_Adminhtml_Catalog_Form_Source_Options_Active_Tabs extends Varien_Object
{
    public function toOptionArray()
    {
        return array(
            array(
                'label' => Mage::helper('uswf_comparepage')->__('Product Comparsion'),
                'value' => 'uswf_comparedto/product_widget_tabs_productcomparsion'
            ),
            array(
                'label' => Mage::helper('uswf_comparepage')->__('Instructions'),
                'value' => 'uswf_comparedto/product_widget_tabs_instructions'
            ),
            array(
                'label' => Mage::helper('uswf_comparepage')->__('FAQ'),
                'value' => 'uswf_comparedto/product_widget_tabs_faq'
            ),
            array(
                'label' => Mage::helper('uswf_comparepage')->__('Compatibility'),
                'value' => 'uswf_comparedto/product_widget_tabs_compatibility'
            ),
            array(
                'label' => Mage::helper('uswf_comparepage')->__('Details'),
                'value' => 'uswf_comparedto/product_widget_tabs_details'
            ),
        );
    }

    /**
     * Get by default
     * @return array
     */
    public function getDefaultInForms()
    {
        return array(
            'uswf_comparedto/product_widget_tabs_productcomparsion',
            'uswf_comparedto/product_widget_tabs_instructions',
            'uswf_comparedto/product_widget_tabs_faq',
            'uswf_comparedto/product_widget_tabs_compatibility',
            'uswf_comparedto/product_widget_tabs_details');
    }

}
