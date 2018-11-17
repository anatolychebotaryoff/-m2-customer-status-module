<?php
/**
 * Type.php
 *
 * @category    USWF
 * @package     USWF_Popup
 * @copyright
 * @author
 */
class USWF_Popup_Model_System_Config_Source_Page_Type
{
    const CMS_PAGE = 'cms_page';
    const HOME_PAGE = 'home_page';
    const PRODUCT_PAGE = 'product_page';
    const CATEGORY_PAGE = 'category_page';
    const CART_PAGE = 'cart_page';
    const SEARCH_PAGE = 'search_page';
    const OTHER_PAGE = 'other_page';
    
    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::CMS_PAGE,
                'label' => Mage::helper('uswf_popup')->__('CMS Pages')
            ),
            array(
                'value' => self::HOME_PAGE,
                'label' => Mage::helper('uswf_popup')->__('Home Page')
            ),
            array(
                'value' => self::PRODUCT_PAGE,
                'label' => Mage::helper('uswf_popup')->__('Product Pages')
            ),
            array(
                'value' => self::CATEGORY_PAGE,
                'label' => Mage::helper('uswf_popup')->__('Category Pages')
            ),
            array(
                'value' => self::CART_PAGE,
                'label' => Mage::helper('uswf_popup')->__('Shopping Cart')
            ),
            array(
                'value' => self::SEARCH_PAGE,
                'label' => Mage::helper('uswf_popup')->__('Search Page')
            ),
            array(
                'value' => self::OTHER_PAGE,
                'label' => Mage::helper('uswf_popup')->__('Other Pages')
            )
        );
    }
}