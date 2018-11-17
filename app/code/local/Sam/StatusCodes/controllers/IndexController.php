<?php
class Sam_StatusCodes_IndexController extends Mage_Core_Controller_Front_Action
{
   public function indexAction()
   {
   		if (Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			$address = Mage::getModel('customer/address')->load($customer->getPrimaryBillingAddress()->getEntityId());
			if (null !== $this->getRequest()->getParam('telephone')) {
				$address->setTelephone($this->getRequest()->getParam('telephone'));
			}
			if (null !== $this->getRequest()->getParam('postcode')) {
				$address->setPostcode($this->getRequest()->getParam('postcode'));
			}
			$address->save();
			Mage::unregister('sam_wrong_input');
			Mage::getSingleton('core/session')->addSuccess($this->__('You updated your data'));
   		}
   		$this->_redirect("onestepcheckout/*/*");
   }

}
