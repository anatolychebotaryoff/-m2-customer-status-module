<?php 
class Wagento_Custom_Block_Page_Html_Header extends Mage_Page_Block_Html_Header{
	public function getWelcome()
    {
        /*if (empty($this->_data['welcome'])) {
            if (Mage::isInstalled() && Mage::getSingleton('customer/session')->isLoggedIn()) {
                $this->_data['welcome'] = $this->__('Welcome, %s!', $this->escapeHtml(Mage::getSingleton('customer/session')->getCustomer()->getName()));
            } else {
                $this->_data['welcome'] = Mage::getStoreConfig('design/header/welcome');
            }
        }*/
        $this->_data['welcome'] = $this->__('Free Shipping On Order Over $99');

        return $this->_data['welcome'];
    }
} 