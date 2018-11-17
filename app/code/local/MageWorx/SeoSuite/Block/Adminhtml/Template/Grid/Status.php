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
class MageWorx_Seosuite_Block_Adminhtml_Template_Grid_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Date
{

    public function getStoreId()
    {
        $store = $this->getRequest()->getParam('store');
        if (!$store) {
            $store = 0;
        }
        return $store;
    }

    public function render(Varien_Object $row)
    {
        $url    = $this->getUrl("*/*/changeStatus", array('template_id' => $row->getId()));
        $status = $this->__('Enable');
        if ($row->getStatus()) {
            $status = $this->__('Disable');
        }
        $value = '<a href="' . $url . '">' . $status . "</a>";
        return $value;
    }

}