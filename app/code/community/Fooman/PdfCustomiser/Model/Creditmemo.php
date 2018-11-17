<?php

class Fooman_PdfCustomiser_Model_Creditmemo extends Fooman_PdfCustomiser_Model_Abstract
{
    /**
    * Creates PDF using the tcpdf library from array of creditmemos or orderIds
    * @param array creditmemosGiven, $orderIds
    * @access public
    */
    public function getPdf($creditmemosGiven = array(),$orderIds = array(), $pdf = null, $suppressOutput = false, $outputFileName='')
    {

        if(empty($pdf) && empty($creditmemosGiven) && empty($orderIds)){
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('There are no printable documents related to selected orders'));
                return false;
        }

        //we will be working through an array of orderIds later - fill it up if only creditmemos is given
        if(!empty($creditmemosGiven)){
            foreach ($creditmemosGiven as $creditmemoGiven) {
                    $currentOrderId = $creditmemoGiven->getOrder()->getId();
                    $orderIds[] = $currentOrderId;
                    $creditmemoIds[$currentOrderId]=$creditmemoGiven->getId();
            }
        }

        $this->_beforeGetPdf();

        $storeId = $order = Mage::getModel('sales/order')->load($orderIds[0])->getStoreId();

        //work with a new pdf or add to existing one
        if(empty($pdf)){
            $pdf = new Fooman_PdfCustomiser_Model_Mypdf('P', 'mm',  Mage::getStoreConfig('sales_pdf/all/allpagesize', $storeId), true, 'UTF-8', false);
        }

