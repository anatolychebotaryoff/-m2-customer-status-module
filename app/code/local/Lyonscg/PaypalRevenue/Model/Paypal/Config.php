<?php
/**
 * Paypal Revenue Sharing
 *
 * @category     Lyonscg
 * @package      Lyonscg_PaypalRevenue
 * @copyright    Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author       Nicholas Hughart (nhughart@lyonscg.com)
 */

class Lyonscg_PaypalRevenue_Model_Paypal_Config extends Mage_Paypal_Model_Config
{
    /**
     * BN code getter
     * Override to use revenue sharing code.
     *
     * @param string $countryCode ISO 3166-1
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