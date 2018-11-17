<?php
/**
 * Vertical.php
 *
 * @category    USWF
 * @package     USWF_Banners
 * @copyright
 * @author
 */
class USWF_Banners_Model_Source_Position_Vertical extends Mage_Catalog_Helper_Data
{
    const TOP = 'top';
    const BOTTOM = 'bottom';

    public function toOptionArray()
    {
        return array(
            array('value' => self::TOP, 'label' => Mage::helper('uswf_banners')->__('Top')),
            array('value' => self::BOTTOM, 'label' => Mage::helper('uswf_banners')->__('Bottom'))
        );
    }
}