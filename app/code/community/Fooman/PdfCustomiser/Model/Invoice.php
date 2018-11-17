<?php

class Fooman_PdfCustomiser_Model_Invoice extends Fooman_PdfCustomiser_Model_Abstract
{
    /**
    * Creates PDF using the tcpdf library from array of invoices or orderIds
    * @param array $invoices, $orderIds
    * @access public
    */
    public function getPdf($invoicesGiven = array(),$orderIds = array(), $pdf = null, $suppressOutput = false)
    {

        if(empty($pdf) && empty($invoicesGiven) && empty($orderIds)){
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('There are no printable documents related to selected orders'));
                return false;
        }

        //we will be working through an array of orderIds later - fill it up if only invoices is given
        if(!empty($invoicesGiven)){
            foreach ($invoicesGiven as $invoiceGiven) {
                    $currentOrderId = $invoiceGiven->getOrder()->getId();
                    $orderIds[] = $currentOrderId;
                    $invoiceIds[$currentOrderId]=$invoiceGiven->getId();
            }
        }

        $this->_beforeGetPdf();

        //need to get the store id from the first order to intialise pdf
        $storeId = $order = Mage::getModel('sales/order')->load($orderIds[0])->getStoreId();

        //work with a new pdf or add to existing one
        if(empty($pdf)){
            $pdf = new Fooman_PdfCustomiser_Model_Mypdf('P', 'mm',  Mage::getStoreConfig('sales_pdf/all/allpagesize',$storeId), true, 'UTF-8', false);
        }

