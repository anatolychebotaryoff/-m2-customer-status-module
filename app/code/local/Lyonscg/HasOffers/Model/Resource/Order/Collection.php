<?php
/**
 * Add support for HasOffers integration
 *
 * @category  Lyons
 * @package   Lyonscg_HasOffers
 * @author    Logan Montgomery <lmontgomery@lyonscg.com>
 * @copyright Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_HasOffers_Model_Resource_Order_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->init('lyonscg_hasoffers/order');
    }
}