<?php 
class QuBit_UniversalVariable_Block_Uv extends Mage_Core_Block_Template {

	public function getOfferId() {
		$session = Mage::getSingleton('universal_variable_main/session');
		return $session->getOfferId();
	}

	public function getAffiliateId() {
		$session = Mage::getSingleton('universal_variable_main/session');
		return $session->getAffiliateId();
	}

	public function getTransactionId() {
		$session = Mage::getSingleton('universal_variable_main/session');
		return $session->getTransactionId();
	}

}
