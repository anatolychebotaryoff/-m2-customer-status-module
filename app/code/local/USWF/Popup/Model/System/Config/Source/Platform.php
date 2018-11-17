<?php
/**
 * Platform.php
 *
 * @category    USWF
 * @package     USWF_Popup
 * @copyright
 * @author
 */
class USWF_Popup_Model_System_Config_Source_Platform
{
    const MOBILE = 'mobile';
    const TABLET = 'tablet';
    
    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::MOBILE,
                'label' => Mage::helper('uswf_popup')->__('Mobile')
            ),
            array(
                'value' => self::TABLET,
                'label' => Mage::helper('uswf_popup')->__('Tablet')
            ),
        );
    }
}