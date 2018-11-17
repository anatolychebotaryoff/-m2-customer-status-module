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
 * @copyright  Copyright (c) 2012 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */

$installer = $this;
$installer->startSetup();

try {
    $pathFrom = 'mageworx_seo/seosuite/enable_rich_snippets';
    $pathTo   = 'mageworx_seo/richsnippets/enable';
    $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $pathFrom);
    if ($collection->count() > 0) {
        foreach ($collection as $coreConfig) {
            $coreConfig->setPath($pathTo)->save();
        }
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), Zend_Log::ERR);
}

try {
    $pathFrom = 'mageworx_seo/seosuite/product_og_enabled';
    $pathTo   = 'mageworx_seo/richsnippets/product_og_enabled';
    $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $pathFrom);
    if ($collection->count() > 0) {
        foreach ($collection as $coreConfig) {
            $coreConfig->setPath($pathTo)->save();
        }
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), Zend_Log::ERR);
}

try {
    $pathFrom = 'mageworx_seo/seosuite/enable_dynamic_meta_title';
    $pathTo   = 'mageworx_seo/seosuite/status_dynamic_meta_title';
    $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $pathFrom);
    if ($collection->count() > 0) {
        foreach ($collection as $coreConfig) {
            $coreConfig->setPath($pathTo)->save();
            if(!$coreConfig->getValue()){
                $coreConfig->setValue('off');
            }elseif($coreConfig->getValue()){
                $coreConfig->setValue('on');
            }
        }
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), Zend_Log::ERR);
}

try {
    $pathFrom = 'mageworx_seo/seosuite/enable_dynamic_meta_desc';
    $pathTo   = 'mageworx_seo/seosuite/status_dynamic_meta_desc';
    $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $pathFrom);
    if ($collection->count() > 0) {
        foreach ($collection as $coreConfig) {
            if(!$coreConfig->getValue()){
                $coreConfig->setValue('off');
            }elseif($coreConfig->getValue()){
                $coreConfig->setValue('on');
            }
            $coreConfig->setPath($pathTo)->save();
        }
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), Zend_Log::ERR);
}

try {
    $pathFrom = 'mageworx_seo/seosuite/enable_dynamic_meta_keywords';
    $pathTo   = 'mageworx_seo/seosuite/status_dynamic_meta_keywords';
    $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $pathFrom);
    if ($collection->count() > 0) {
        foreach ($collection as $coreConfig) {
            if(!$coreConfig->getValue()){
                $coreConfig->setValue('off');
            }elseif($coreConfig->getValue()){
                $coreConfig->setValue('on');
            }
            $coreConfig->setPath($pathTo)->save();
        }
    }
} catch (Exception $e) {
    Mage::log($e->getMessage(), Zend_Log::ERR);
}

try {
    $pathOld1 = 'mageworx_seo/seosuite/disable_layered_rewrites';
    $pathOld2 = 'mageworx_seo/seosuite/layered_friendly_urls';
    $pathTo   = 'mageworx_seo/seosuite/enable_ln_friendly_urls';

    $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $pathOld1);
    if ($collection->count() > 0) {
        foreach ($collection as $coreConfig) {
            if((bool)$coreConfig->getValue()){
                $coreConfig->setValue(0);
            }else{
                $coreConfig->setValue(1);
            }
            $coreConfig->setPath($pathTo)->save();
        }
    }
    
    $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', $pathOld2);
    if ($collection->count() > 0) {
        foreach ($collection as $coreConfig) {
            $coreConfig->delete();
        }
    }

} catch (Exception $e) {
    Mage::log($e->getMessage(), Zend_Log::ERR);
}

$installer->endSetup();