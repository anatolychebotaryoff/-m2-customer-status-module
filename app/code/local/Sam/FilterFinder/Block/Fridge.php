<?php
class Sam_FilterFinder_Block_Fridge extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{


    public function _toHtml()
    {
        $this->setTemplate('sam/filterfinder/fridge.phtml');
        return parent::_toHtml();
    }


}
