<?php
/**
 * Position.php
 *
 * @category    USWF
 * @package     USWF_ImageZoom
 * @copyright
 * @author
 */
class USWF_ImageZoom_Model_Source_Position extends Mage_Catalog_Helper_Data
{
    const RIGHT = 'right';
    const LEFT = 'left';
    const TOP = 'top';
    const BOTTOM = 'bottom';

    public function toOptionArray()
    {
        return array(
            array('value' => self::RIGHT, 'label' => $this->__('Right')),
            array('value' => self::LEFT, 'label' => $this->__('Left')),
            array('value' => self::TOP, 'label' => $this->__('Top')),
            array('value' => self::BOTTOM, 'label' => $this->__('Bottom'))
        );
    }
}