<?php
/**
 * Horizontal.php
 *
 * @category    USWF
 * @package     USWF_Banners
 * @copyright
 * @author
 */
class USWF_Banners_Model_Source_Position_Horizontal extends Mage_Catalog_Helper_Data
{
    const LEFT = 'left';
    const RIGHT = 'right';

    public function toOptionArray()
    {
        return array(
            array('value' => self::LEFT, 'label' => Mage::helper('uswf_banners')->__('Left')),
            array('value' => self::RIGHT, 'label' => Mage::helper('uswf_banners')->__('Right'))
        );
    }
}