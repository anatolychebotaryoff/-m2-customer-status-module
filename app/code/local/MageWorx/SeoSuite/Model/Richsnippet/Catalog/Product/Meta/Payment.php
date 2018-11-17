<?php
/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2014 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */
/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */

/**
 * @see MageWorx_SeoSuite_Model_Catalog_Product_Richsnippet_Product
 */
class MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Meta_Payment extends MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Abstract
{
    protected function _addAttributeForNodes(simple_html_dom_node $node)
    {
        $_paymentMethods = array(
            "byBankTransferInAdvance" => "http://purl.org/goodrelations/v1#ByBankTransferInAdvance",
            "byInvoice"               => "http://purl.org/goodrelations/v1#ByInvoice",
            "cash"                    => "http://purl.org/goodrelations/v1#Cash",
            "checkinadvance"          => "http://purl.org/goodrelations/v1#CheckInAdvance",
            "cod"                     => "http://purl.org/goodrelations/v1#COD",
            "directdebit"             => "http://purl.org/goodrelations/v1#DirectDebit",
            "googleCheckout"          => "http://purl.org/goodrelations/v1#GoogleCheckout",
            "paypal"                  => "http://purl.org/goodrelations/v1#PayPal",
            "AE"                      => "http://purl.org/goodrelations/v1#AmericanExpress",
            "DI"                      => "http://purl.org/goodrelations/v1#Discover",
            "JCB"                     => "http://purl.org/goodrelations/v1#JCB",
            "MC"                      => "http://purl.org/goodrelations/v1#MasterCard",
            "VI"                      => "http://purl.org/goodrelations/v1#VISA",
        );

        $data = array();
        $payments = Mage::getSingleton('payment/config')->getActiveMethods();

        foreach ($payments as $paymentCode => $paymentModel) {

            if ($paymentModel->canUseCheckout() == 1) {
                if ($paymentCode) {
                    switch ($paymentCode) {
                        case "ccsave":
                            $ccsave = $this->_getCcAvailableTypes($paymentModel);
                            foreach ($ccsave as $cc) {
                                if (in_array($cc, $_paymentMethods)) {
                                    $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods[$cc] . '"/>';
                                }
                            }
                            break;
                        case "checkmo":
                            $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods['checkinadvance'] . '"/>';
                            $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods['cash'] . '"/>';
                            break;
                        case "purchaseorder":
                            $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods['byInvoice'] . '"/>';
                            break;
                        case "banktransfer":
                            $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods['byBankTransferInAdvance'] . '"/>';
                            break;
                        case "cashondelivery":
                            $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods['cod'] . '"/>';
                            break;

                        case "paypaluk_express":
                        case "paypaluk_direct":
                        case "paypal_direct":
                        case "payflow_link":
                        case "verisign":
                        case "payflow_advanced":
                        case "paypal_standard":
                        case "paypal_express":
                            $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods['paypal'] . '"/>';
                            break;
                        case "free":
                        case "authorizenet":
                            $sCC            = Mage::getStoreConfig('payment/authorizenet/cctypes');
                            $aCC            = explode(',', $sCC);
                            foreach ($aCC as $cc) {
                                if (in_array($cc, array('AE', 'VI', 'MC', 'DI', 'JCB'))) {
                                    $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods[$cc] . '"/>';
                                }
                            }
                            break;
                        case "authorizenet_directpost":
                            $sCC = Mage::getStoreConfig('payment/authorizenet_directpost/cctypes');
                            $aCC = explode(',', $sCC);
                            foreach ($aCC as $cc) {
                                if (in_array($cc, array('AE', 'VI', 'MC', 'DI', 'JCB'))) {
                                    $data[] = '<link itemprop="acceptedPaymentMethod" content="' . $_paymentMethods[$cc] . '"/>';
                                }
                            }
                            break;
                        default :
                            break;
                    }
                }
            }
        }

        if(count($data)){
            $string = implode("\n", $data);
        }

        if (!empty($string)) {
            $node->innertext = $node->innertext . $string . "\n";
            return true;
        }
        return false;
    }

    protected function _getItemConditions()
    {
        return array("*[itemtype=http://schema.org/Offer]");
    }

    protected function _checkBlockType()
    {
        return true;
    }

    protected function _isValidNode(simple_html_dom_node $node)
    {
        return true;
    }

    protected function _getCcAvailableTypes($method)
    {
        $types = Mage::getSingleton('payment/config')->getCcTypes();
        if ($method) {
            $availableTypes = $method->getConfigData('cctypes');
            if ($availableTypes) {
                $availableTypes = explode(',', $availableTypes);
                foreach ($types as $code=>$name) {
                    if (!in_array($code, $availableTypes)) {
                        unset($types[$code]);
                    }
                }
            }
        }
        return $types;
    }

}