        foreach ($orderIds as $orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
            if(!empty($creditmemosGiven)){
                $creditmemos = Mage::getResourceModel('sales/order_creditmemo_collection')
                    ->addAttributeToSelect('*')
                    ->setOrderFilter($orderId)
                    ->addAttributeToFilter('entity_id', $creditmemoIds[$orderId])
                    ->load();
            }else{
                $creditmemos = Mage::getResourceModel('sales/order_creditmemo_collection')
                    ->addAttributeToSelect('*')
                    ->setOrderFilter($orderId)
                    ->load();
            }
            if ($creditmemos->getSize() > 0) {
                foreach ($creditmemos as $creditmemo) {
                    // create new creditmemo helper
                    $creditmemoHelper = new Fooman_PdfCustomiser_Creditmemo();
                    $creditmemo->load($creditmemo->getId());
                    $storeId = $creditmemo->getStoreId();
                    if ($creditmemo->getStoreId()) {
                        Mage::app()->getLocale()->emulate($creditmemo->getStoreId());
                    }


                    $creditmemoHelper->setStoreId($storeId);
		    $pdf->setStoreId($storeId);
                    // set standard pdf info
                    $pdf->SetStandard($creditmemoHelper);

                    // add a new page
                    $pdf->AddPage();
                    $pdf->printHeader($creditmemoHelper,$creditmemoHelper->getPdfCreditmemoTitle());

                    $creditmemoNumbersEtc = Mage::helper('sales')->__('Credit Memo #').': '. $creditmemo->getIncrementId()."\n";
                    if(Mage::getStoreConfig(self::XML_PATH_SALES_PDF_CREDITMEMO_PUT_ORDER_ID,$storeId)){
                        $creditmemoNumbersEtc .= Mage::helper('sales')->__('Order #').': ' . $order->getIncrementId()."\n";
                    }

                    $creditmemoNumbersEtc .= Mage::helper('catalog')->__('Date').': '.Mage::helper('core')->formatDate($creditmemo->getCreatedAtStoreDate(), 'medium', false)."\n";
                    $pdf->MultiCell($pdf->getPageWidth() / 2 - $creditmemoHelper->getPdfMargins('sides'), 0, $creditmemoNumbersEtc, 0, 'L', 0, 0);
                    $pdf->MultiCell($pdf->getPageWidth() / 2 - $creditmemoHelper->getPdfMargins('sides'), $pdf->getLastH(), $creditmemoHelper->getPdfOwnerAddresss(), 0, 'L', 0, 1);
                    $pdf->Ln(5);

                    //add billing and shipping addresses
                    $pdf->OutputCustomerAddresses($creditmemoHelper, $order, $creditmemoHelper->getPdfCreditmemoAddresses());

                    //Display both currencies if flag is set and order is in a different currency
                    $displayBoth = $creditmemoHelper->getDisplayBoth() && $order->isCurrencyDifferent();

                    // Output Shipping and Payment
                    $pdf->OutputPaymentAndShipping($creditmemoHelper, $order, $creditmemo);

                    // Output heading for Items
                    $tbl ='<table width="100%" border="0" cellpadding="2" cellspacing="0">';
                    $tbl.='<thead>';
                    $tbl.='<tr nobr="true">';
                        $tbl.='<th width="30%"><strong>'.Mage::helper('sales')->__('Product').'</strong></th>';
                        if ($creditmemoHelper->printProductImages()) {
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
                    $pdf->prepareLineItems($creditmemoHelper, $creditmemo, $pdfItems, $pdfBundleItems, $order);

                    //Output Line Items
                    $pdf->SetFont($creditmemoHelper->getPdfFont(), '', $creditmemoHelper->getPdfFontsize('small'));
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
                                if ($pdfItem['productDetails']['Options']) {
                                    $tbl.='</tr>';
                                    $tbl.='<tr nobr="true">';
                                    $tbl.='<td colspan="6" width="100%">'.$pdfItem['productDetails']['Options'];
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
                                    $tbl.='<td colspan="5" width="70%">'.$pdfItem['productDetails']['Sku'].'</td>';
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
                                    if ($pdfItem['productDetails']['Options'] || $pdfItem['productDetails']['Subitems'] ) {
                                        $tbl.='</tr>';
                                        $tbl.='<tr nobr="true">';
                                        $tbl.='<td colspan="6" width="100%">'.$pdfItem['productDetails']['Options'].$pdfItem['productDetails']['Subitems'] ;
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
                    $pdf->SetFont($creditmemoHelper->getPdfFont(), '', $creditmemoHelper->getPdfFontsize());

                    //reset Margins in case there was a page break
                     $pdf->setMargins($creditmemoHelper->getPdfMargins('sides'),$creditmemoHelper->getPdfMargins('top'));

                    // Output totals
                    $pdf->OutputTotals($creditmemoHelper, $order,$creditmemo);

                    // Output Comments
                    $pdf->OutputComment($creditmemoHelper,$creditmemo);
                    $pdf->OutputCustomerOrderComment ($creditmemoHelper, $order);

                    //Custom Blurb underneath
                    if($creditmemoHelper->getPdfCreditmemoCustom()) {
                        $pdf->Ln(2);
                        $pdf->writeHTMLCell(0, 0, null, null,$creditmemoHelper->getPdfCreditmemoCustom(), null,1);
                    }
                    if($creditmemoHelper->displayTaxSummary()) {
                        $pdf->OutputTaxSummary($creditmemoHelper,$order,$creditmemo);
                    }
                    if ($creditmemo->getStoreId()) {
                        Mage::app()->getLocale()->revert();
                    }
                    $pdf->setPdfAnyOutput(true);
                 }
            }
        }

        //output PDF document
        if(!$suppressOutput) {
            if($pdf->getPdfAnyOutput()) {
                if(empty($outputFileName)){
                    $outputFileName=preg_replace("/[^a-zA-Z]/","",$creditmemoHelper->getPdfCreditmemoTitle());
                }
                // reset pointer to the last page
                $pdf->lastPage();
                $pdf->Output($outputFileName.'_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', 'I');
                exit;
            }else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('There are no printable documents related to selected orders'));
            }
        }

        $this->_afterGetPdf();
        return $pdf;
    }

}

/*
 *  Extend the TCPDF class to create custom Header
 */

class Fooman_PdfCustomiser_Creditmemo extends Fooman_PdfCustomiser_Helper_Pdf{

   /**
     * get main heading for invoice title
     * @return  string
     * @access public
     */
    public function getPdfCreditmemoTitle(){
        return Mage::getStoreConfig('sales_pdf/creditmemo/creditmemotitle',$this->getStoreId());
    }

   /**
     * return which addresses to display
     * @return  string billing/shipping/both
     * @access public
     */
    public function getPdfCreditmemoAddresses(){
        return Mage::getStoreConfig('sales_pdf/creditmemo/creditmemoaddresses',$this->getStoreId());
    }

    /**
     * custom text for underneath invoice
     * @return string
     * @access protected
     */

    public function getPdfCreditmemoCustom(){
        return Mage::getStoreConfig('sales_pdf/creditmemo/creditmemocustom',$this->getStoreId());
    }

}
