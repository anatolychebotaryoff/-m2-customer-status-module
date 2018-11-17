<?php
/**
 * Details.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Tabs_Details extends Mage_Core_Block_Template
{
    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/widget/compare/tabs/details.phtml');
        $this->setLabel('Details');
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
            $this->getWidget()->getData('details1'),
            $this->getWidget()->getData('details2')
        );
        return !$this->getWidget()->getData('tier1_position') ?
            array($header, $body) : array(array_reverse($header), array_reverse($body));
    }
}