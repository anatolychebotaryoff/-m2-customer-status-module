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
class MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Meta_Category extends MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Abstract
{
    protected function _addAttributeForNodes(simple_html_dom_node $node)
    {
        $categories = $this->_product->getCategoryCollection()->exportToArray();
        $currentCategory = Mage::registry('current_category');
        $useDeepestCategory = Mage::helper('seosuite/richsnippet')->isRichsnippetCategoryDeepest();

        if(is_object($currentCategory)){
            if(count($categories) > 1){
                if($useDeepestCategory){
                    $currentId = $currentCategory->getId();
                    $currentLevel = $currentCategory->getLevel();
                    if(is_numeric($currentLevel)){
                        foreach($categories as $category){
                            if($category['level'] > $currentLevel){
                                $currentId = $category['entity_id'];
                                $currentLevel = $category['level'];
                            }
                        }
                        if($currentId != $currentCategory->getId()){
                            $categoryName = $this->getCategoryNameById($currentId);
                        }
                    }
                }
            }
            if(empty($categoryName)){
                $categoryName = $currentCategory->getName();
            }
        }else{
            if($useDeepestCategory){
                if(count($categories) > 0){
                    $currentId = 0;
                    $currentLevel = 0;
                    if(is_numeric($currentLevel)){
                        foreach($categories as $category){
                            if($category['level'] >= $currentLevel){
                                $currentId = $category['entity_id'];
                                $currentLevel = $category['level'];
                            }
                        }
                        if($currentId){
                            $categoryName = $this->getCategoryNameById($currentId);
                        }
                    }
                }else{
                    $categoryName = false;
                }
            }else{
                $categoryName = false;
            }
        }

        if (!empty($categoryName)) {
            $node->innertext = $node->innertext . '<meta itemprop="category" content="' . $categoryName . '">' . "\n";
            return true;
        }
        return false;
    }

    function getCategoryNameById($id){
        if($id){
            $category = Mage::getModel('catalog/category')->load($id);
            if(is_object($category)){
                return $category->getName();
            }
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

}