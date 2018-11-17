<?php
/**
 * data-install-0.0.1.php
 * 
 * @category    USWF
 * @package     USWF_Popup
 * @copyright   
 * @author      
*/

/** Install dummy static block **/

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

if(!function_exists('installStaticBlock')) {
    function installStaticBlock($title, $identifier, $content) {
        $block = Mage::getModel('cms/block');
        $block->setTitle($title);
        $block->setIdentifier($identifier);
        $block->setStores(array(0));
        $block->setIsActive(1);
        $block->setContent($content);
        $block->save();
        return $block->getId();
    }
}

$newBlockId = installStaticBlock(
    'Dummy USWF PopUp',
    'uswf_popup',
    '<span class="b-close"><span>X</span></span><br/><h1>Test Caption</h1><p>Sample USWF popup</p>'
);

/** Set this block as default for new extension **/

$data = array(
    'uswf_popup/configuration/cms_block' => $newBlockId
);

foreach ($data as $path => $value) {
    Mage::getModel('core/config')->saveConfig($path, $value);
}

$installer->endSetup();