<?php
/**
 * Rewrite to save settings in class variable since it causes SFC Autoship to be called too many times
 *
 * @category  Lyons
 * @package   Lyonscg_OneStepCheckout
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_OneStepCheckout_Helper_Checkout extends Idev_OneStepCheckout_Helper_Checkout
{
    protected $settings;

    /**
     * Get Settings
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Save settings in class variable
     * @return array
     */
    public function loadConfig()
    {
        if ($this->settings == null) {
            $settings = array();
            $items = array(
                'general/serial', 'general/default_country', 'general/default_shipping_method', 'general/default_payment_method',
                'general/enable_geoip', 'general/skin', 'exclude_fields/exclude_city', 'exclude_fields/exclude_telephone', 'general/show_custom_options',
                'exclude_fields/exclude_company', 'exclude_fields/exclude_fax', 'exclude_fields/exclude_region', 'exclude_fields/exclude_zip', 'exclude_fields/enable_comments', 'exclude_fields/enable_discount', 'exclude_fields/exclude_address', 'exclude_fields/exclude_country_id', 'exclude_fields/enable_giftcard',
                'general/geoip_database', 'exclude_fields/enable_newsletter', 'terms/enable_terms',
                'general/checkout_title', 'general/checkout_description','sortordering_fields',
                'terms/terms_title', 'terms/terms_contents', 'general/enable_different_shipping', 'ajax_update/enable_ajax_save_billing',
                'ajax_update/ajax_save_billing_fields', 'ajax_update/enable_update_payment_on_shipping', 'general/enable_gift_messages',
                'registration/registration_mode', 'registration/registration_order_without_password', 'general/hide_nonfree_payment_methods',
                'general/display_tax_included', 'exclude_fields/newsletter_default_checked', 'feedback','addressreview',
                'general/display_full_tax','exclude_fields/enable_comments_default','terms/enable_default_terms','terms/enable_default_terms', 'terms/enable_textarea'
            );

            foreach($items as $config)    {

                $temp = explode('/', $config);
                $name = (!empty($temp[1])) ? $temp[1] : $temp[0];

                $settings[$name] = Mage::getStoreConfig('onestepcheckout/' . $config);
            }

            $isPersistent = false;

            if(is_object(Mage::getConfig()->getNode('global/models/persistent'))){
                $isPersistent = Mage::helper('persistent/session')->isPersistent();
            }

            if(!$isPersistent && !$this->getOnePage()->getQuote()->isAllowedGuestCheckout()){
                $settings['registration_mode'] = 'require_registration';
            }

            return $settings;
        }

        return $this->settings;
    }
}
