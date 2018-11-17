<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Popup
 * @copyright
 * @author
 */
class USWF_Popup_Helper_Data extends Mage_Core_Helper_Abstract
{

    const USWF_POPUP_ENABLED_CONFIG_PATH = 'uswf_popup/configuration/enabled';
    const USWF_POPUP_WIDTH_CONFIG_PATH = 'uswf_popup/configuration/width';
    const USWF_POPUP_HEIGHT_CONFIG_PATH = 'uswf_popup/configuration/height';
    const USWF_POPUP_DELAY_CONFIG_PATH = 'uswf_popup/configuration/delay';
    const USWF_POPUP_ANIMATION_TYPE_CONFIG_PATH = 'uswf_popup/configuration/animation_type';
    const USWF_POPUP_ANIMATION_SPEED_CONFIG_PATH = 'uswf_popup/configuration/animation_speed';
    const USWF_POPUP_OVERLAY_COLOR_CONFIG_PATH = 'uswf_popup/configuration/overlay_color';
    const USWF_POPUP_OVERLAY_OPACITY_CONFIG_PATH = 'uswf_popup/configuration/overlay_opacity';
    const USWF_POPUP_BLOCK_CONFIG_PATH = 'uswf_popup/configuration/cms_block';
    const USWF_POPUP_ONLY_FOR_FIRST_TIME_USERS_CONFIG_PATH = 'uswf_popup/configuration/first_time_user';
    const USWF_POPUP_IGNORE_PLATFORM_CONFIG_PATH = 'uswf_popup/configuration/ignore_platform';
    const USWF_POPUP_ALLOWED_PAGE_TYPE_CONFIG_PATH = 'uswf_popup/configuration/page_type';
    
    const DEFAULT_POPUP_DELAY = 5000;
    const DEFAULT_POPUP_ANIMATION_SPEED = 600;
    const DEFAULT_OVERLAY_COLOR = '#0000000';
    const DEFAULT_OVERLAY_OPACITY = '0.6';
    const ZINDEX = 99999;
    static $cmsBlockHtml = null;
    
    const HEX_COLOR_PATTERN = '/(?:[0-9a-fA-F]{6}|[0-9a-fA-F]{3})/';
    const POPUP_COOKIE_NAME = 'uswf_popup';
    const POPUP_COOKIE_LIFETIME = 315360000;
    const WFN_WEBSITE_ID = 1;
    
    /**
     * Returns if popup is enabled
     *
     * @return boolean
     */
    public function isPopupEnabled() {
        /**
         * Check new user
         */ 
        if (Mage::getStoreConfig(self::USWF_POPUP_ONLY_FOR_FIRST_TIME_USERS_CONFIG_PATH)) {
            $visitorData = Mage::getSingleton('core/session')->getVisitorData();
            $newUserFlag = !isset($visitorData['is_new_visitor']) || $visitorData['is_new_visitor']; 
        } else {
            $newUserFlag = true;
        }
        //if magento user log checking fails (disabled, cleaned etc) or we display popup for all users,
        //then set/check cookie to show popup only one time
        if (!Mage::getModel('core/cookie')->get(self::POPUP_COOKIE_NAME)) {
            Mage::getModel('core/cookie')->set(self::POPUP_COOKIE_NAME, true, self::POPUP_COOKIE_LIFETIME);
        } else {
            $newUserFlag = false;
        }

        /**
         * Check platform restrictions
         */
        $platformCheck = $this->checkPlatform();

        /**
         * Check page type restrictions
         */
        $pageTypeCheck = $this->checkPageType();
        
        return $newUserFlag && $platformCheck && $pageTypeCheck &&
            Mage::getStoreConfig(self::USWF_POPUP_ENABLED_CONFIG_PATH) && $this->getCmsBlock();
    }

    /**
     * Check if platform have no restrictions to show pop up
     * 
     * @return bool
     */
    protected function checkPlatform() {
        $ignorePlatforms = Mage::getStoreConfig(self::USWF_POPUP_IGNORE_PLATFORM_CONFIG_PATH);
        $ignorePlatforms = $ignorePlatforms ? explode(',', $ignorePlatforms) : array();
        $detect = Mage::helper('uswf_popup/mobileDetect');
        foreach ($ignorePlatforms as $platform) {
            switch ($platform) {
                case USWF_Popup_Model_System_Config_Source_Platform::MOBILE:
                    if ($detect->isMobile()) {
                        return false;
                    }
                    break;
                case USWF_Popup_Model_System_Config_Source_Platform::TABLET:
                    if ($detect->isTablet()) {
                        return false;
                    }
                    break;
                default:
                    break;
            }
        }
        return true;
    }

    /**
     * Check if page type is allowed to show pop up
     *
     * @return bool
     */
    protected function checkPageType() {
        $allowedPageTypes = Mage::getStoreConfig(self::USWF_POPUP_ALLOWED_PAGE_TYPE_CONFIG_PATH);
        $allowedPageTypes = $allowedPageTypes ? explode(',', $allowedPageTypes) : array();
        return in_array($this->getCurrentPageType(), $allowedPageTypes);
    }

    
    /**
     * Returns popup modal window styles
     * 
     * @return string
     */
    public function getPopupStyle() {
        $styles = array('display:none');
        if (Mage::getStoreConfig(self::USWF_POPUP_WIDTH_CONFIG_PATH)) {
            $styles[] = 'width:' . Mage::getStoreConfig(self::USWF_POPUP_WIDTH_CONFIG_PATH) . 'px';
        }
        if (Mage::getStoreConfig(self::USWF_POPUP_HEIGHT_CONFIG_PATH)) {
            $styles[] = 'height:' . Mage::getStoreConfig(self::USWF_POPUP_HEIGHT_CONFIG_PATH) . 'px';
        }
        return implode(';', $styles);
    }

