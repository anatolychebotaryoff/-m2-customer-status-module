<?php
class USWF_LogBacktrace_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Check is module exists and enabled in global config.
     *
     * @param string $moduleName the full module name, example Mage_Core
     * @return boolean
     */
    public function isEnabled()
    {
        if (!$this->isModuleEnabled() || !Mage::getStoreConfig('uswf_logbacktrace/general/active')) {
            return false;
        }
        return true;
    }

    /**
     * Extension version
     *
     * @return string
     */
    public function getExtensionVersion() {

        return (string)Mage::getConfig()->getNode()->modules->USWF_LogBacktrace->version;
    }

}