<?php
/**
 * Js.php
 *
 * @category    USWF
 * @package     USWF_Design
 * @copyright
 * @author
 */
class USWF_Design_Helper_Js extends Mage_Core_Helper_Js
{
    /**
     * Retrieve JS translator initialization javascript
     *
     * @return string
     */
    public function getTranslatorScript()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            $script = 'var Translator = new Translate('.$this->getTranslateJson().');';
        } else {
            $script = 'addEvent(window, \'load\', function() {var Translator = new Translate('.$this->getTranslateJson().');});';
        }
        return $this->getScript($script);
    }
}
