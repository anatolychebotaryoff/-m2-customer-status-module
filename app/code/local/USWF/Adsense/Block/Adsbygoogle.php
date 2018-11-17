<?php

class USWF_Adsense_Block_Adsbygoogle extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        if ($this->helper('uswf_adsense')->isEnabled()) {
            $html = "<div class='adsbygoogle-wrap'>".$this->getLayout()->createBlock('cms/block')->setBlockId($this->helper('uswf_adsense')->getBlockIdentifier())->toHtml();
            return $html."</div>";
        }
    }

}
