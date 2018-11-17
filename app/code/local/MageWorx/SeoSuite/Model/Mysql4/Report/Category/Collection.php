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
class MageWorx_SeoSuite_Model_Mysql4_Report_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('seosuite/report_category');
    }

    public function addFieldToFilter($field, $condition = null)
    {
        if ($field == 'meta_title_error') {
            if ($condition == 'missing') {
                $field     = 'prepared_meta_title';
                $condition = array('eq' => '');
            }
            elseif ($condition == 'long') {
                $field     = 'meta_title_len';
                $condition = array('gt' => '70');
            }
            elseif ($condition == 'duplicate') {
                $field     = 'meta_title_dupl';
                $condition = array('gt' => '1');
            }
        }
        elseif ($field == 'name_error') {
            if ($condition == 'duplicate') {
                $field     = 'name_dupl';
                $condition = array('gt' => '1');
            }
        }
        elseif ($field == 'meta_descr_error') {
            if ($condition == 'missing') {
                $field     = 'meta_descr_len';
                $condition = array('eq' => '0');
            }
            elseif ($condition == 'long') {
                $field     = 'meta_descr_len';
                $condition = array('gt' => '150');
            }
        }
        return parent::addFieldToFilter($field, $condition);
    }

}