        foreach ($orderIds as $orderId) {
            //load data
			
            $order = Mage::getModel('sales/order')->load($orderId);
            if(!empty($invoicesGiven)){
                $invoices = Mage::getResourceModel('sales/order_invoice_collection')
                    ->addAttributeToSelect('*')
                    ->setOrderFilter($orderId)
                    ->addAttributeToFilter('entity_id', $invoiceIds[$orderId])
                    ->load();
            }else{
                $invoices = Mage::getResourceModel('sales/order_invoice_collection')
                    ->addAttributeToSelect('*')
                    ->setOrderFilter($orderId)
                    ->load();
            }

            //loop over invoices
            if ($invoices->getSize() > 0) {
                foreach ($invoices as $invoice) {
                    // create new invoice helper
                    $invoiceHelper = new Fooman_PdfCustomiser_Invoice();
                    $invoice->load($invoice->getId());
                    $storeId = $invoice->getStoreId();
                    if ($invoice->getStoreId()) {
                        Mage::app()->getLocale()->emulate($invoice->getStoreId());
                    }

                    $invoiceHelper->setStoreId($storeId);
		    $pdf->setStoreId($storeId);
                    // set standard pdf info
                    $pdf->SetStandard($invoiceHelper);
                    if ($invoiceHelper->getPdfInvoiceIntegratedLabels()){
                        $pdf->SetAutoPageBreak(true, 85);
                    }

                    // add a new page
                    $pdf->AddPage();
                    $pdf->printHeader($invoiceHelper, $invoiceHelper->getPdfInvoiceTitle());

                    $invoiceNumbersEtc = Mage::helper('sales')->__('Invoice #').': '. $invoice->getIncrementId()."\n";
                    if(Mage::getStoreConfig(self::XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID,$storeId)){
                        $invoiceNumbersEtc .= Mage::helper('sales')->__('Order #').': '. $order->getIncrementId()."\n";
                    }
                    if($invoiceHelper->getPdfInvoiceTaxNumber()){
                        $invoiceNumbersEtc .= $invoiceHelper->getPdfInvoiceTaxNumber()."\n";
                    }
                    $invoiceNumbersEtc .= Mage::helper('catalog')->__('Date').': '. Mage::helper('core')->formatDate($invoice->getCreatedAtStoreDate(), 'medium', false)."\n";
                    if (Mage::getStoreConfig('sales_pdf/invoice/invoicedeliverydate',$storeId)){
                        $invoiceNumbersEtc .= Mage::helper('pdfcustomiser')->__('Delivery Date').': '.Mage::helper('core')->formatDate($invoice->getCreatedAtStoreDate(), 'medium', false)."\n";
                    }
                    //$group = Mage::getModel('customer/group')->load($order->getCustomerGroupId())->getCustomerGroupCode();

                    $pdf->MultiCell($pdf->getPageWidth() / 2 - $invoiceHelper->getPdfMargins('sides'), 0, $invoiceNumbersEtc, 0, 'L', 0, 0);
                    $pdf->MultiCell($pdf->getPageWidth() / 2 - $invoiceHelper->getPdfMargins('sides'), $pdf->getLastH(), $invoiceHelper->getPdfOwnerAddresss(), 0, 'L', 0, 1);
                    $pdf->Ln(5);

                    //add billing and shipping addresses
                    $pdf->OutputCustomerAddresses($invoiceHelper,$order, $invoiceHelper->getPdfInvoiceAddresses());

                    //Display both currencies if flag is set and order is in a different currency
                    $displayBoth = $invoiceHelper->getDisplayBoth() && $order->isCurrencyDifferent();

                    // Output Shipping and Payment
                    $pdf->OutputPaymentAndShipping($invoiceHelper,$order, $invoice);

                    // Output heading for Items
                    $tbl ='<table width="100%" border="0" cellpadding="2" cellspacing="0">';
                    $tbl.='<thead>';
                    $tbl.='<tr nobr="true">';
                        $tbl.='<th width="30%"><strong>'.Mage::helper('sales')->__('Product').'</strong></th>';
                        if ($invoiceHelper->printProductImages()) {
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
                    $pdf->prepareLineItems($invoiceHelper, $invoice, $pdfItems, $pdfBundleItems, $order);
                    
                    //Output Line Items
                    $pdf->SetFont($invoiceHelper->getPdfFont(), '', $invoiceHelper->getPdfFontsize('small'));
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

                    $pdf->SetFont($invoiceHelper->getPdfFont(), '', $invoiceHelper->getPdfFontsize());

                    //reset Margins in case there was a page break
                    $pdf->setMargins($invoiceHelper->getPdfMargins('sides'),$invoiceHelper->getPdfMargins('top'));

                    // Output totals
                    $pdf->OutputTotals($invoiceHelper,$order,$invoice);

                    // Output Comments
                    $pdf->OutputComment($invoiceHelper,$invoice);
                    $pdf->OutputCustomerOrderComment ($invoiceHelper, $order);

                    //Custom Blurb underneath
                    if($invoiceHelper->getPdfInvoiceCustom()){
                        $pdf->Ln(2);
                        $pdf->writeHTMLCell(0, 0, null, null,$invoiceHelper->getPdfInvoiceCustom(), null,1);
                    }

                    if($invoiceHelper->displayTaxSummary()) {
                        $pdf->OutputTaxSummary($invoiceHelper,$order,$invoice);
                    }
                    /*
                    //Uncomment this block: delete /* and * / to add legal text for German invoices. EuVat Extension erforderlich
                    switch($order->getCustomerGroupId()){
                        case 2:
                            $pdf->Cell(0, 0, 'steuerfrei nach § 4 Nr. 1 b UStG', 0, 2, 'L',null,null,1);
                            break;
                        case 1:
                            $pdf->Cell(0, 0, 'umsatzsteuerfreie Ausfuhrlieferung', 0, 2, 'L',null,null,1);
                            break;
                    }
                     */

                    //print extra addresses for peel off labels
                    if ($invoiceHelper->getPdfInvoiceIntegratedLabels()) {
                        $pdf->OutputCustomerAddresses($invoiceHelper,$order, $invoiceHelper->getPdfInvoiceIntegratedLabels());
                    }

                    if ($invoice->getStoreId()) {
                        Mage::app()->getLocale()->revert();
                    }
                    $pdf->setPdfAnyOutput(true);
                }
            }
        }

        //output PDF document
        if(!$suppressOutput) {
            if($pdf->getPdfAnyOutput()) {
                // reset pointer to the last page
                $pdf->lastPage();
                $pdf->Output(preg_replace("/[^a-zA-Z]/","",$invoiceHelper->getPdfInvoiceTitle()).'_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', 'I');
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

class Fooman_PdfCustomiser_Invoice extends Fooman_PdfCustomiser_Helper_Pdf{

   /**
     * get main heading for invoice title ie TAX INVOICE
     * @return  string
     * @access public
     */
    public function getPdfInvoiceTitle(){
        return Mage::getStoreConfig('sales_pdf/invoice/invoicetitle',$this->getStoreId());
    }

   /**
     * get tax number
     * @return  string
     * @access public
     */
    public function getPdfInvoiceTaxNumber(){
        return Mage::getStoreConfig('sales_pdf/invoice/invoicetaxnumber',$this->getStoreId());
    }

   /**
     * return which addresses to display
     * @return  string billing/shipping/both
     * @access public
     */
    public function getPdfInvoiceAddresses(){
        return Mage::getStoreConfig('sales_pdf/invoice/invoiceaddresses',$this->getStoreId());
    }

    /**
     * custom text for underneath invoice
     * @return  string
     * @access protected
     */

    public function getPdfInvoiceCustom(){
        return Mage::getStoreConfig('sales_pdf/invoice/invoicecustom',$this->getStoreId());
    }

    /**
     * are we using integrated labels - what to print?
     * @return  mixed bool / string
     * @access protected
     */

    public function getPdfInvoiceIntegratedLabels(){
        return Mage::getStoreConfig('sales_pdf/invoice/invoiceintegratedlabels',$this->getStoreId());
    }
}
