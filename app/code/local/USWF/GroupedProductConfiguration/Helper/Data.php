<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_GroupedProductConfiguration
 * @copyright
 * @author
 */
class USWF_GroupedProductConfiguration_Helper_Data extends Itoris_GroupedProductConfiguration_Helper_Data
{
    /**
     * Get settings
     *
     * @return Itoris_GroupedProductConfiguration_Model_Settings
     */
    public function getSettings($backend = false) {
        $key = $backend ? 'itoris_settings_bk' : 'itoris_settings_ft';
        if (!Mage::registry($key)) {
            Mage::register($key, parent::getSettings($backend));
        }
        return Mage::registry($key);
    }
}