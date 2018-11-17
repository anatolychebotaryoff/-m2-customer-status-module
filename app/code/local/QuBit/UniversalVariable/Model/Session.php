<?php

class QuBit_UniversalVariable_Model_Session extends Mage_Core_Model_Session_Abstract
{

	/**
	 * QuBit_UniversalVariable_Model_Session constructor.
	 */
	public function __construct() {
		$this->init('qubit');
	}

}