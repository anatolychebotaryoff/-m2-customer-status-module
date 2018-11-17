<?php
/**
 * Checkout.php
 *
 * @category    USWF
 * @package     USWF_Design
 * @copyright
 * @author
 */
class USWF_Design_Helper_Checkout extends Mage_Checkout_Helper_Data
{
    public function formatPrice($price, $includeContainer = false)
    {
        return $this->getQuote()->getStore()->formatPrice($price, $includeContainer);
    }
}