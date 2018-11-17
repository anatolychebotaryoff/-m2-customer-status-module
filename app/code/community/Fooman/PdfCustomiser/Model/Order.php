<?php

class Fooman_PdfCustomiser_Model_Order extends Fooman_PdfCustomiser_Model_Abstract
{
    /**
    * Creates PDF using the tcpdf library from array of orderIds
    * @param array $invoices, $orderIds
    * @access public
    */
    public function getPdf($ordersGiven = array(),$orderIds = array(), $pdf = null, $suppressOutput = false)
    {

        //check if there is anything to print
		if(empty($pdf) && empty($ordersGiven) && empty($orderIds)){
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('There are no printable documents related to selected orders'));
			return false;
		}

        //we will be working through an array of orderIds later - fill it up if only $ordersGiven is available
        if(!empty($ordersGiven)){
            foreach ($ordersGiven as $orderGiven) {
                    $orderIds[] = $orderGiven->getId();
            }
        }

        $this->_beforeGetPdf();

        $storeId = $order = Mage::getModel('sales/order')->load($orderIds[0])->getStoreId();

        //work with a new pdf or add to existing one
        if(empty($pdf)){
            $pdf = new Fooman_PdfCustomiser_Model_Mypdf('P', 'mm',  Mage::getStoreConfig('sales_pdf/all/allpagesize',$storeId), true, 'UTF-8', false);
        }

        // create new invoice helper
        $orderHelper = new Fooman_PdfCustomiser_Order($storeId);
        //$pdf->SetHeaderData(($pdf->getPdfLogo()?'':$pdf->getPdfLogo()), $pdf->getPdfLogoDimensions('w'),$orderHelper->getPdfOrderTitle());

