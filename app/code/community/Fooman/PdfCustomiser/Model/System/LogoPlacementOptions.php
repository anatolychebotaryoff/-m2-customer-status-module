<?php
class Fooman_PdfCustomiser_Model_System_LogoPlacementOptions
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'auto', 'label'=>Mage::helper('pdfcustomiser')->__('automatic')),
            array('value'=>'no-scaling', 'label'=>Mage::helper('pdfcustomiser')->__('no scaling')),
            array('value'=>'manual', 'label'=>Mage::helper('pdfcustomiser')->__('manual'))
        );
    }


}