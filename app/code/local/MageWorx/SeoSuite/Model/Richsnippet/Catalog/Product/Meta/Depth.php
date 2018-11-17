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
class MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Meta_Depth extends MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Abstract
{
    protected function _addAttributeForNodes(simple_html_dom_node $node)
    {
        $attributeCode = Mage::helper('seosuite/richsnippet')->getDepthAttributeCode();
        if($attributeCode){
            $depth = $this->_getDepth($attributeCode);
            if($depth){
                $node->innertext = $node->innertext . '<meta itemprop="depth" content="'. $depth. '">' . "\n";
                return true;
            }
        }
        return false;
    }

    protected function _getDepth($attributeCode)
    {
        $depthValue = Mage::helper('seosuite/richsnippet')->getAttributeValueByCode($this->_product, $attributeCode);
        $unit = Mage::helper('seosuite/richsnippet')->getRichsnippetDimensionsUnit();
        if($depthValue){
            if(is_numeric($depthValue) && $unit){
                return $depthValue . ' ' . $unit;
            }elseif(preg_match('/^([0-9]+[\s]+[a-zA-Z]+)$/', $depthValue)){
                return $depthValue;
            }
            return false;
        }
    }

    protected function _getItemConditions()
    {
        return array("*[itemtype=http://schema.org/Product]");
    }

    protected function _checkBlockType()
    {
        return true;
    }

    protected function _isValidNode(simple_html_dom_node $node)
    {
        return true;
    }
}