<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$frontName = (string)Mage::getConfig()->getNode(USWF_PreviewCart_Helper_Data::XML_PATH_PREVIEWCART_FRONTNAME);

$noindexPatterns = Mage::getStoreConfig(USWF_PreviewCart_Helper_Data::XML_PATH_SEOSUITE_NOINDEX);
if (!preg_match('#' . $frontName . '#', $noindexPatterns)) {
    $newNoindexPatterns = $noindexPatterns . "\r\n/" . $frontName;
    Mage::getModel('core/config_data' )
        ->load(USWF_PreviewCart_Helper_Data::XML_PATH_SEOSUITE_NOINDEX, 'path')
        ->setValue($newNoindexPatterns)
        ->setPath(USWF_PreviewCart_Helper_Data::XML_PATH_SEOSUITE_NOINDEX)
        ->save();
    Mage::getConfig()->cleanCache();
}

$installer->endSetup();