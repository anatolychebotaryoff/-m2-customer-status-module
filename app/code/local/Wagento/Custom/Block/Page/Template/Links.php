<?php
class Wagento_Custom_Block_Page_Template_Links extends Mage_Page_Block_Template_Links{

	public function removeTopLink($label){
		foreach ($this->_links as $key => $link) {
			if ($link->getLabel() == $label) {
				unset($this->_links[$key]);
				break;
			}
		}
		return $this;
	}
}

?>