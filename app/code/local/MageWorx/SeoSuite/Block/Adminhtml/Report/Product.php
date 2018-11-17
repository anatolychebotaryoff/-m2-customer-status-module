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
class MageWorx_Seosuite_Block_Adminhtml_Report_Product extends Mage_Adminhtml_Block_Widget_Container
{

    protected function _prepareLayout()
    {
        $this->_addButton('generate',
                array(
            'label'   => Mage::helper('seosuite')->__('Generate'),
            'onclick' => "setLocation('{$this->getUrl('*/*/generate')}')",
            'class'   => 'generate'
        ));
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        if (!$storeId) {
            Mage::app()->getRequest()->setParam('store', 1);
        }
        $this->setChild('grid',
                $this->getLayout()->createBlock('seosuite/adminhtml_report_product_grid', 'seosuite.report.product.grid'));
        return parent::_prepareLayout();
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

}
