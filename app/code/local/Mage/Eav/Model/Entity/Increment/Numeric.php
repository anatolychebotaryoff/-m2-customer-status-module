<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Eav
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * Enter description here...
 *
 * Properties:
 * - prefix
 * - pad_length
 * - pad_char
 * - last_id
 */
class Mage_Eav_Model_Entity_Increment_Numeric extends Mage_Eav_Model_Entity_Increment_Abstract
{
   public function getNextId()
    {
        $last = $this->getLastId();
        $storeCode    = Mage::app()->getStore()->getCode();

        if($storeCode == 'admin'){
            $storeId = $this->getData('store_id');
            $storeCode = Mage::app()->getStore($storeId)->getCode();
        }

        //just fot sure...
        $prefix = $this->getPrefix();

        if($storeCode){
            if($storeCode == 'wfn_en'){
                $prefix = 'WFN';
            }elseif($storeCode == 'default'){
                $prefix = 'AFA';
            }elseif($storeCode == 'ff_en'){
                $prefix = 'FF';
            }elseif($storeCode == 'dfs_en'){
                $prefix = 'DFS';
            }elseif($storeCode == 'sf_en'){
                $prefix = 'SF';
            }elseif($storeCode == 'rb_en'){
                $prefix = 'RB';
            }
        }

        if (strpos($last, $prefix) === 0) {
            $last = (int)substr($last, strlen($prefix));
        } else {
            $last = (int)$last;
        }

        $next = $last+1;
        return $this->format($next,$prefix);
    }
    public function format($id, $prefix = '')
    {
        $result = $prefix;
        $result.= str_pad((string)$id, $this->getPadLength(), $this->getPadChar(), STR_PAD_LEFT);
        return $result;
        
    }
}
