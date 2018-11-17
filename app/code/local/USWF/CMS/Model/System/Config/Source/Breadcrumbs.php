<?php
/**
 * Breadcrumbs.php
 *
 * @category    USWF
 * @package     USWF_CMS
 * @copyright
 * @author
 */
class USWF_CMS_Model_System_Config_Source_Breadcrumbs
{
    const USE_STORE_DEFAULT = 0;
    const SHOW = 1;
    const HIDE = 2;

    public function getAllOptions()
    {
        return array(
            array(
                'value' => self::USE_STORE_DEFAULT,
                'label' => Mage::helper('uswf_popup')->__('Store Default')
            ),
            array(
                'value' => self::SHOW,
                'label' => Mage::helper('uswf_popup')->__('Show')
            ),
            array(
                'value' => self::HIDE,
                'label' => Mage::helper('uswf_popup')->__('Hide')
            )
        );
    }
}