        foreach ($orderIds as $orderId) {
            //load data
			
            $order = Mage::getModel('sales/order')->load($orderId);

            // create new creditmemo helper
            $orderHelper = new Fooman_PdfCustomiser_Order();

            $storeId = $order->getStoreId();
            if ($order->getStoreId()) {
                Mage::app()->getLocale()->emulate($order->getStoreId());
            }

            $orderHelper->setStoreId($storeId);
	    $pdf->setStoreId($storeId);
            // set standard pdf info
            $pdf->SetStandard($orderHelper);

            // add a new page
            $pdf->AddPage();
            $pdf->printHeader($orderHelper, $orderHelper->getPdfOrderTitle());

            $orderNumbersEtc = Mage::helper('sales')->__('Order #').': '. $order->getIncrementId()."\n";

            $orderNumbersEtc .= Mage::helper('catalog')->__('Date').': '.Mage::helper('core')->formatDate($order->getCreatedAtStoreDate(), 'medium', false)."\n";
            $pdf->MultiCell($pdf->getPageWidth() / 2 - $orderHelper->getPdfMargins('sides'), 0, $orderNumbersEtc, 0, 'L', 0, 0);
            $pdf->MultiCell($pdf->getPageWidth() / 2 - $orderHelper->getPdfMargins('sides'), $pdf->getLastH(), $orderHelper->getPdfOwnerAddresss(), 0, 'L', 0, 1);
            $pdf->Ln(5);

            //add billing and shipping addresses
            $pdf->OutputCustomerAddresses($orderHelper, $order, $orderHelper->getPdfOrderAddresses());

            //Display both currencies if flag is set and order is in a different currency
            $displayBoth = $orderHelper->getDisplayBoth() && $order->isCurrencyDifferent();

            // Output Shipping and Payment
            $pdf->OutputPaymentAndShipping($orderHelper, $order, $order);

            // Output heading for Items
            $tbl ='<table width="100%" border="0" cellpadding="2" cellspacing="0">';
            $tbl.='<thead>';
            $tbl.='<tr nobr="true">';
                $tbl.='<th width="30%"><strong>'.Mage::helper('sales')->__('Product').'</strong></th>';
                if ($orderHelper->printProductImages()) {
                    $tbl.='<th width="20%"></th>';
                } else {
                    $tbl.='<th width="20%"><strong>'.Mage::helper('sales')->__('SKU').'</strong></th>';
                }
                $tbl.='<th width="12.5%" align="center"><strong>'.Mage::helper('sales')->__('Price').'</strong></th>';
                $tbl.='<th width="12.5%" align="center"><strong>'.Mage::helper('sales')->__('QTY').'</strong></th>';
                $tbl.='<th width="12.5%" align="center"><strong>'.Mage::helper('sales')->__('Tax').'</strong></th>';
                $tbl.='<th width="12.5%" align="right"><strong>'.Mage::helper('sales')->__('Subtotal').'</strong></th>';
            $tbl.='</tr>';
            $tbl.='<tr><td width="100%" colspan="6"><hr/></td></tr>';
            $tbl.='</thead>';

            // Prepare Line Items
            $pdfItems = array();
            $pdfBundleItems = array();
            $pdf->prepareLineItems($orderHelper, $order, $pdfItems, $pdfBundleItems, $order);

            //Output Line Items
            $pdf->SetFont($orderHelper->getPdfFont(), '', $orderHelper->getPdfFontsize('small'));
            foreach ($pdfItems as $pdfItem){

                //we generallly don't want to display subitems of configurable products etc
                if($pdfItem['parentItemId']){
                        continue;
                }

                //Output line items
                if (($pdfItem['parentType'] != 'bundle' && $pdfItem['type'] != 'bundle') || ($pdfItem['type'] == 'bundle' && !isset($pdfBundleItems[$pdfItem['itemId']]))) {
                    $tbl.='<tr nobr="true">';
                        if ($pdfItem['image']) {
                            $tbl.='<td width="30%">'.$pdfItem['productDetails']['Name'].'<br/>'.Mage::helper('sales')->__('SKU').': '.$pdfItem['productDetails']['Sku'].'</td>';
                            $tbl.='<td align="right" width="20%"><img src="'.$pdfItem['image'].'" height="180"/></td>';
                        } else {
                            $tbl.='<td width="30%">'.$pdfItem['productDetails']['Name'].'</td>';
                            $tbl.='<td width="20%">'.$pdfItem['productDetails']['Sku'].'</td>';
                        }
                        $tbl.='<td width="12.5%" align="center">'.$pdf->OutputPrice($pdfItem['price'],$pdfItem['basePrice'],$displayBoth,$order).'</td>';
                        $tbl.='<td width="12.5%" align="center">'.$pdfItem['qty'].'</td>';
                        $tbl.='<td width="12.5%" align="center">'.$pdf->OutputPrice($pdfItem['taxAmount'],$pdfItem['baseTaxAmount'],$displayBoth,$order).'</td>';
                        $tbl.='<td width="12.5%" align="right">'.$pdf->OutputPrice($pdfItem['rowTotal'],$pdfItem['baseRowTotal'],$displayBoth,$order).'</td>';
                        if ($pdfItem['productDetails']['Options'] || $pdfItem['giftMessage']['message'] ) {
                            $tbl.='</tr>';
                            $tbl.='<tr nobr="true">';
                            $tbl.='<td colspan="6" width="100%">'.$pdfItem['productDetails']['Options'].$pdf->OutputGiftMessageItem($pdfItem['giftMessage']);
                            $tbl.='</td>';
                        }
                    $tbl.='</tr>';
                } else {    //Deal with Bundles
                    //check if the subitems of the bundle have separate prices
                    $currentParentId =$pdfItem['itemId'];
                    $subItemsSum = 0;
                    foreach ($pdfBundleItems[$currentParentId] as $bundleItem){
                        $subItemsSum += $bundleItem['price'];
                    }
                    //don't display bundle price if subitems have prices
                    if( $subItemsSum > 0){
                        $tbl.='<tr nobr="true">';
                            $tbl.='<td width="30%">'.$pdfItem['productDetails']['Name'].'</td>';
                            $tbl.='<td width="70%">'.$pdfItem['productDetails']['Sku'].'</td>';
                            if ($pdfItem['productDetails']['Options']) {
                                $tbl.='</tr>';
                                $tbl.='<tr nobr="true">';
                                $tbl.='<td colspan="6" width="100%">'.$pdfItem['productDetails']['Options'].'</td>';
                            }
                        $tbl.='</tr>';
                        //Display subitems
                        foreach ($pdfBundleItems[$currentParentId] as $bundleItem){
                            $tbl.='<tr nobr="true">';
                                $tbl.='<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;'.$bundleItem['productDetails']['Name'].'</td>';
                                $tbl.='<td width="20%">'.$bundleItem['productDetails']['Sku'].'</td>';
                                $tbl.='<td width="12.5%" align="center">'.$pdf->OutputPrice($bundleItem['price'],$bundleItem['basePrice'],$displayBoth,$order).'</td>';
                                $tbl.='<td width="12.5%" align="center">'.$bundleItem['qty'].'</td>';
                                $tbl.='<td width="12.5%" align="center">'.$pdf->OutputPrice($bundleItem['taxAmount'],$bundleItem['baseTaxAmount'],$displayBoth,$order).'</td>';
                                $tbl.='<td width="12.5%" align="right">'.$pdf->OutputPrice($bundleItem['rowTotal'],$bundleItem['baseRowTotal'],$displayBoth,$order).'</td>';
                                if ($bundleItem['productDetails']['Options']) {
                                    $tbl.='</tr>';
                                    $tbl.='<tr nobr="true">';
                                    $tbl.='<td colspan="6" width="100%">'.$bundleItem['productDetails']['Options'].'</td>';
                                }
                            $tbl.='</tr>';
                        }
                    }else {
                        $pdfItem['productDetails']['Subitems'] = '';
                        foreach ($pdfBundleItems[$currentParentId] as $bundleItem){
                            $pdfItem['productDetails']['Subitems'] .= "<br/>&nbsp;&nbsp;&nbsp;&nbsp;".$bundleItem['qty']." x " .$bundleItem['productDetails']['Name'];
                        }
                        $tbl.='<tr nobr="true">';
                            $tbl.='<td width="30%">'.$pdfItem['productDetails']['Name'].'</td>';
                            $tbl.='<td width="20%">'.$pdfItem['productDetails']['Sku'].'</td>';
                            $tbl.='<td width="12.5%" align="center">'.$pdf->OutputPrice($pdfItem['price'],$pdfItem['basePrice'],$displayBoth,$order).'</td>';
                            $tbl.='<td width="12.5%" align="center">'.$pdfItem['qty'].'</td>';
                            $tbl.='<td width="12.5%" align="center">'.$pdf->OutputPrice($pdfItem['taxAmount'],$pdfItem['baseTaxAmount'],$displayBoth,$order).'</td>';
                            $tbl.='<td width="12.5%" align="right">'.$pdf->OutputPrice($pdfItem['rowTotal'],$pdfItem['baseRowTotal'],$displayBoth,$order).'</td>';
                            if ($pdfItem['productDetails']['Options'] || $pdfItem['giftMessage']['message'] || $pdfItem['productDetails']['Subitems'] ) {
                                $tbl.='</tr>';
                                $tbl.='<tr nobr="true">';
                                $tbl.='<td colspan="6" width="100%">'.$pdfItem['productDetails']['Options'].$pdfItem['productDetails']['Subitems'].$pdf->OutputGiftMessageItem($pdfItem['giftMessage']) ;
                                $tbl.='</td>';
                            }
                        $tbl.='</tr>';
                    }
                }
                $params = $pdf->serializeTCPDFtagParameters(array('2'));
                $tbl.='<tcpdf method="Line2" params="'.$params.'"/>';
            }
            $tbl.='</table>';
            $pdf->writeHTML($tbl, true, false, false, false, '');
            $pdf->SetFont($orderHelper->getPdfFont(), '', $orderHelper->getPdfFontsize());

            //reset Margins in case there was a page break
            $pdf->setMargins($orderHelper->getPdfMargins('sides'),$orderHelper->getPdfMargins('top'));

            // Output totals
            $pdf->OutputTotals($orderHelper, $order,$order);

            // Output Order Gift Message
            $pdf->OutputGiftMessage($orderHelper, $order);

            // Output Comments
            $pdf->OutputComment($orderHelper,$order);
            $pdf->OutputCustomerOrderComment ($orderHelper, $order);

            //Custom Blurb underneath
            if($orderHelper->getPdfOrderCustom()){
                $pdf->Ln(2);
                $pdf->writeHTMLCell(0, 0, null, null,$orderHelper->getPdfOrderCustom(), null,1);
            }
            if($orderHelper->displayTaxSummary()) {
                $pdf->OutputTaxSummary($orderHelper,$order,$order);
            }
            if ($order->getStoreId()) {
                Mage::app()->getLocale()->revert();
            }
            $pdf->setPdfAnyOutput(true);
        }

