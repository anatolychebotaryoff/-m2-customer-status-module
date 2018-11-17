<?php
/**
* aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento ENTERPRISE edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento ENTERPRISE edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_AdvancedReviews
 * @version    2.2.4
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-ENTERPRISE.txt
 */

class AW_AdvancedReviews_Block_Ajax_Content extends Mage_Core_Block_Template
{
    public function disableNativeReviews()
    {
        if (Mage::helper('advancedreviews')->getExtDisabled()){
            return $this;
        }

        $this->getParentBlock()
                ->unsetChild('product_additional_data')
                ->setChild('product_additional_data', $this)
                ;
        return $this;
    }
    
    public function getFilteredAction()
    {
        $url = 'advancedreviews/proscons/checkbyproscons';

        if($id = $this->getRequest()->getParam('id'))
            $url.= '/id/'.$id.'/';
        if($customerId = $this->getCustomerId())
            $url.= '/customerId/'.$customerId.'/';
        if($page = $this->getPage())
            $url.= 'p/'.$page.'/';

        return $this->getUrl($url);
    }

    public function getUpdatePagerAction()
    {
        $url = 'advancedreviews/proscons/updatepager';
        return $this->getUrl($url);
    }

    public function getFilteredReviewsAction(){
        $url = 'advancedreviews/proscons/getfilteredreviews';
        return $this->getUrl($url);
    }
}