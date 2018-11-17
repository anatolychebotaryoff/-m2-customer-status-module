<?php 
class Wagento_Custom_Block_Customer_Account_Navigation extends Mage_Customer_Block_Account_Navigation{

	public function removeLink($name)
    {
        unset($this->_links[$name]);
        return $this;
    }
    public function removeAllLink()
    {
        foreach ($this->_links as $k => $v) {
            unset($this->_links[$k]);
        }
        return $this;
    }
}
?>