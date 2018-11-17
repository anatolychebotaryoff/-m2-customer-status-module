<?php

class Fooman_PdfCustomiser_Model_Shipment extends Fooman_PdfCustomiser_Model_Abstract
{
    /**
    * Creates PDF using the tcpdf library from array of shipments or orderIds
    * @param array $shipmentsGiven, $orderIds
    * @access public
    */
    public function getPdf($shipmentsGiven = array(),$orderIds = array(),$pdf = null, $suppressOutput = false, $csvOutput=false)
    {

        if(empty($pdf) && empty($shipmentsGiven) && empty($orderIds)){
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('There are no printable documents related to selected orders'));
                return false;
        }

        //we will be working through an array of orderIds later - fill it up if only invoices is given
        if(!empty($shipmentsGiven)){
            foreach ($shipmentsGiven as $shipmentGiven) {
                    $currentOrderId = $shipmentGiven->getOrder()->getId();
                    $orderIds[] = $currentOrderId;
                    $shipmentIds[$currentOrderId]=$shipmentGiven->getId();
            }
        }

        $this->_beforeGetPdf();

        $storeId = $order = Mage::getModel('sales/order')->load($orderIds[0])->getStoreId();

        //work with a new pdf or add to existing one
        if(empty($pdf)){
            $pdf = new Fooman_PdfCustomiser_Model_Mypdf('P', 'mm',  Mage::getStoreConfig('sales_pdf/all/allpagesize', $storeId), true, 'UTF-8', false);
        }
        $shipmentsCsv=array();
        foreach ($orderIds as $orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
            $printOrderAsPackingSlip =  Mage::getStoreConfig('sales_pdf/shipment/shipmentuseorder', $storeId);
            if(!empty($shipmentsGiven)) {
                $shipments = Mage::getResourceModel('sales/order_shipment_collection')
                    ->addAttributeToSelect('*')
                    ->setOrderFilter($orderId)
                    ->addAttributeToFilter('entity_id', $shipmentIds[$orderId])
                    ->load();
            }elseif ($printOrderAsPackingSlip) {
                $shipments = Mage::getResourceModel('sales/order_collection')->addAttributeToFilter('entity_id',$orderId)->load();
            }
            else {
                $shipments = Mage::getResourceModel('sales/order_shipment_collection')
                    ->addAttributeToSelect('*')
                    ->setOrderFilter($orderId)
                    ->load();
            }
            

            if ($shipments->getSize() > 0) {
                foreach ($shipments as $shipment) {
                    // create new Shipment helper
                    $shipmentHelper = new Fooman_PdfCustomiser_Shipment();
                    $shipment->load($shipment->getId());
                    $storeId = $shipment->getStoreId();
                    if ($shipment->getStoreId()) {
                        Mage::app()->getLocale()->emulate($shipment->getStoreId());
                    }

                    $shipmentHelper->setStoreId($storeId);
		    $pdf->setStoreId($storeId);
                    // set standard pdf info
                    $pdf->SetStandard($shipmentHelper);
                    if ($shipmentHelper->getPdfShipmentIntegratedLabels()){
                        $pdf->SetAutoPageBreak(true, 85);
                    }

                    // add a new page
                    $pdf->AddPage();
                    $pdf->printHeader($shipmentHelper, $shipmentHelper->getPdfShipmentTitle());

                    $shipmentNumbersEtc = Mage::helper('sales')->__('Packingslip #').': '. $shipment->getIncrementId()."\n";
                    if(Mage::getStoreConfig(self::XML_PATH_SALES_PDF_SHIPMENT_PUT_ORDER_ID,$storeId)){
                        $shipmentNumbersEtc .= Mage::helper('sales')->__('Order #').': ' . $order->getIncrementId()."\n";
                    }

                    $shipmentNumbersEtc .= Mage::helper('catalog')->__('Date').': '.Mage::helper('core')->formatDate($shipment->getCreatedAtStoreDate(), 'medium', false)."\n";
                    $pdf->MultiCell($pdf->getPageWidth() / 2 - $shipmentHelper->getPdfMargins('sides'), 0, $shipmentNumbersEtc, 0, 'L', 0, 0);
                    $pdf->MultiCell($pdf->getPageWidth() / 2 - $shipmentHelper->getPdfMargins('sides'), $pdf->getLastH(), $shipmentHelper->getPdfOwnerAddresss(), 0, 'L', 0, 1);
                    $pdf->Ln(5);

                    //add billing and shipping addresses
                    $pdf->OutputCustomerAddresses($shipmentHelper, $order, $shipmentHelper->getPdfShipmentAddresses());

                    // Output Shipping and Payment
                    $pdf->OutputPaymentAndShipping($shipmentHelper, $order, $shipment);
                    if($csvOutput && !$order->getIsVirtual() ){
                        $shipmentsCsv[]=array(  'Name'          => $order->getShippingAddress()->getFirstname()." ".$order->getShippingAddress()->getLastname(),
                                                'Adress'        => implode(' \n ',$order->getShippingAddress()->getStreet()),
                                                'Postadress'    => $order->getShippingAddress()->getPostcode().$order->getShippingAddress()->getCity(),
                                                'Land'          => $order->getShippingAddress()->getCountryModel()->getName()
                                            );
                    }

                    // Output heading for Items
                    $tbl ='<table width="100%" border="0" cellpadding="2" cellspacing="0">';
                    $tbl.='<thead>';
                    $tbl.='<tr nobr="true">';
                    $tbl.='<th width="69%"><strong>'.Mage::helper('sales')->__('Name').'</strong></th>';
                    $tbl.='<th width="20%"><strong>'.Mage::helper('sales')->__('SKU').'</strong></th>';
                    $tbl.='<th width="11%" align="center"><strong>'.Mage::helper('sales')->__('QTY').'</strong></th>';
                    $tbl.='</tr>';
                    $tbl.='<tr><td width="100%" colspan="3"><hr/></td></tr>';
                    $tbl.='</thead>';

                    // Prepare Line Items
                    $pdfItems = array();
                    $pdfBundleItems = array();
                    $pdf->prepareLineItems($shipmentHelper, $shipment, $pdfItems,$pdfBundleItems, $order);

                    //Output Line Items
                    $pdf->SetFont($shipmentHelper->getPdfFont(), '', $shipmentHelper->getPdfFontsize('small'));
                    foreach ($pdfItems as $pdfItem){

                        //we generallly don't want to display subitems of configurable products etc
                        if($pdfItem['parentItemId']){
                            continue;
                        }

                        //Output line items
                        if (($pdfItem['parentType'] != 'bundle' && $pdfItem['type'] != 'bundle') || ($pdfItem['type'] == 'bundle' && !isset($pdfBundleItems[$pdfItem['itemId']]))) {
                            // Output 1 line item
                            $tbl.='<tr nobr="true">';
                            $shipmentHelper->outputShippingLineItem($tbl,$shipmentHelper, Mage::getStoreConfig('sales_pdf/shipment/shipmentdisplay',$storeId), $pdf, $pdfItem);
                            $tbl.='<td width="20%">'.$pdfItem['productDetails']['Sku'].'</td>';
                            $tbl.='<td width="11%" align="center">'.$pdfItem['qty'].'</td>';
                            if ($pdfItem['productDetails']['Options'] || $pdfItem['giftMessage']['message'] ) {
                                $tbl.='</tr>';
                                $tbl.='<tr nobr="true">';
                                $tbl.='<td colspan="3" width="100%">'.$pdfItem['productDetails']['Options'].$pdf->OutputGiftMessageItem($pdfItem['giftMessage']);
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

                                // Output 1 bundle with subitems separately
                                $tbl.='<tr nobr="true">';
                                $shipmentHelper->outputShippingLineItem($tbl, $shipmentHelper, Mage::getStoreConfig('sales_pdf/shipment/shipmentdisplay',$storeId),$pdf,$pdfItem);
                                $tbl.='<td colspan="2" width="27.5%">'.$pdfItem['productDetails']['Sku'].'</td>';
                                if ($pdfItem['productDetails']['Options']) {
                                    $tbl.='</tr>';
                                    $tbl.='<tr nobr="true">';
                                    $tbl.='<td colspan="3" width="100%">'.$pdfItem['productDetails']['Options'].'</td>';
                                }
                                $tbl.='</tr>';
                                //Display subitems
                                foreach ($pdfBundleItems[$currentParentId] as $bundleItem){
                                    $tbl.='<tr nobr="true">';
                                    // Output 1 subitem
                                    $bundleItem['productDetails']['Name']='&nbsp;&nbsp;&nbsp;&nbsp;'.$bundleItem['productDetails']['Name'];
                                    $shipmentHelper->outputShippingLineItem($tbl,$shipmentHelper, Mage::getStoreConfig('sales_pdf/shipment/shipmentdisplay',$storeId),$pdf,$bundleItem,false);
                                    $tbl.='<td width="20%">'.$bundleItem['productDetails']['Sku'].'</td>';
                                    $tbl.='<td width="11%" align="center">'.$bundleItem['qty'].'</td>';
                                    if ($bundleItem['productDetails']['Options']) {
                                        $tbl.='</tr>';
                                        $tbl.='<tr nobr="true">';
                                        $tbl.='<td colspan="3" width="100%">'.$bundleItem['productDetails']['Options'].'</td>';
                                    }
                                    $tbl.='</tr>';
                                }
                            }else {
                                $pdfItem['productDetails']['Subitems'] = '';
                                foreach ($pdfBundleItems[$currentParentId] as $bundleItem){
                                    $pdfItem['productDetails']['Subitems'] .= "<br/>&nbsp;&nbsp;&nbsp;&nbsp;".$bundleItem['qty']." x " .$bundleItem['productDetails']['Name'];
                                }

                                // Output bundle with items as decription only
                                $tbl.='<tr nobr="true">';
                                $shipmentHelper->outputShippingLineItem($tbl,$shipmentHelper, Mage::getStoreConfig('sales_pdf/shipment/shipmentdisplay',$storeId),$pdf,$pdfItem);
                                $tbl.='<td width="20%">'.$pdfItem['productDetails']['Sku'].'</td>';
                                $tbl.='<td width="11%" align="center">'.$pdfItem['qty'].'</td>';
                                if ($pdfItem['productDetails']['Options'] || $pdfItem['giftMessage']['message'] || $pdfItem['productDetails']['Subitems'] ) {
                                    $tbl.='</tr>';
                                    $tbl.='<tr nobr="true">';
                                    $tbl.='<td colspan="3" width="100%">'.$pdfItem['productDetails']['Options'].$pdfItem['productDetails']['Subitems'].$pdf->OutputGiftMessageItem($pdfItem['giftMessage']) ;
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
                    $pdf->SetFont($shipmentHelper->getPdfFont(), '', $shipmentHelper->getPdfFontsize());

                    //reset Margins in case there was a page break
                    $pdf->setMargins($shipmentHelper->getPdfMargins('sides'),$shipmentHelper->getPdfMargins('top'));

                    // Output Order Gift Message
                    $pdf->OutputGiftMessage($shipmentHelper, $order);

                    // Output Comments
                    $pdf->OutputComment($shipmentHelper,$shipment);
                    $pdf->OutputCustomerOrderComment ($shipmentHelper, $order);

                    //Custom Blurb underneath                    
                    if($shipmentHelper->getPdfShipmentCustom()){
                        $pdf->Ln(2);
                        $pdf->writeHTMLCell(0, 0, null, null,$shipmentHelper->getPdfShipmentCustom(), null,1);
                    }

                    //print extra addresses for peel off labels
                    if ($shipmentHelper->getPdfShipmentIntegratedLabels()) {
                        $pdf->OutputCustomerAddresses($shipmentHelper,$order, $shipmentHelper->getPdfShipmentIntegratedLabels());
                    }

                    if ($shipment->getStoreId()) {
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
                if ($csvOutput){
                    $fileName ='shipments_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.csv';
                    $fp = fopen(Mage::getModel('core/config_options')->getExportDir().'/'.$fileName, 'w');

                    //create header line
                    fputcsv($fp,array_keys($shipmentsCsv[0]));

                    //output line items
                    foreach($shipmentsCsv as $csvLine) {
                        fputcsv($fp,$csvLine );
                    }
                    fclose($fp);

                    $fileNamePdf ='packingslip_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf';


                    ////add files to session message
                    Mage::getSingleton('adminhtml/session')->setCsvFilename($fileName);
                    Mage::getSingleton('adminhtml/session')->setPdfFilename($fileNamePdf);

                    //create pdf
                    $pdf->Output(Mage::getModel('core/config_options')->getExportDir().'/'.$fileNamePdf, 'F');
                }else{
                    $pdf->Output(preg_replace("/[^a-zA-Z]/","",$shipmentHelper->getPdfShipmentTitle()).'_'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', 'I');
                    exit;
                }
                
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

class Fooman_PdfCustomiser_Shipment extends Fooman_PdfCustomiser_Helper_Pdf {

   /**
     * get main heading for invoice title
     * @return  string
     * @access public
     */
    public function getPdfShipmentTitle(){
        return Mage::getStoreConfig('sales_pdf/shipment/shipmenttitle',$this->getStoreId());
    }

   /**
     * return which addresses to display
     * @return  string billing/shipping/both
     * @access public
     */
    public function getPdfShipmentAddresses(){
        return Mage::getStoreConfig('sales_pdf/shipment/shipmentaddresses',$this->getStoreId());
    }

    /**
     * custom text for underneath invoice
     * @return  string
     * @access public
     */
    public function getPdfShipmentCustom(){
        return Mage::getStoreConfig('sales_pdf/shipment/shipmentcustom',$this->getStoreId());
    }


    /**
     * are we using integrated labels - what to print?
     * @return  mixed bool / string
     * @access protected
     */

    public function getPdfShipmentIntegratedLabels(){
        return Mage::getStoreConfig('sales_pdf/shipment/shipmentintegratedlabels',$this->getStoreId());
    }

   /**
     * output display of product on packing slip - optional display of image or barcode
     * @return  lineHeight
     * @access public
     */
    public function outputShippingLineItem(&$tbl,$helper, $display,&$pdf,$pdfItem,$suppressBarcode = false){
        if($pdfItem['parentItemId']){
            $pdfItem['productDetails']['Name'] = "    ".$pdfItem['productDetails']['Name'];
        }
        switch($display) {
            case "image":
                if ($pdfItem['image']) {
                    $tbl.='<td width="39%">'.$pdfItem['productDetails']['Name'].'</td>';
                    $tbl.='<td align="center" width="30%"><img src="'.$pdfItem['image'].'" height="180"/></td>';
                } else {
                    $tbl.='<td colspan="2" width="69%">'.$pdfItem['productDetails']['Name'].'</td>';
                }

                break;
            case "barcode":
                $tbl.='<td valign="" width="39%">'.$pdfItem['productDetails']['Name'].'</td>';
                $lineHeight =  $pdf->getLastH();
                if(!$suppressBarcode){
                    // CODE 39 EXTENDED + CHECKSUM
                    $params = $pdf->serializeTCPDFtagParameters(array($pdfItem['productDetails']['Sku'], 'C39E+', '', '', '35', '13'));
                    $tbl.='<td height="16mm" width="30%"><tcpdf method="write1DBarcode" params="'.$params.'"/></td>';
                }else{
                    $tbl.='<td width="30%">&nbsp;</td>';
                }

                break;
            case "none":
                default:
                    $tbl.='<td width="69%">'.$pdfItem['productDetails']['Name'].'</td>';
                }
        }

    public function printProductImages(){
         return Mage::getStoreConfig('sales_pdf/shipment/shipmentdisplay')=='image';
    }
}
