<?php

class USWF_PayPal_Model_Paypal_Config extends Mage_Paypal_Model_Config {
    /**
     * Express checkout shortcut pic URL getter
     * PayPal will ignore "pal", if there is no total amount specified
     *
     * @param string $localeCode
     * @param float $orderTotal
     * @param string $pal encrypted summary about merchant
     * @see Paypal_Model_Api_Nvp::callGetPalDetails()
     * @return string
     */
    public function getExpressCheckoutShortcutImageUrl($localeCode, $orderTotal = null, $pal = null)
    {
        if ($this->areButtonsDynamic()) {
            return $this->_getDynamicImageUrl(self::EC_BUTTON_TYPE_SHORTCUT, $localeCode, $orderTotal, $pal);
        }
        if ($this->buttonType === self::EC_BUTTON_TYPE_MARK) {
            return $this->getPaymentMarkImageUrl($localeCode);
        }
        return sprintf('https://www.paypalobjects.com/webstatic/%s/i/btn/png/gold-rect-paypalcheckout-44px.png',
            $this->_getSupportedLocaleCode($localeCode));
    }

    /**
     * see Lyonscg_PaypalRevenue_Model_Paypal_Config
     * BN code getter
     * Override to use revenue sharing code.
     * @param null $countryCode
     * @return string
     */
    public function getBuildNotationCode($countryCode = null)
    {
        // CE 1.8+/EE 1.13+ have a getEdition method which returns the
        // edition of Magento being used.
        if (method_exists('Mage', 'getEdition')) {
            if (Mage::getEdition() == Mage::EDITION_ENTERPRISE) {
                return 'LyonsCG_SI_MagentoEE';
            } else {
                return 'LyonsCG_SI_MagentoCE';
            }
        }

        // Check for Enterprise modules to determine version.
        if (file_exists(Mage::getBaseDir() . 'app/code/core/Enterprise')) {
            return 'LyonsCG_SI_MagentoEE';
        } else {
            return 'LyonsCG_SI_MagentoCE';
        }
    }
}