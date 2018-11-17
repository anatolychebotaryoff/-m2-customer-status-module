<?php

class USWF_Addressvalidation_Model_Observer
{

    public function controllerActionLayoutGenerateBlocksAfter(Varien_Event_Observer $observer){
        /* @var Mage_Core_Model_Layout */
        $layout = $observer->getLayout();
        $head = $layout->getBlock('head');
        if ($head instanceof Mage_Page_Block_Html_Head) {
            $head->removeItem('skin_js','qs/js/validationform.js');
        }
    }

}