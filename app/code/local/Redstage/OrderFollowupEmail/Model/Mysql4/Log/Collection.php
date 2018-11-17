<?php
/**
 * Add Redstage_OrderFollowupEmail_Model_Mysql4_Log_Collection so collection can be called
 *
 * @category   Lyons
 * @package    Redstage_OrderFollowupEmail
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Redstage_OrderFollowupEmail_Model_Mysql4_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('orderfollowupemail/log');
    }
}