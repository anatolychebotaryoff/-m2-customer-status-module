<?php
/**
 * Roitracker.php
 *
 * @category    USWF
 * @package     USWF_GoogleBase
 * @copyright
 * @author
 */
class USWF_GoogleBase_Helper_Roitracker extends Mage_Catalog_Helper_Data
{
    const CONFIG_PATH_ROI_TRACKER_SCRIPT_ENABLED = 'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Enabled';
    const CONFIG_PATH_ROI_TRACKER_SCRIPT = 'qubit_universalvariable/QuBit_OpenTag_Settings/Gate_Script';
    
    public function getGateScript() {
        return Mage::getStoreConfig(self::CONFIG_PATH_ROI_TRACKER_SCRIPT_ENABLED) ?
            Mage::getStoreConfig(self::CONFIG_PATH_ROI_TRACKER_SCRIPT) : '';
    }

}
