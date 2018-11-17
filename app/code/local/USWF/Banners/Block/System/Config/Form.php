<?php
/**
 * Form.php
 *
 * @category    USWF
 * @package     USWF_Banners
 * @copyright
 * @author
 */

class USWF_Banners_Block_System_Config_Form extends Mage_Adminhtml_Block_System_Config_Form
{

    const USWF_BANNERS_CONFIG_PATH = 'uswf_banners';

    protected function _initObjects()
    {
        parent::_initObjects();
        $uswfBanners = $this->_configFields->getSection(self::USWF_BANNERS_CONFIG_PATH);
        $indexes = Mage::getConfig()->getNode('default' . '/' . self::USWF_BANNERS_CONFIG_PATH);
        if (!empty($indexes)) {
            $indexes = $indexes->asArray();
            $i = 1;
            foreach ($indexes as $nodeName => $indexElement) {
                $path = 'groups/' . $nodeName;
                if ($nodeName == 'default') {
                    Mage::helper('uswf_banners')->setBannerConfig($uswfBanners, $indexElement, $path, 0);
                } else {
                    Mage::helper('uswf_banners')->setBannerConfig($uswfBanners, $indexElement, $path, $i++);
                }
            }
        }
        return $this;
    }

}
