<?php
/**
 * File.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Block_Adminhtml_Banners_Renderer_Emptyfile extends Mage_Adminhtml_Block_Template
{
    protected function _toHtml() {
        return '<input type="file" name="banner_img[#{_id}]" value="#{image}"';
    }
}