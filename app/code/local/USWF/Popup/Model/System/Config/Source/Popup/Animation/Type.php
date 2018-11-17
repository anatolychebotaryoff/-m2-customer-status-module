<?php
/**
 * Type.php
 *
 * @category    USWF
 * @package     USWF_Popup
 * @copyright
 * @author
 */
class USWF_Popup_Model_System_Config_Source_Popup_Animation_Type
{
    const SIMPLE = 'simple';
    const FALLING = 'falling';
    const SLIDING = 'sliding';
    
    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::SIMPLE,
                'label' => Mage::helper('uswf_popup')->__('Simple')
            ),
            array(
                'value' => self::FALLING,
                'label' => Mage::helper('uswf_popup')->__('Falling')
            ),
            array(
                'value' => self::SLIDING,
                'label' => Mage::helper('uswf_popup')->__('Sliding')
            )
        );
    }
}