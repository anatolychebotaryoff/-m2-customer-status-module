<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Helper_Data extends Mage_Catalog_Helper_Data
{
    const CONFIG_PATH_BANNERS_ENABLED = 'uswf_smartfit/banners/enabled';
    const CONFIG_PATH_BANNER_LEFT_TEMPLATE = 'uswf_smartfit/banners/banner_left_';
    const CONFIG_PATH_BANNER_LIST = 'uswf_smartfit/banners/banner_list';
    const CONFIG_PATH_SLIDER_ANIM_DURATION = 'uswf_smartfit/banners/slider_animation_duration';
    const CONFIG_PATH_SLIDER_ANIM_SPEED = 'uswf_smartfit/banners/slider_time_between_change';
    const CONFIG_PATH_BANNER_BOTTOM = 'uswf_smartfit/banners/banner_bottom_image';
    const CONFIG_PATH_BANNER_LINK = 'uswf_smartfit/banners/banner_bottom_link';
    const CONFIG_PATH_FEATURED_ENABLED = 'uswf_smartfit/featured_products/enabled';
    const CONFIG_PATH_FEATURED_COLUMN_COUNT = 'uswf_smartfit/featured_products/column_count';
    const CONFIG_PATH_FEATURED_PRODUCT_LIMIT = 'uswf_smartfit/featured_products/product_limit';

    /**
     * Returns if banners should be shown at all
     * 
     * @return bool
     */
    public function isBannersEnabled() {
        return Mage::getStoreConfig(self::CONFIG_PATH_BANNERS_ENABLED);
    }
    
    /**
     * Returns top left banner
     *
     * @return string
     */
    public function getTopLeftBanner() {
        return $this->getLeftBanner('top');
    }

    /**
     * Returns bottom left banner
     *
     * @return string
     */
    public function getBottomLeftBanner() {
        return $this->getLeftBanner('bottom');
    }
    
    /**
     * Returns left banner by position
     * 
     * @param string $position
     * 
     * @return string
     */
    protected function getLeftBanner($position) {
        if (
            $this->isBannersEnabled() && 
            ($image = Mage::getStoreConfig(self::CONFIG_PATH_BANNER_LEFT_TEMPLATE . $position . '_image')) &&
            ($link = Mage::getStoreConfig(self::CONFIG_PATH_BANNER_LEFT_TEMPLATE . $position . '_link'))
        ) {
            if (strpos($image, '{skin}') !== false) {
                $image = str_replace('{skin}', Mage::getDesign()->getSkinUrl() . 'images', $image);
            } else {
                $image = Mage::getBaseUrl('media') . $image;
            }
            return  '<a href="' . $link . '"><div class="slider-showcase_' . $position . 
                '"><img src="' . $image . '"></div></a>';
        }
        return '';
    }

    /**
     * Returns slider banners html
     * 
     * @return string
     */
    public function getSliderBanners() {
        if ($this->isBannersEnabled() && ($banners = Mage::getStoreConfig(self::CONFIG_PATH_BANNER_LIST))) {
            $banners = unserialize($banners);
            $html = '';
            if (is_array($banners)) {
                foreach ($banners as $hash => $banner) {
                    if (!empty($banner['image']) && !empty($banner['link'])) {
                        $html .= '<div data-src="' . Mage::getBaseUrl('media') . ltrim($banner['image'], '/') .
                            '" data-link="' . $banner['link'] . '"></div>';
                    }
                }
            }
            return $html;
        }
        return '';
    }

    /**
     * Returns config for camera library for slider 
     * 
     * @return string
     */
    public function getCameraConfig() {
        $config = array(
            'alignmen' => 'topCenter',
            'height' => '51.26436781609195%',
            'minHeight' => '100px',
            'loader' => false,
            'navigation' => true,
            'fx' => 'simpleFade',
            'navigationHover' => false,
            'thumbnails' => false,
            'playPause' => false,
            'pagination' => false,
            'time' => Mage::getStoreConfig(self::CONFIG_PATH_SLIDER_ANIM_DURATION),
            'transPeriod' => Mage::getStoreConfig(self::CONFIG_PATH_SLIDER_ANIM_SPEED)
        );
        return json_encode($config);
    }

    /**
     * Returns bottom banner
     *
     * @return string
     */
    public function getBottomBanner() {
        if ($this->isBannersEnabled() && ($image = Mage::getStoreConfig(self::CONFIG_PATH_BANNER_BOTTOM))) {
            if (strpos($image, '{skin}') !== false) {
                $image = str_replace('{skin}', Mage::getDesign()->getSkinUrl() . 'images', $image);
            } else {
                $image = Mage::getBaseUrl('media') . $image;
            }
            if ($link = Mage::getStoreConfig(self::CONFIG_PATH_BANNER_LINK)) {
                return '<a href="' . $link . '"><img src="' . $image . '"></a>';
            } else {
                return '<img src="' . $image . '">';
            }
        }
        return '';
    }

    /**
     * Returns if featured products should be shown at all
     *
     * @return bool
     */
    public function isFeaturedEnabled() {
        return Mage::getStoreConfig(self::CONFIG_PATH_FEATURED_ENABLED);
    }

    /**
     * Returns column count for featured products list
     *
     * @return int
     */
    public function getFeaturedColumnCount() {
        return Mage::getStoreConfig(self::CONFIG_PATH_FEATURED_COLUMN_COUNT);
    }

    /**
     * Returns product limit for featured products list
     *
     * @return int
     */
    public function getFeaturedProductLimit() {
        return Mage::getStoreConfig(self::CONFIG_PATH_FEATURED_PRODUCT_LIMIT);
    }
}