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
class MageWorx_SeoSuite_Helper_Report extends Mage_Core_Helper_Abstract
{
    const MAX_LENGTH_META_TITLE                    = 70;
    const MAX_LENGTH_META_DESCRIPTION              = 150;

    const XML_PATH_SEOSUITE_PRODUCT_REPORT_STATUS  = 'mageworx_seo/seosuite/product_report_status';
    const XML_PATH_SEOSUITE_CATEGORY_REPORT_STATUS = 'mageworx_seo/seosuite/category_report_status';
    const XML_PATH_SEOSUITE_CMS_REPORT_STATUS      = 'mageworx_seo/seosuite/cms_report_status';

    public function setProductReportStatus($flag)
    {
        Mage::getConfig()->saveConfig(self::XML_PATH_SEOSUITE_PRODUCT_REPORT_STATUS, $flag);
    }

    public function getProductReportStatus()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_SEOSUITE_PRODUCT_REPORT_STATUS);
    }

    public function setCategoryReportStatus($flag)
    {
        Mage::getConfig()->saveConfig(self::XML_PATH_SEOSUITE_CATEGORY_REPORT_STATUS, $flag);
    }

    public function getCategoryReportStatus()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_SEOSUITE_CATEGORY_REPORT_STATUS);
    }

    public function setCmsReportStatus($flag)
    {
        // if doesn't work, check save new row in DB!!!!!!!!
        Mage::getConfig()->saveConfig(self::XML_PATH_SEOSUITE_CMS_REPORT_STATUS, $flag);
    }

    public function getCmsReportStatus()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_SEOSUITE_CMS_REPORT_STATUS);
    }

    public function getMaxLengthMetaTitle()
    {
        return self::MAX_LENGTH_META_TITLE;
    }

    public function getMaxLengthMetaDescription()
    {
        return self::MAX_LENGTH_META_DESCRIPTION;
    }

    public function getErrorTypes($arr = array())
    {
        $errorTypes = array();
        if (empty($arr) || in_array('missing', $arr)) {
            $errorTypes['missing'] = $this->__('Missing');
        }
        if (empty($arr) || in_array('long', $arr)) {
            $errorTypes['long'] = $this->__('Long');
        }
        if (empty($arr) || in_array('duplicate', $arr)) {
            $errorTypes['duplicate'] = $this->__('Duplicate');
        }
        return $errorTypes;
    }

    public function _trimText($str)
    {
        if (!$str) {
            return '';
        }
        return trim(preg_replace("/\s+/is", ' ', $str));
    }

    public function _prepareText($str)
    {
//        echo '***'.$str.'***';
        if (!$str) {
            return '';
        }
        $str = strtolower(preg_replace("/[^\w\d]+/is", ' ', $str));
//        echo '***'.$this->_trimText($str).'***';
        return $this->_trimText($str);
    }
}