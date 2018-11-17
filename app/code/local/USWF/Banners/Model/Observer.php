<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_Banners
 * @copyright   
 * @author
*/
class USWF_Banners_Model_Observer
{
    const USWF_BANNERS_CONFIG_PATH = 'uswf_banners';
    
    const HASH_PREFIX = 'b';

    /**
     * Custom save of banners config
     *
     * @param Varien_Event_Observer $observer
     *
     * @return USWF_Banners_Model_Observer
     */
    public function uswfbannersChanged(Varien_Event_Observer $observer) {
        $banners = Mage::getConfig()->getNode(self::USWF_BANNERS_CONFIG_PATH, 'default');
        $banners = $banners ? $banners->asArray() : array();
        $changed = false;
        foreach ($banners as $nodeName => $banner) {
            if ($nodeName == 'default' && !empty($banner['banner_name'])) {
                $hashName = self::HASH_PREFIX . md5($banner['banner_name']);
            } elseif (empty($banner['banner_name'])) {
                $hashName = false;
            } else {
                unset($banner['banner_name']);
                $hashName = $nodeName;
            }
            if ($hashName) {
                foreach ($banner as $field => $data) {
                    Mage::getConfig()->saveConfig(self::USWF_BANNERS_CONFIG_PATH . '/' . $hashName . '/' . $field, $data);
                    Mage::getConfig()->deleteConfig(self::USWF_BANNERS_CONFIG_PATH . '/' . 'default' . '/' . $field);
                    $changed = true;
                }
            }
        }
        if ($changed) {
            Mage::app()->getCacheInstance()->cleanType('config');
        }
        return $this;
    }

    /**
     * Initialize of uswf banners
     *
     * @param Varien_Event_Observer $observer
     *
     * @return USWF_Banners_Model_Observer
     */
    public function uswfbannersInit(Varien_Event_Observer $observer) {
        $sections = $observer->getEvent()->getConfig()->getNode('sections')->descend(
            USWF_Banners_Block_System_Config_Form::USWF_BANNERS_CONFIG_PATH
        );
        if ($sections) {
            $indexes = Mage::getConfig()->getNode(
                'default' . '/' . USWF_Banners_Block_System_Config_Form::USWF_BANNERS_CONFIG_PATH
            );
            if (!empty($indexes)) {
                $indexes = $indexes->asArray();
                $i = 1;
                foreach ($indexes as $nodeName => $indexElement) {
                    if ($nodeName !== 'default') {
                        $path = 'groups/' . $nodeName;
                        if (!$sections->descend($path)) {
                            Mage::helper('uswf_banners')->setBannerConfig($sections, $indexElement, $path, $i++);
                        }
                    }
                }
            }
        }
        return $this;
    }
}