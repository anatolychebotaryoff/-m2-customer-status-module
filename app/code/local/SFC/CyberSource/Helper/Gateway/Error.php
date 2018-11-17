<?php
/**
 * StoreFront CyberSource Tokenized Payment Extension for Magento
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of StoreFront Consulting, Inc.
 *
 * @category  SFC
 * @package   SFC_CyberSource
 * @author    Garth Brantley <garth@storefrontconsulting.com>
 * @copyright 2009-2013 StoreFront Consulting, Inc. All Rights Reserved.
 * @license   http://www.storefrontconsulting.com/media/downloads/ExtensionLicense.pdf StoreFront Consulting Commercial License
 * @link      http://www.storefrontconsulting.com/cybersource-saved-credit-cards-extension-for-magento/
 *
 */

/**
 * This class provides error / error message mapping information
 *
 */
class SFC_CyberSource_Helper_Gateway_Error extends Mage_Core_Helper_Abstract
{

    public function mapErrorResponseToCustomerMessage(stdClass $response)
    {
        $reasonCode = (integer) $response->reasonCode;
        $defaultError = Mage::getStoreConfig('payment/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/default_error');
//        switch ($reasonCode) {
//            case 202:
//                return 'Expiration Date Mismatch - The transaction was not approved because the expiration date is expired or did not match. Please verify the expiration date is correct and try again, or try a different form of payment.';
//            case 200:
//            case 520:
//                return 'AVS Mismatch - The transaction was not approved because the address and/or zip code did not match what the issuer has on file. Please verify the address information is correct and try again, or try a different form of payment.';
//            case 209:
//            case 211:
//            case 230:
//                return 'CVV Mismatch - The transaction was not approved because the CVV code did not match. Please verify the CVV is correct and try again, or try a different form of payment.';
//            case 0:
//            default:
//                return $defaultError;
//        }
        Mage::log($response, null, 'mylogfile.log');
        $avsCode = $response->ccAuthReply->avsCode;
        switch ($avsCode) {
            case 'A':
                return $this->getConfigByCode('a_code');
            case 'B':
                return $this->getConfigByCode('b_code');
            case 'C':
                return $this->getConfigByCode('c_code');
            case 'D':
                return $this->getConfigByCode('d_code');
            case 'E':
                return $this->getConfigByCode('e_code');
            case 'F':
                return $this->getConfigByCode('f_code');
            case 'G':
                return $this->getConfigByCode('g_code');
            case 'H':
                return $this->getConfigByCode('h_code');
            case 'I':
                return $this->getConfigByCode('i_code');
            case 'K':
                return $this->getConfigByCode('k_code');
            case 'L':
                return $this->getConfigByCode('l_code');
            case 'M':
                return $this->getConfigByCode('m_code');
            case 'N':
                return $this->getConfigByCode('n_code');
            case 'O':
                return $this->getConfigByCode('o_code');
            case 'P':
                return $this->getConfigByCode('p_code');
            case 'R':
                return $this->getConfigByCode('r_code');
            case 'S':
                return $this->getConfigByCode('s_code');
            case 'T':
                return $this->getConfigByCode('t_code');
            case 'U':
                return $this->getConfigByCode('u_code');
            case 'W':
                return $this->getConfigByCode('w_code');
            case 'X':
                return $this->getConfigByCode('x_code');
            case 'Y':
                return $this->getConfigByCode('y_code');
            case 'Z':
                return $this->getConfigByCode('z_code');
            default:
                return 'default';
                // return $defaultError;
        }
    }

    protected function getConfigByCode($code)
    {
        $defaultError = Mage::getStoreConfig('payment/' . SFC_CyberSource_Model_Method::METHOD_CODE . '/default_error');
        $resultCode = empty(Mage::getStoreConfig('sam_statuscodes/general/' . $code)) ? $defaultError : Mage::getStoreConfig('sam_statuscodes/general/' . $code);
        return $resultCode;
    }

}
