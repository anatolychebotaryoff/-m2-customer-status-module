<?php
/**
 * File.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Block_Adminhtml_Banners_Renderer_File extends Mage_Adminhtml_Block_Template
{
    protected function _toHtml() {
        return '<a href="' . rtrim(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA), '/') .
            '#{image}">#{image}</a>';
    }
}