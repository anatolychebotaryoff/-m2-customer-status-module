<?php
/**
 * Rewrite Idev_OneStepCheckout_Model_Observers_PresetDefaults to fix checkout issues
 *
 * @category  Lyons
 * @package   Lyonscg_OneStepCheckout
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_OneStepCheckout_Model_Observers_PresetDefaults extends Idev_OneStepCheckout_Model_Observers_PresetDefaults
{
    // Changed these values so that we included all of the address fields
    public $defaultFields = array('firstname', 'lastname', 'telephone', 'street', 'country_id', 'region', 'region_id', 'city', 'postcode');

    /**
     * Rewrite for saving billing address when there is a difference
     * If you have aquired a quote from cart and you are having saved addresses then you can get wrong shipping methods
     *
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function compareDefaultsFromCart(Varien_Event_Observer $observer) {

        $quote = Mage::getSingleton('checkout/session')->getQuote();

        if(is_object($quote)){

            //extract the data from quote
            $currentBilling = $this->hasDataSet($quote->getBillingAddress());
            $currentShipping = $this->hasDataSet($quote->getShippingAddress());

            $sameAsBilling = $quote->getShippingAddress()->getSameAsBilling();
            $difference = array();

            if($sameAsBilling){
                if(Mage::getSingleton('customer/session')->isLoggedIn()){
                    $selectedAddress = $quote->getBillingAddress()->getCustomerAddressId();
                    if($selectedAddress){
                        $currentShippingOriginal = $this->hasDataSet($quote->getCustomer()->getAddressById($selectedAddress));
                        $difference = array_diff($currentShippingOriginal, $currentShipping);
                    } else {
                        $currentPrimaryBilling = $this->hasDataSet($quote->getCustomer()->getPrimaryBillingAddress());
                        $difference  = array_diff($currentPrimaryBilling, $currentBilling);
                    }
                } else {
                    $difference = array_diff($currentBilling, $currentShipping);
                }

                if(!empty($difference)){
                    $quote->getBillingAddress()->addData($difference)->implodeStreetAddress()->save();
                    $quote->getShippingAddress()->addData($difference)->implodeStreetAddress()->setCollectShippingRates(true);
                }
            }

            $quote->getShippingAddress()->setCollectShippingRates(true);
        }

        return $this;
    }
}
