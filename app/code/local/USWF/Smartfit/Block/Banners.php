<?php
/**
 * Banners.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Block_Banners extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        $this->setTemplate('page/home_banners.phtml');
        return parent::_prepareLayout();
    }
}