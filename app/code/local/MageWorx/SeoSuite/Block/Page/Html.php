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
class MageWorx_SeoSuite_Block_Page_Html extends Mage_Page_Block_Html
{
    protected function _toHtml()
    {
        $html = parent::_toHtml();

        /**
         * @TODO need test
        if(Mage::helper('seosuite/richsnippet')->isRichsnippetEnabled()){
            if(strpos($html, '<body') !== false){
                $html = str_replace('<body', '<body itemscope itemtype="http://schema.org/WebPage"', $html);
                $posEnd = strpos($html, '>', strpos($html, '<body')) + 1;
                if($posEnd !== false){
                    list($codeCrop) = explode("_", Mage::app()->getLocale()->getLocaleCode());
                    if($codeCrop){
                        $html = substr_replace($html, "\n" . '<meta itemprop="inLanguage" content="'. $codeCrop .'"/>', $posEnd, 0);
                    }
                }
            }
        }
         */
        if(Mage::registry('current_product') && Mage::getStoreConfig('mageworx_seo/seosuite/product_og_enabled')) {
            $headAttributesAsString = 'prefix = "og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#"';
            $pos = strpos($html, "<head");
            if($pos !== false){
            	$html = substr_replace($html, "<head " . $headAttributesAsString, $pos, 5);
            }
        }
        return $html;
    }
}
