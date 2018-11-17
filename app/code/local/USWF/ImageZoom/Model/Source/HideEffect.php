<?php
/**
 * HideEffect.php
 *
 * @category    USWF
 * @package     USWF_ImageZoom
 * @copyright
 * @author
 */
class USWF_ImageZoom_Model_Source_HideEffect extends Mage_Catalog_Helper_Data
{
    const HIDE = 'hide';
    const FADEOUT = 'fadeout';

    public function toOptionArray()
    {
        return array(
            array('value' => self::HIDE, 'label' => $this->__('Hide')),
            array('value' => self::FADEOUT, 'label' => $this->__('Fade out'))
        );
    }
}