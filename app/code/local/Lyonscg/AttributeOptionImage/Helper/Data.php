<?php
/**
 * Rewrite class for JR_AttributeOptionImage_Helper_Data
 *
 * @category   Lyons
 * @package    Lyonscg_AttributeOptionImage
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class Lyonscg_AttributeOptionImage_Helper_Data extends JR_AttributeOptionImage_Helper_Data
{
    /**
     * Rewrite to add cms helper filter for <img src="{{media url=""}}"> links
     *
     * @param $optionId
     * @return string
     */
    public function getAttributeOptionImage($optionId)
    {
        $images = $this->getAttributeOptionImages();
        $image = array_key_exists($optionId, $images) ? $images[$optionId] : '';

        $helper = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();
        $image = $processor->filter($image);

        if ($image && strpos($image, '<img') !== false) {
            return $image;
        } elseif ($image && (strpos($image, 'http') !== 0)) {
            $image = Mage::getDesign()->getSkinUrl($image);
        }

        return $image;
    }
}