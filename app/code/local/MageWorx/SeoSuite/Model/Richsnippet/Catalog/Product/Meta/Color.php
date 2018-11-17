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

/**
 * @see MageWorx_SeoSuite_Model_Catalog_Product_Richsnippet_Product
 */
class MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Meta_Color extends MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Abstract
{
    protected function _addAttributeForNodes(simple_html_dom_node $node)
    {
        $attributeCode = Mage::helper('seosuite/richsnippet')->getColorAttributeCode();
        if($attributeCode){
            $colorValue = Mage::helper('seosuite/richsnippet')->getAttributeValueByCode($this->_product, $attributeCode);
            if($colorValue){
                $node->innertext = $node->innertext . '<meta itemprop="color" content="'. $colorValue. '">' . "\n";
                return true;
            }
        }
        return false;
    }

    protected function _getItemConditions()
    {
        return array("*[itemtype=http://schema.org/Product]");
    }

    function _checkBlockType()
    {
        return true;
    }

    protected function _isValidNode(simple_html_dom_node $node)
    {
        return true;
    }

}