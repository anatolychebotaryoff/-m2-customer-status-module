<?php

class Lyonscg_Hotdeal_Helper_Data extends Mage_Core_Helper_Abstract {

    public function checkSubscriptionHotdeal($requestObject) {
	$hotDeal = Mage::registry('hotdeal');
	if(!$hotDeal && \
		Mage::getStoreConfig('autoship_general/general/enabled') == '1' && \
		Mage::getStoreConfig('autoship_subscription/subscription/use_new_subscription_page') != '1') {

		return True;
	}
	return False;
    }

}

