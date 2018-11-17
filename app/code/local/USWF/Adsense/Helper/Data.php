<?php

class USWF_Adsense_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @return  Extension version string
     */
    public function getExtensionVersion() {

        return (string)Mage::getConfig()->getNode()->modules->USWF_Adsense->version;
    }

    /**
     * Check is module exists and enabled in global config.
     *
     * @param string $moduleName the full module name, example Mage_Core
     * @return boolean
     */
    public function isEnabled()
    {
        if (!$this->isModuleEnabled() || !Mage::getStoreConfig('uswf_adsense/general/active')) {
            return false;
        }
        return true;
    }

    public function getBlockIdentifier()
    {
        return Mage::getStoreConfig('uswf_adsense/general/sb_identifier');
    }
}