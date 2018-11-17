<?php

/**
 * Flag stores status about availability not applied catalog price rules
 */

class USWF_GiftPurchase_Model_Flag extends Mage_Core_Model_Flag
{
    /**
     * Flag code
     *
     * @var string
     */
    protected $_flagCode = 'giftpurchase_rules_dirty';
}
