<?php
/**
 * Checkout.php
 *
 * @category    USWF
 * @package     USWF_OneStepCheckout
 * @copyright
 * @author
 */
class USWF_OneStepCheckout_Helper_Checkout extends Lyonscg_OneStepCheckout_Helper_Checkout
{

    const XML_PATH_CREATE_ACCOUNT_BEHAVIOR = 'onestepcheckout/registration/create_account_behavior';

    public function _getAddressError($result, $billing_data, $type = 'billing')
    {
        $errors = array();
        if (isset($result['message']) && is_array($result['message']) && in_array('Please enter city.', $result['message'])) {
            $errors[] = 'city';
        }
        if (isset($result['message']) && is_array($result['message']) && in_array('Please enter first name.', $result['message'])) {
            $errors[] = 'firstname';
        }
        if (isset($result['message']) && is_array($result['message']) && in_array('Please enter last name.', $result['message'])) {
            $errors[] = 'lastname';
        }
        if (isset($result['message']) && is_array($result['message']) && in_array('Please enter street.', $result['message'])) {
            $errors[] = 'address';
        }
        if (isset($result['message']) && is_array($result['message']) && in_array('Please enter zip/postal code.', $result['message'])) {
            $errors[] = 'postcode';
        }
        if (isset($result['message']) && is_array($result['message']) && in_array('Please enter state/province.', $result['message'])) {
            $errors[] = 'region';
        }
        if (isset($result['message']) && is_array($result['message']) && in_array('Please enter telephone.', $result['message'])) {
            $errors[] = 'telephone';
        } else {
            if (!isset($billing_data['telephone']) || trim($billing_data['telephone']) == '') {
                if(!$this->settings['exclude_telephone']) {
                    $errors[] = 'telephone';
                }
            }
        }

        if ($type == 'billing') {
            if (!is_array($result['message']) && substr($result['message'], 0, 21) == 'Invalid email address') {
                $errors[] = 'email';
            }
        }
        
        if (empty($errors) && !empty($result['message'])) {
            $errors = array(
                'native_magento' => is_array($result['message']) ? implode(' ', $result['message']) : $result['message']
            );
        }
        
        return $errors;
    }

    /**
     * Returns json array of ignored regions in shipping address
     * 
     * @return string 
     */
    public function getIgnoreRegionJson() 
    {
        $regions = array();
        foreach (Mage::getSingleton('checkout/type_onepage')->getQuote()->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $noShip = $product->getResource()->getAttribute('ship_no_by_location')
                ->getFrontend()->getValue($product);
            if (!empty($noShip)) {
                $productName = $this->escapeHtml($product->getName());
                $regions[$productName] = explode(', ', $noShip);
            }
        }
        return empty($regions) ? '{}' : json_encode($regions);
    }

    /**
     * Returns json array of address regions
     *
     * @return string
     */
    public function getAddressRegionJson()
    {
        $result = array();
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            foreach (Mage::getSingleton('customer/session')->getCustomer()->getAddresses() as $address) {
                $result[$address->getId()] = $address->getRegion();
            }
        }
        return empty($result) ? '{}' : json_encode($result);
    }
    
    public function load_exclude_data($data)
    {
        if( $this->settings['exclude_city']  || empty($data['city']))    {
            $data['city'] = '-';
        }

        if( $this->settings['exclude_country_id']  || empty($data['country_id']))    {
            $data['country_id'] = $this->settings['default_country'];
        }

        if( $this->settings['exclude_telephone'] || empty($data['telephone']))    {
            $data['telephone'] = '-';
        }

        if( $this->settings['exclude_region'] || (empty($data['region']) && empty($data['region_id'])))    {
            $data['region'] = '';
            $data['region_id'] = '1';
        }

        if( $this->settings['exclude_zip'] || empty($data['postcode']))    {
            $data['postcode'] = '-';
        }

        if( $this->settings['exclude_company'] || empty($data['company']) )    {
            $data['company'] = '';
        }

        if( $this->settings['exclude_fax'] || empty($data['fax']) )    {
            $data['fax'] = '';
        }

        if( $this->settings['exclude_address'] || empty($data['street']) )    {
            $data['street'][] = '-';
        }

        if( isset($data['street']) && isset($data['street'][0]) && isset($data['street'][1]) &&
            $data['street'][0] == $data['street'][1])    {
            unset($data['street'][1]);
        }

        $data = $this->cleanValues($data);
        return $data;
    }

    /**
     * Display password fields in checkout by default
     *
     * @return bool
     * @throws Mage_Core_Exception
     */
    function hidePasswords()
    {
        $email = $this->getOnepage()->getQuote()->getBillingAddress()->getEmail();
        if($this->settings['registration_order_without_password'] && $email && $email != '')    {
            if($this->_customerEmailExists($email, Mage::app()->getWebsite()->getId()))    {
                return true;
            }
        }
        if($this->settings['registration_mode'] == 'allow_guest')    {

            if(isset($_POST['create_account']) && $_POST['create_account'] == '1')    {
                return false;
            }
            if(Mage::getStoreConfig(self::XML_PATH_CREATE_ACCOUNT_BEHAVIOR))    {
                return false;
            }

            return true;
        }
        return false;
    }


    /**
     * @return string
     * @throws Mage_Core_Exception
     */
    function getStyleScroll()
    {
        $height = Mage::getStoreConfig('onestepcheckout/general/max_height_order_review');
        $height = trim($height);
        $result = '';
        if (!empty($height)){
            $result .= 'overflow-y: auto; ';
            $result .= "max-height: {$height}; ";
        }

        return $result;
    }

}
