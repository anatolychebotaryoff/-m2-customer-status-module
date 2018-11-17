<?php

/**
 * CyberSource Payment CC Types Source Model
 *
 */
class SFC_CyberSource_Model_Source_Cctype extends Mage_Payment_Model_Source_Cctype
{
    public function getAllowedTypes()
    {
        // Lookup available types in payment method config
        $availableTypes = Mage::getStoreConfig('payment/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/cctypes');
        // Explode available types
        $availableTypes = explode(',', $availableTypes);

        return $availableTypes;
    }

    public function getCcAvailableTypes()
    {
        // Use parent to get option array
        $optionArray = $this->toOptionArray();
        // Parse option array into simple hash
        $availableTypes = array();
        foreach ($optionArray as $option) {
            $availableTypes[$option['value']] = $option['label'];
        }

        return $availableTypes;
    }

    public function getCcAvailableTypesCyberSourceFormat()
    {
        /** @var SFC_CyberSource_Helper_Gateway $gatewayHelper */
        $gatewayHelper = Mage::helper('sfc_cybersource/gateway');

        // Use parent to get option array
        $optionArray = $this->toOptionArray();
        // Parse option array into simple hash
        $availableTypes = array();
        foreach ($optionArray as $option) {
            $availableTypes[$gatewayHelper->mapMagentoCardTypeToCyberSource($option['value'])] = $option['label'];
        }

        return $availableTypes;
    }

}
