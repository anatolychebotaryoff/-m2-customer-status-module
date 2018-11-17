<?php
/**
 * Banners.php
 *
 * @category    USWF
 * @package     USWF_Banners
 * @copyright
 * @author
 */
class USWF_Banners_Model_Source_Pdp_Banners extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions($withEmpty = true)
    {
        $banners = Mage::getStoreConfig(USWF_Banners_Model_Observer::USWF_BANNERS_CONFIG_PATH) ?
            Mage::getStoreConfig(USWF_Banners_Model_Observer::USWF_BANNERS_CONFIG_PATH) : array();
        $options = array();
        foreach ($banners as $node => $banner) {
            if ($node != 'default') {
                $options[] = array(
                    'label' => $banner['banner_name'],
                    'value' => $node
                );
            }
        }
        if ($withEmpty) {
            array_unshift($options, array('label' => '', 'value' => ''));
        }
        return $options;
    }
}