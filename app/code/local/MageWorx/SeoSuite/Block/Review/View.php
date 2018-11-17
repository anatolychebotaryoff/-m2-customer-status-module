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
class MageWorx_SeoSuite_Block_Review_View extends Mage_Review_Block_View
{

    public function __construct()
    {
        parent::__construct();
        if (!Mage::registry('current_product')) {
            Mage::register('current_product', $this->getProductData());
        }
    }

    public function getBackUrl()
    {
        if (Mage::getStoreConfig('mageworx_seo/seosuite/reviews_friendly_urls')) {
            return Mage::getUrl() . implode('/', array($this->getProductData()->getUrlKey(), 'reviews'));
        }
        else {
            return parent::getBackUrl();
        }
    }

}