    /**
     * Returns popup delay for appear
     * 
     * @return int
     */
    public function getPopupDelay() {
        return Mage::getStoreConfig(self::USWF_POPUP_DELAY_CONFIG_PATH) ?
            Mage::getStoreConfig(self::USWF_POPUP_DELAY_CONFIG_PATH) : self::DEFAULT_POPUP_DELAY;
    }

    /**
     * Returns popup js params in json
     * 
     * @return string
     */
    public function getPopupJSParams() {
        $speed = is_numeric(Mage::getStoreConfig(self::USWF_POPUP_ANIMATION_SPEED_CONFIG_PATH)) ?
            Mage::getStoreConfig(self::USWF_POPUP_ANIMATION_SPEED_CONFIG_PATH) : self::DEFAULT_POPUP_ANIMATION_SPEED;
        $color = (string) Mage::getStoreConfig(self::USWF_POPUP_OVERLAY_COLOR_CONFIG_PATH);
        preg_match(self::HEX_COLOR_PATTERN, $color, $colorMatches);
        if (is_array($colorMatches) && count($colorMatches) > 0) {
            $color = '#' . reset($colorMatches);
        } else {
            $color = self::DEFAULT_OVERLAY_COLOR;
        }
        $opacity = (float) Mage::getStoreConfig(self::USWF_POPUP_OVERLAY_OPACITY_CONFIG_PATH);
        $opacity = ($opacity >= 0 && $opacity <= 1) ? $opacity : self::DEFAULT_OVERLAY_OPACITY;
        $params = array(
            'speed' => (int)$speed,
            'opacity' => $opacity,
            'modalColor' => $color,
            'zIndex' => self::ZINDEX
        );
        switch (Mage::getStoreConfig(self::USWF_POPUP_ANIMATION_TYPE_CONFIG_PATH)) {
            case USWF_Popup_Model_System_Config_Source_Popup_Animation_Type::FALLING:
                //dirty hack for wfn website because of massive number of incompatibility java scripts for that site
                if (Mage::app()->getStore()->getWebsiteId() != self::WFN_WEBSITE_ID) {
                    $params['transition'] = 'slideDown';
                    $params['easing'] = 'easeOutBack';
                } else {
                    $params['positionStyle'] = 'fixed';
                }
                break;
            case USWF_Popup_Model_System_Config_Source_Popup_Animation_Type::SLIDING:
                $params['transition'] = 'slideIn';
                $params['transitionClose'] = 'slideBack';
                break;
            case USWF_Popup_Model_System_Config_Source_Popup_Animation_Type::SIMPLE:
            default:
                $params['positionStyle'] = 'fixed';
                break;
        }
        return json_encode($params);
    }

    /**
     * Returns CMS Block html
     * 
     * @return string
     */
    public function getCmsBlock() {
        if (is_null(static::$cmsBlockHtml)) {
            static::$cmsBlockHtml = 
                is_string(Mage::getStoreConfig(self::USWF_POPUP_BLOCK_CONFIG_PATH)) ?
                    Mage::app()->getLayout()
                        ->createBlock('cms/block')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->setBlockId(Mage::getStoreConfig(self::USWF_POPUP_BLOCK_CONFIG_PATH))
                        ->toHtml() : '';
        }
        return static::$cmsBlockHtml;
    }

    /**
     * Returns current page type
     * 
     * @return string
     */
    protected function getCurrentPageType() {
        $fullActionName = Mage::app()->getFrontController()->getAction()->getFullActionName();
        $page = Mage::getSingleton('cms/page');
        if ($page->getId()) {
            if ($page->getIdentifier() == Mage::getStoreConfig('web/default/cms_home_page')) {
                return USWF_Popup_Model_System_Config_Source_Page_Type::HOME_PAGE;
            } else {
                if ($page->getIdentifier() == 'search') {
                    return USWF_Popup_Model_System_Config_Source_Page_Type::SEARCH_PAGE;
                } else {
                    return USWF_Popup_Model_System_Config_Source_Page_Type::CMS_PAGE;
                }
            }
        }
        $product = Mage::registry('current_product');
        $category = Mage::registry('current_category');
        if ($product && $product->getId()) {
            return USWF_Popup_Model_System_Config_Source_Page_Type::PRODUCT_PAGE;
        } elseif ($category && $category->getId()) {
            return USWF_Popup_Model_System_Config_Source_Page_Type::CATEGORY_PAGE;
        }
        if ($fullActionName == 'checkout_cart_index') {
            return USWF_Popup_Model_System_Config_Source_Page_Type::CART_PAGE;
        }
        if (0 === strpos($fullActionName, 'catalogsearch_')) {
            return USWF_Popup_Model_System_Config_Source_Page_Type::SEARCH_PAGE;
        }
        return USWF_Popup_Model_System_Config_Source_Page_Type::OTHER_PAGE;
    }
}