<?php

class USWF_Adsense_Model_Adminhtml_System_Config_Backend_Sbidentifier extends Mage_Core_Model_Config_Data
{

    /**
     * Static Block Identifier exist
     *
     * @throws Mage_Core_Exception
     */
    protected function _beforeSave()
    {
        $groups = Mage::app()->getRequest()->getParams('groups');
        $active = $groups['groups']['general']['fields']['active']['value'];
        if ($active) {
            $value = $this->getValue();
            $adsense = Mage::getModel('cms/block')->load($value,'identifier');
            if ($adsense->isEmpty()) {
                Mage::throwException("Static Block Identifier $value does not exist");
            }
        }
    }

}