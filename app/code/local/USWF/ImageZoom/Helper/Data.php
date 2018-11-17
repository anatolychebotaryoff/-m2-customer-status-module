<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_ImageZoom
 * @copyright
 * @author
 */
class USWF_ImageZoom_Helper_Data extends Mage_Catalog_Helper_Data
{

    /**
     * Returns if zoom enabled
     *
     * @return boolean
     */
    public function isZoomEnabled() {
        return Mage::getStoreConfig('catalog/imagezoom/enabled');
    }

    /**
     * Returns if lightbox enabled
     *
     * @return boolean
     */
    public function isLightBoxEnabled() {
        return Mage::getStoreConfig('catalog/imagezoom/lightbox_enabled');
    }

    /**
     * Returns resized big image html
     *
     * @param Mage_Catalog_Model_Product $product
     * @param mixed $imageFile
     * @return string
     */
    public function getBigImageHtml($product, $imageFile = null) {
        return Mage::helper('catalog/image')->init($product, 'image', $imageFile)
            ->resize(
                (int)Mage::getStoreConfig('catalog/imagezoom/big_image_width'),
                (int)Mage::getStoreConfig('catalog/imagezoom/big_image_height')
            );
    }

    /**
     * Returns image zoom options
     *
     * @return string
     */
    public function getImageZoomOptions() {
        return json_encode(array(
            'zoomType' => (string)Mage::getStoreConfig('catalog/imagezoom/zoom_type'),
            'zoomWidth' => (int)Mage::getStoreConfig('catalog/imagezoom/zoom_width'),
            'zoomHeight' => (int)Mage::getStoreConfig('catalog/imagezoom/zoom_height'),
            'xOffset' => (int)Mage::getStoreConfig('catalog/imagezoom/zoom_offset_x'),
            'yOffset' => (int)Mage::getStoreConfig('catalog/imagezoom/zoom_offset_y'),
            'position' => (string)Mage::getStoreConfig('catalog/imagezoom/zoom_position'),
            'preloadImages' => (boolean)Mage::getStoreConfig('catalog/imagezoom/preload_images'),
            'preloadText' => (string)Mage::getStoreConfig('catalog/imagezoom/preload_text'),
            'title' => (boolean)Mage::getStoreConfig('catalog/imagezoom/title'),
            'lens' => (boolean)Mage::getStoreConfig('catalog/imagezoom/lens'),
            'imageOpacity' => (float)Mage::getStoreConfig('catalog/imagezoom/image_opacity'),
            'showEffect' => (string)Mage::getStoreConfig('catalog/imagezoom/show_effect'),
            'hideEffect' => (string)Mage::getStoreConfig('catalog/imagezoom/hide_effect'),
            'fadeinSpeed' => (int)Mage::getStoreConfig('catalog/imagezoom/fadein_speed'),
            'fadeoutSpeed' => (int)Mage::getStoreConfig('catalog/imagezoom/fadeout_speed')
        ));
    }
}