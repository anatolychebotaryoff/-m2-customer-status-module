<?php
/**
 * Storelocator.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Block_Storelocator extends Magestore_Storelocator_Block_Storelocator
{
    public function addTopLinkStores() {
        if (Mage::helper('storelocator')->getConfig('enable') == 1) {
            $toplinkBlock = $this->getParentBlock();

            if ($toplinkBlock)
                $toplinkBlock->addLink($this->__('Dealer Locator'), 'storelocator/index/index', 'Dealer Locator', true, array(), 1);
        }
    }   
}