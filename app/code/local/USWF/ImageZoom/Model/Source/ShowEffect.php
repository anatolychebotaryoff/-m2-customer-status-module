<?php
/**
 * ShowEffect.php
 *
 * @category    USWF
 * @package     USWF_ImageZoom
 * @copyright
 * @author
 */
class USWF_ImageZoom_Model_Source_ShowEffect extends Mage_Catalog_Helper_Data
{
    const SHOW = 'show';
    const FADEIN = 'fadein';

    public function toOptionArray()
    {
        return array(
            array('value' => self::SHOW, 'label' => $this->__('Show')),
            array('value' => self::FADEIN, 'label' => $this->__('Fade in'))
        );
    }
}