<?php
/**
 * Rewrite for JR_AttributeOptionImage_Helper_Cms_Wysiwyg_Images Helper Class
 *
 * @category   Lyons
 * @package    Lyonscg_AttributeOptionImage
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class Lyonscg_AttributeOptionImage_Helper_Cms_Wysiwyg_Images extends JR_AttributeOptionImage_Helper_Cms_Wysiwyg_Images
{
    /**
     * Rewrite to allow static urls along with <img src="{{media url=""}}" /> links
     * We bypass the parent::isUsingStaticUrlsAllowed() function since we do not need it anymore
     *
     * @return bool
     */
    public function isUsingStaticUrlsAllowed()
    {
        return Mage_Cms_Helper_Wysiwyg_Images::isUsingStaticUrlsAllowed();
    }
}