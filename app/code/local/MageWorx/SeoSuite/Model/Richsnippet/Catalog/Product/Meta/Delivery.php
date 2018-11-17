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
class MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Meta_Delivery extends MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Abstract
{
    protected function _addAttributeForNodes(simple_html_dom_node $node)
    {
        $_deliveryMethods = array(
            "dhl"               => "http://purl.org/goodrelations/v1#DHL",
            "ups"               => "http://purl.org/goodrelations/v1#UPS",
            "mail"              => "http://purl.org/goodrelations/v1#DeliveryModeMail",
            "fedex"             => "http://purl.org/goodrelations/v1#FederalExpress",
            "directdownload"    => "http://purl.org/goodrelations/v1#DeliveryModeDirectDownload",
            "pickup"            => "http://purl.org/goodrelations/v1#DeliveryModePickUp",
            "vendorfleet"       => "http://purl.org/goodrelations/v1#DeliveryModeOwnFleet",
            "freight"           => "http://purl.org/goodrelations/v1#DeliveryModeFreight"
        );

        $data = array();

        $methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
        $options = array();

        foreach($methods as $_code => $_method)
        {
            switch ($_code) {
                case "dhlint":
                    $data['dhl'] = '<link itemprop="availableDeliveryMethod" content="' . $_deliveryMethods['dhl'] . '"/>';
                    break;
                case "ups":
                    $data['dhl'] = '<link itemprop="availableDeliveryMethod" content="' . $_deliveryMethods['ups'] . '"/>';
                    break;
                case "fedex":
                    $data['dhl'] = '<link itemprop="availableDeliveryMethod" content="' . $_deliveryMethods['fedex'] . '"/>';
                    break;
                case "usps":
                case "tablerate":
                case "freeshipping":
                case "flatrate":
                default :
                    $data['dhl'] = '<link itemprop="availableDeliveryMethod" content="' . $_deliveryMethods['freight'] . '"/>';
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