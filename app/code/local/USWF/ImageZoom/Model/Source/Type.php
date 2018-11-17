<?php
/**
 * Type.php
 *
 * @category    USWF
 * @package     USWF_ImageZoom
 * @copyright
 * @author
 */
class USWF_ImageZoom_Model_Source_Type extends Mage_Catalog_Helper_Data
{
    const STANDARD = 'standard';
    const INNERZOOM = 'innerzoom';
    const DRAG = 'drag';
    const REVERSE = 'reverse';

    public function toOptionArray()
    {
        return array(
            array('value' => self::STANDARD, 'label' => $this->__('Standard')),
            array('value' => self::INNERZOOM, 'label' => $this->__('Inner Zoom')),
            array('value' => self::DRAG, 'label' => $this->__('Drag')),
            array('value' => self::REVERSE, 'label' => $this->__('Reverse'))
        );
    }
}