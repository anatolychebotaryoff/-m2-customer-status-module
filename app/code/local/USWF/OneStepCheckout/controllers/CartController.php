<?php
require_once  Mage::getModuleDir('controllers', 'Idev_OneStepCheckout').DS.'CartController.php';

class USWF_OneStepCheckout_CartController extends Idev_OneStepCheckout_CartController
{
    /**
     * Initialize shipping information
     */
    public function estimatePostAction()
    {
        $country    = (string) $this->getRequest()->getParam('country_id');
        $postcode   = (string) $this->getRequest()->getParam('estimate_postcode');
        $city       = (string) $this->getRequest()->getParam('estimate_city');
        $regionId   = (string) $this->getRequest()->getParam('region_id');
        $region     = (string) $this->getRequest()->getParam('region');
        
        if (
            !empty($regionId) && 
            ($errors = Mage::helper('lyonscg_checkout')->checkItems($regionId)) && 
            isset($errors['error'])
        ) {
            foreach ($errors['message'] as $message) {
                $this->_getSession()->addError(Mage::helper('core')->escapeHtml($message));
            }
            $this->_goBack();
        }

        $this->_getQuote()->getShippingAddress()
            ->setCountryId($country)
            ->setCity($city)
            ->setPostcode($postcode)
            ->setRegionId($regionId)
            ->setRegion($region)
            ->setCollectShippingRates(true);
        $this->_getQuote()->save();
        $this->_goBack();

    }
}