        //output PDF document
        if(!$suppressOutput) {
            if($pdf->getPdfAnyOutput()) {
                // reset pointer to the last page
                $pdf->lastPage();
                $pdf->Output(preg_replace("/[^a-zA-Z]/","",$orderHelper->getPdfOrderTitle()).'_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', 'I');
                exit;
            }else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('There are no printable documents related to selected orders'));
            }
        }

        $this->_afterGetPdf();

        return $pdf;
    }



    public function addOrder($orderHelper, &$tbl,$orderId,$units,$pdf){


    }
}


/*
 *  Extend the TCPDF class to create custom Header
 */

class Fooman_PdfCustomiser_Order extends Fooman_PdfCustomiser_Helper_Pdf {


   /**
     * get main heading for order title
     * @return  string
     * @access public
     */
    public function getPdfOrderTitle(){
        return Mage::getStoreConfig('sales_pdf/order/ordertitle',$this->getStoreId());
    }

   /**
     * return which addresses to display
     * @return  string billing/shipping/both
     * @access public
     */
    public function getPdfOrderAddresses(){
        return Mage::getStoreConfig('sales_pdf/order/orderaddresses',$this->getStoreId());
    }

    /**
     * custom text for underneath order
     * @return  string
     * @access public
     */
    public function getPdfOrderCustom(){
        return Mage::getStoreConfig('sales_pdf/order/ordercustom',$this->getStoreId());
    }

}
