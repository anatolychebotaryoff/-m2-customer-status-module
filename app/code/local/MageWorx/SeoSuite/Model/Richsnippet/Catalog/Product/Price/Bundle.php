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
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */
class MageWorx_Seosuite_Model_Richsnippet_Catalog_Product_Price_Bundle extends
MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Price_Abstract
{
    protected function _getItemValues($_product = null)
    {
        if (!$_product) {
            $_product = $this->_product;
        }
        $prices = Mage::helper('seosuite/richsnippet')->getBundlePrices($_product);
        $modPrices = array();

        if ($_product->getGroupPrice()) {
            $prices[] = $_product->getGroupPrice();
        }

        if(is_array($prices)){
            foreach ($prices as $price) {
                $modPrices = array_merge($modPrices, $this->_getModifyPrices($price));
            }
        }
        return array_unique($modPrices);
    }
}
