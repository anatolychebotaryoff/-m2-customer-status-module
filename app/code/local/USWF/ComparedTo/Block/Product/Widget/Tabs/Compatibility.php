<?php
/**
 * Compatibility.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Tabs_Compatibility extends Mage_Core_Block_Template
{
    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/widget/compare/tabs/compatibility.phtml');
        $this->setLabel('Compatibility');
        return parent::_prepareLayout();
    }

    /**
     * Returns content of tab table
     *
     * @return array($header, $body)
     */
    public function getContent() {
        $header =  array(
            'tier1' => $this->getWidget()->getData('label1'),
            'oem' => $this->getWidget()->getData('label2')
        );
        $body = array(
            $this->getWidget()->getData('compatibility1'),
            $this->getWidget()->getData('compatibility2')
        );
        return !$this->getWidget()->getData('tier1_position') ?
            array($header, $body) : array(array_reverse($header), array_reverse($body));
    }
}