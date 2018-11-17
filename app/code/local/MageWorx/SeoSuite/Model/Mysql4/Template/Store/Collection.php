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
class MageWorx_SeoSuite_Model_Mysql4_Template_Store_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('seosuite/template_store');
    }

    public function addStatus()
    {
        $this->getSelect()
                ->joinInner(array('t' => $this->getTable('seosuite/template')), 'main_table.template_id=t.template_id',
                        array('status' => 't.status'));
        return $this;
    }

    public function filterStoreId($storeId)
    {
        $this->getSelect()->where('main_table.store_id =?', $storeId);
        return $this;
    }

    public function filterTemplateId($templateId)
    {
        $this->getSelect()->where('main_table.template_id =?', $templateId);
        return $this;
    }

    public function filterTemplateCode($templateCode)
    {
        $this->getSelect()->where('template_code =?', $templateCode);
        //   echo $this->getSelect()->__toString(); exit;
        return $this;
    }

}