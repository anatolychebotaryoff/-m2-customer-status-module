<?php
/**
 * CartController.php
 *
 * @category    USWF
 * @package     USWF_Replacementbrand
 * @copyright
 * @author
 */

require_once Mage::getModuleDir('controllers','Cmsmart_QuickView') . DS . 'CartController.php';
class USWF_Replacementbrand_CmsmartQuickView_CartController extends Cmsmart_QuickView_CartController {
    
    //MOVED FROM Lyonscg_Checkout
    /**
     * On proceed to checkout button we need to update cart and then sent to checkout page
     */
    public function updateCheckoutPostAction()
    {
        $this->_updateShoppingCart();

        if(!Mage::helper('onestepcheckout')->isRewriteCheckoutLinksEnabled()) {
            $this->_redirect('checkout/onepage', array('_secure'=>true));
        } else {
            $this->_redirect('onestepcheckout', array('_secure'=>true));
        }

    }
}