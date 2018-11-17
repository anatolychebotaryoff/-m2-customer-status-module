<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
try{
    $configWeekendsStartValue = array(
        '_1450707825653_654' => array(
            'day' => '5',
            'time' => array(
                0 => '16',
                1 => '00',
                2 => '00'
            ),
        )
    );
    $configWeekendsStart = Mage::getModel('core/config_data')
        ->load(USWF_Catalog_Helper_Data::SET_WEEKENDS_START_CONFIG_PATH, 'path')
        ->setValue(serialize($configWeekendsStartValue))
        ->setPath(USWF_Catalog_Helper_Data::SET_WEEKENDS_START_CONFIG_PATH)
        ->save();

    $configWeekendsStartValue = array(
        '_1450707825653_655' => array(
            'day' => '1',
            'time' => array(
                0 => '00',
                1 => '00',
                2 => '01'
            ),
        )
    );
    $configWeekendsStart = Mage::getModel('core/config_data')
        ->load(USWF_Catalog_Helper_Data::SET_WEEKENDS_END_CONFIG_PATH, 'path')
        ->setValue(serialize($configWeekendsStartValue))
        ->setPath(USWF_Catalog_Helper_Data::SET_WEEKENDS_END_CONFIG_PATH)
        ->save();

    Mage::getConfig()->cleanCache();
}catch (Exception $ex){
    Mage::logException($ex);
}


$installer->endSetup();