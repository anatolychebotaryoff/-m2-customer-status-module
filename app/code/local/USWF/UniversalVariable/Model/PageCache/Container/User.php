<?php
/**
 * User.php
 *
 * @category    USWF
 * @package     USWF_UniversalVariable
 * @copyright
 * @author
 */
class USWF_UniversalVariable_Model_PageCache_Container_User extends Enterprise_PageCache_Model_Container_Abstract 
{
    
    const COOKIE_HD_GROUP = 'hd_groupid';
    const CACHE_TAG_PREFIX = 'uv_user_';
    
    /**
     * Get cache identifier
     *
     * @return string
     */
    public static function getCacheId()
    {
        $cookieCustomer = Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER;
        $cookieHdGroup = self::COOKIE_HD_GROUP;
        $cookieUVEmail = USWF_UniversalVariable_Helper_Data::EMAIL_COOKIE_NAME;
        return md5(self::CACHE_TAG_PREFIX
            . (array_key_exists($cookieCustomer, $_COOKIE) ? $_COOKIE[$cookieCustomer] : '')
            . (array_key_exists($cookieHdGroup, $_COOKIE) ? $_COOKIE[$cookieHdGroup] : '')
            . (array_key_exists($cookieUVEmail, $_COOKIE) ? $_COOKIE[$cookieUVEmail] : ''));
    }

    /**
     * Get cache identifier
     *
     * @return string
     */
    protected function _getCacheId()
    {
        return USWF_UniversalVariable_Model_PageCache_Container_User::getCacheId();
    }

    /**
     * Render block content
     *
     * @return string
     */
    protected function _renderBlock()
    {
        $layout = Mage::app()->getLayout();
        $layout->createBlock('USWF_UniversalVariable_Block_User','uv_user');
        if ($block = Mage::app()->getLayout()->getBlock('uv_user')) {
            $block->setTemplate('qubit/uv_user.phtml');
            Mage::getSingleton('universal_variable_main/page_observer')->_setUser();
            return $block->toHtml();
        } else {
            return false;
        }
    }
}