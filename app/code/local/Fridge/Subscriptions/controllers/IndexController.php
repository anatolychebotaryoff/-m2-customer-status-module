<?php
class Fridge_Subscriptions_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Checking if user is logged in or not
	 * If not logged in then redirect to customer login
	 */
	public function preDispatch()
	{
	    parent::preDispatch();
	    if (!Mage::getSingleton('customer/session')->authenticate($this)) {
	        $this->setFlag('', 'no-dispatch', true);
	    }
	}
	
	public function indexAction()
	{
		$this->loadLayout(array('default'));
		$this->renderLayout();
	}

}