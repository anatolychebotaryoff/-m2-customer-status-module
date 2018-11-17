<?php

//load the tcpdf library
require_once(BP. DS .'lib'. DS .'tcpdf'. DS .'tcpdf.php');

/*
 *  Extend the TCPDF class
 */

class Fooman_PdfCustomiser_Model_Mypdf extends TCPDF {

    const FACTOR_PIXEL_PER_MM = 3;


    protected $_TaxTotal = array();
    protected $_TaxAmount = array();
    protected $_HiddenTaxAmount = 0;
    protected $_BaseHiddenTaxAmount = 0;
    public $_shippingTaxRate = '';

    /**
     * storeId
     * @access protected
     */
    protected $_storeId;

   /**
     * get storeId
     * @return  int
     * @access public
     */
    public function getStoreId(){
        return $this->_storeId;
    }

   /**
     * set storeId
     * @return  void
     * @access public
     */
    public function setStoreId($id){
        $this->_storeId = $id;
    }

    /**
     * keep track if we have output
     * @access protected
     */
    protected $_PdfAnyOutput=false;

   /**
     * do we have output?
     * @return  bool
     * @access public
     */
    public function getPdfAnyOutput(){
        return $this->_PdfAnyOutput;
    }

   /**
     * set _PdfAnyOutput
     * @return  void
     * @access public
     */
    public function setPdfAnyOutput($flag){
        $this->_PdfAnyOutput = $flag;
    }

    /**
     * retrieve line items
     * @param
     * @return void
     * @access public
     */
    public function prepareLineItems($helper,$printItem,&$pdfItems,&$pdfBundleItems,$order=null){
	$this->_TaxTotal = array();
	$this->_TaxAmount = array();
        $this->_HiddenTaxAmount = 0;
        if(Mage::getStoreConfig('tax/sales_display/price',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH
                || Mage::getStoreConfig('tax/sales_display/price',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX ) {
            $displayItemTaxInclusive = true;
        }else {
            $displayItemTaxInclusive = false;
        }
        if(Mage::getStoreConfigFlag('sales_pdf/all/allrowtotaltaxinclusive',$helper->getStoreId())) {
            $displaySubtotalTaxInclusive = true;
        }else {
            $displaySubtotalTaxInclusive = false;
        }
        foreach ($printItem->getAllItems() as $item){
            $pdfTemp = array();

            //check if we are printing an order
            if(!$item instanceof Mage_Sales_Model_Order_Item) {
                //we generallly don't want to display subitems of configurable products etc but we do for bundled
                $type = $item->getOrderItem()->getProductType();
                $itemId = $item->getOrderItem()->getItemId();
                $parentType = 'none';
                $parentItemId = $item->getOrderItem()->getParentItemId();

                if($parentItemId){
                    $parentItem = Mage::getModel('sales/order_item')->load($parentItemId);
                    $parentType = $parentItem->getProductType();
                }

                //Get item details
                $pdfTemp['itemId'] = $itemId;
                $pdfTemp['productId'] = $item->getOrderItem()->getProductId();
                $pdfTemp['type'] = $type;
                $pdfTemp['parentType'] = $parentType;
                $pdfTemp['parentItemId'] = $parentItemId;
                $pdfTemp['productDetails'] = $this->getItemNameAndSku($item);
                $pdfTemp['productOptions'] = $item->getOrderItem()->getProductOptions();
                $pdfTemp['giftMessage'] = $this->getGiftMessage($item->getOrderItem());
                if($displayItemTaxInclusive){
                    $pdfTemp['price'] = $item->getPrice()+ ($item->getTaxAmount() + $item->getHiddenTaxAmount()) / $item->getQty();
                }else{
                    $pdfTemp['price'] = $item->getPrice();
                }
                $pdfTemp['discountAmount'] = $item->getDiscountAmount();
                $pdfTemp['qty'] = $helper->getPdfQtyAsInt()?(int)$item->getQty():$item->getQty();
                $pdfTemp['taxAmount'] = $item->getTaxAmount()+$item->getHiddenTaxAmount();
                $pdfTemp['rowTotal'] = $item->getRowTotal();
                if ($displayItemTaxInclusive || $displaySubtotalTaxInclusive) {
                    $pdfTemp['rowTotal'] += $pdfTemp['taxAmount'];
                }
                //get item details - BASE
                if($displayItemTaxInclusive){
                    $pdfTemp['basePrice'] = $item->getBasePrice()+ ($item->getBaseTaxAmount() + $item->getBaseHiddenTaxAmount()) / $item->getQty();
                }else{
                    $pdfTemp['basePrice'] = $item->getBasePrice();
                }
                $pdfTemp['baseDiscountAmount'] = $item->getBaseDiscountAmount();
                $pdfTemp['baseTaxAmount'] = $item->getBaseTaxAmount()+$item->getBaseHiddenTaxAmount();
                $pdfTemp['baseRowTotal'] = $item->getBaseRowTotal();
                if ($displayItemTaxInclusive || $displaySubtotalTaxInclusive) {
                    $pdfTemp['baseRowTotal'] += $pdfTemp['baseTaxAmount'];
                }

		if ($item->getOrderItem()->getTaxPercent()){
			$taxPercent = sprintf("%01.4f",$item->getOrderItem()->getTaxPercent());
		} else {
			$taxPercent = '0.000';
		}
		$pdfTemp['taxPercent'] = sprintf("%01.2f",$taxPercent).'%';
		isset($this->_TaxTotal[$taxPercent])?$this->_TaxTotal[$taxPercent]+= $item->getBaseRowTotal()-$item->getBaseDiscountAmount():$this->_TaxTotal[$taxPercent]= $item->getBaseRowTotal()-$item->getBaseDiscountAmount();
		isset($this->_TaxAmount[$taxPercent])?$this->_TaxAmount[$taxPercent]+= $item->getBaseTaxAmount():$this->_TaxAmount[$taxPercent]= $item->getBaseTaxAmount();
                $this->_HiddenTaxAmount += $item->getHiddenTaxAmount();
                $this->_BaseHiddenTaxAmount += $item->getBaseHiddenTaxAmount();

                //prepare image
                $pdfTemp['image'] = false;
                if ($helper->printProductImages()) {
                    $productImage = Mage::getModel('catalog/product')->load($pdfTemp['productId'])->getImage();
                    if ($parentItemId && $productImage == "no_selection") {
                        $productImage = $parentItem->getImage();
                    }
                    $imagePath = 'media' . DS . 'catalog' . DS . 'product' . $productImage;
                    if (!$productImage || $productImage == "no_selection" || !file_exists($imagePath)) {
                        $pdfTemp['image'] = false;
                    } else {
                        $pdfTemp['image'] = $imagePath;
                    }
                }

                //collect bundle subitems separately
                if($parentType == 'bundle'){
                    //ugly workaround for bug in Magento on some bundles
                    //only needed for items and bundle sub products with no individual price
                    //for shipments
                    if( $item instanceof Mage_Sales_Model_Order_Shipment_Item){
                        if(!Mage::getModel('bundle/sales_order_pdf_items_shipment')->isShipmentSeparately($item)) {
                            $bundleSelection = unserialize($pdfTemp['productOptions']['bundle_selection_attributes']);
                            $pdfTemp['qty'] = $helper->getPdfQtyAsInt()?(int)$bundleSelection['qty']:$bundleSelection['qty'];
                        }
                    }
                    //invoices and creditmemos
                    else {
                        if(!Mage::getModel('bundle/sales_order_pdf_items_invoice')->isChildCalculated($item)) {
                            $bundleSelection = unserialize($pdfTemp['productOptions']['bundle_selection_attributes']);
                            $pdfTemp['qty'] = $helper->getPdfQtyAsInt()?(int)$bundleSelection['qty']:$bundleSelection['qty'];
                        }
                    }

                    $pdfBundleItems[$parentItemId][]=$pdfTemp;
                }else{
                    $pdfItems[$itemId]=$pdfTemp;
                }

            }else {
                //we generallly don't want to display subitems of configurable products etc but we do for bundled
                $type = $item->getProductType();
                $itemId = $item->getItemId();
                $parentType = 'none';
                $parentItemId = $item->getParentItemId();

                if($parentItemId){
                    $parentItem = Mage::getModel('sales/order_item')->load($parentItemId);
                    $parentType = $parentItem->getProductType();
                }

                //Get item Details
                $pdfTemp['itemId'] = $itemId;
                $pdfTemp['productId'] = $item->getProductId();
                $pdfTemp['type'] = $type;
                $pdfTemp['parentType'] = $parentType;
                $pdfTemp['parentItemId'] = $parentItemId;
                $pdfTemp['productDetails'] = $this->getItemNameAndSku($item);
                $pdfTemp['productOptions'] = $item->getProductOptions();
                $pdfTemp['giftMessage'] = $this->getGiftMessage($item);
                if($displayItemTaxInclusive){
                    $pdfTemp['price'] = $item->getPrice()+ ($item->getTaxAmount() + $item->getHiddenTaxAmount()) / $item->getQtyOrdered();                    
                }else{
                    $pdfTemp['price'] = $item->getPrice();
                }                
                $pdfTemp['discountAmount'] = $item->getDiscountAmount();
                $pdfTemp['qty'] = $helper->getPdfQtyAsInt()?(int)$item->getQtyOrdered():$item->getQtyOrdered();
                $pdfTemp['taxAmount'] = $item->getTaxAmount()+$item->getHiddenTaxAmount();
                $pdfTemp['rowTotal'] = $item->getRowTotal();
                if ($displayItemTaxInclusive || $displaySubtotalTaxInclusive) {
                    $pdfTemp['rowTotal'] += $pdfTemp['taxAmount'];
                }
                //get item details - BASE
                if($displayItemTaxInclusive){
                    $pdfTemp['basePrice'] = $item->getBasePrice()+ ($item->getBaseTaxAmount() + $item->getBaseHiddenTaxAmount()) / $item->getQtyOrdered();
                }else{
                    $pdfTemp['basePrice'] = $item->getBasePrice();
                }
                $pdfTemp['baseDiscountAmount'] = $item->getBaseDiscountAmount();
                $pdfTemp['baseTaxAmount'] = $item->getBaseTaxAmount()+$item->getBaseHiddenTaxAmount();
                $pdfTemp['baseRowTotal'] = $item->getBaseRowTotal();
                if ($displayItemTaxInclusive || $displaySubtotalTaxInclusive) {
                    $pdfTemp['baseRowTotal'] += $pdfTemp['baseTaxAmount'];
                }

		if ($item->getTaxPercent()){
			$taxPercent = sprintf("%01.4f",$item->getTaxPercent());
		} else {
			$taxPercent = '0.000';
		}
		$pdfTemp['taxPercent'] = sprintf("%01.2f",$taxPercent).'%';
		isset($this->_TaxTotal[$taxPercent])?$this->_TaxTotal[$taxPercent]+= $item->getBaseRowTotal()-$item->getBaseDiscountAmount():$this->_TaxTotal[$taxPercent]= $item->getBaseRowTotal()-$item->getBaseDiscountAmount();
		isset($this->_TaxAmount[$taxPercent])?$this->_TaxAmount[$taxPercent]+= $item->getBaseTaxAmount():$this->_TaxAmount[$taxPercent]= $item->getBaseTaxAmount();
                $this->_HiddenTaxAmount += $item->getHiddenTaxAmount();
                $this->_BaseHiddenTaxAmount += $item->getBaseHiddenTaxAmount();
                
                //prepare image
                $pdfTemp['image'] = false;
                if ($helper->printProductImages()) {
                    $productImage = Mage::getModel('catalog/product')->load($pdfTemp['productId'])->getImage();
                    if ($parentItemId && $productImage == "no_selection") {
                        $productImage = $parentItem->getImage();
                    }
                    $imagePath = 'media' . DS . 'catalog' . DS . 'product' . $productImage;
                    if (!$productImage || $productImage == "no_selection" || !file_exists($imagePath)) {
                        $pdfTemp['image'] = false;
                    } else {
                        $pdfTemp['image'] = $imagePath;
                    }
                }

                //collect bundle subitems separately
                if($parentType == 'bundle'){
                    if(!Mage::getModel('bundle/sales_order_pdf_items_invoice')->isChildCalculated($item)) {
                        $bundleSelection = unserialize($pdfTemp['productOptions']['bundle_selection_attributes']);
                        $pdfTemp['qty'] = $helper->getPdfQtyAsInt()?(int)$bundleSelection['qty']:$bundleSelection['qty'];
                    }
                    $pdfBundleItems[$parentItemId][]=$pdfTemp;
                }else{
                    $pdfItems[$itemId]=$pdfTemp;
                }
            }
            //Mage::log($pdfTemp);
        }
	$this->_shippingTaxRate=0;
        if ($helper->displayTaxSummary() && $order) {
            $filteredTaxrates = array();
            //need to filter out doubled up taxrates on edited/reordered items -> Magento bug
            foreach ($order->getFullTaxInfo() as $taxrate){
                foreach ($taxrate['rates'] as $rate){
                    $taxId= $rate['code'];
                    if(!isset($rate['title'])){
                        $rate['title']=$taxId;
                    }
                    $filteredTaxrates[$taxId]= array('id'=>$rate['code'],'percent'=>$rate['percent'],'amount'=>$taxrate['amount'],'baseAmount'=>$taxrate['base_amount'],'title'=>$rate['title']);
                }
            }

            //loop over tax amounts to find out which rate applies to shipping tax
            foreach ($filteredTaxrates as $taxId => $filteredTaxrate) {
                if (abs(($printItem->getBaseShippingAmount() * $filteredTaxrate['percent']) / 100) - $printItem->getBaseShippingTaxAmount() < 0.005) {
                    $this->_shippingTaxRate = sprintf("%01.2f", $filteredTaxrate['percent']);
                    $taxPercent = sprintf("%01.4f",$this->_shippingTaxRate);
                    isset($this->_TaxTotal[$taxPercent]) ? $this->_TaxTotal[$taxPercent]+= $printItem->getBaseShippingAmount() : $this->_TaxTotal[$taxPercent] = $printItem->getBaseShippingAmount();
                    isset($this->_TaxAmount[$taxPercent]) ? $this->_TaxAmount[$taxPercent]+= $printItem->getBaseShippingTaxAmount() : $this->_TaxAmount[$taxPercent] = $printItem->getBaseShippingTaxAmount();
                }
            }
        }
        if (abs ($this->_shippingTaxRate)<0.005 && $printItem->getBaseShippingAmount() > 0) {
            $zero = sprintf("%01.4f",0);
            isset($this->_TaxTotal[$zero]) ? $this->_TaxTotal[$zero]+= $printItem->getBaseShippingAmount() : $this->_TaxTotal[$zero] = $printItem->getBaseShippingAmount();
            isset($this->_TaxAmount[$zero]) ? $this->_TaxAmount[$zero]+= $printItem->getBaseShippingTaxAmount() : $this->_TaxAmount[$zero] = $printItem->getBaseShippingTaxAmount();
        }
        //Mage::log('$this->_shippingTaxRate'.$this->_shippingTaxRate);
        //Mage::log($this->_TaxAmount);
        //Mage::log($this->_TaxTotal);
    }

    /*
     * Page header
     * return float height of logo
     */

    public function printHeader($helper, $title, $incrementId = false) {

        if ($incrementId) {
            //$style = array('text' => true, 'fontsize'=>8);
            parent::write1DBarcode($incrementId, 'C39E+',$helper->getPdfMargins('sides'),5,50,5,'',$style);
            $this->SetXY($helper->getPdfMargins('sides'), $helper->getPdfMargins('top'));
        }
        // Place Logo
        if($helper->getPdfLogo()){
            if($helper->getPdfLogoPlacement()=='auto'){
                $maxLogoHeight = 25;
                //add title
                $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize('large'));
                $this->Cell($helper->getPageWidth() / 2 - $helper->getPdfMargins('sides'), 0, $title, 0, 2, 'L',null,null,1);
                $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());

                //Figure out if logo is too wide - half the page width minus margins
                $maxWidth = ($helper->getPageWidth()/2) - $helper->getPdfMargins('sides');
                if($helper->getPdfLogoDimensions('w') > $maxWidth ){
                    $logoWidth = $maxWidth;
                }else{
                    $logoWidth = $helper->getPdfLogoDimensions('w');
                }
                //centered
                //$this->Image($helper->getPdfLogo(), $this->getPageWidth()/2  + (($this->getPageWidth()/2 - $helper->getPdfMargins('sides') - $logoWidth)/2), $helper->getPdfMargins('top'), $logoWidth, $maxLogoHeight, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=true);
                $this->Image($helper->getPdfLogo(), $this->getPageWidth()/2, $helper->getPdfMargins('top'), $logoWidth, $maxLogoHeight, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=true);
                $this->SetY($this->getImageRBY()+3);
            }elseif($helper->getPdfLogoPlacement()=='no-scaling'){
                $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize('large'));
                $this->Cell($helper->getPageWidth() / 2 - $helper->getPdfMargins('sides'), 0, $title, 0, 2, 'L',null,null,1);
                $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
                $this->Image($helper->getPdfLogo(), $this->getPageWidth()/2, $helper->getPdfMargins('top'),$helper->getPdfLogoDimensions('w'),$helper->getPdfLogoDimensions('h'),$type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false);
                $this->SetY($this->getImageRBY()+3);
            }
            else{
                $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize('large'));
                $this->Cell(0, 0, $title, 0, 2, 'L',null,null,1);
                $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
                $coords = $helper->getPdfLogoCoords();
                $this->Image($helper->getPdfLogo(), $coords['x'], $coords['y'], $coords['w'], $coords['h'], $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=true);
                $this->SetY($this->getImageRBY()+3);
            }
        } else {
            $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize('large'));
            $this->Cell($helper->getPageWidth() / 2 - $helper->getPdfMargins('sides'), 0, $title, 0, 2, 'L',null,null,1);
            $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
            $this->Ln();
        }
       
    }

    /*
     *  set some standards for all pdf pages
     */
    public function SetStandard($helper){

        // set document information
        $this->SetCreator('Magento');

        //set margins
        $this->SetMargins($helper->getPdfMargins('sides'), $helper->getPdfMargins('top'));

        // set header and footer
        $this->setPrintFooter($helper->hasFooter());
        $this->setPrintHeader(true);

        $this->setHeaderMargin(0);
        $this->setFooterMargin($helper->getPdfMargins('bottom'));

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set auto page breaks
        $this->SetAutoPageBreak(true, $helper->getPdfMargins('bottom')+10);

        //set image scale factor 3 pixels = 1mm
        $this->setImageScale(self::FACTOR_PIXEL_PER_MM);

         //set image quality
        $this->setJPEGQuality(95);

        // set font
        $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());

        // set fillcolor black
        $this->SetFillColor(0);

        // see if we need to sign
        if(Mage::getStoreConfig('sales_pdf/all/allsign',$helper->getStoreId())){
            $certificate = Mage::helper('core')->decrypt(Mage::getStoreConfig('sales_pdf/all/allsigncertificate',$helper->getStoreId()));
            $certpassword = Mage::helper('core')->decrypt(Mage::getStoreConfig('sales_pdf/all/allsignpassword',$helper->getStoreId()));

            // set document signature
            $this->setSignature($certificate, $certificate, $certpassword, '', 2, null);
        }

        //set Right to Left Language
        if(Mage::app()->getLocale()->getLocaleCode() == 'he_IL'){
            $this->setRTL(true);
        }else{
            $this->setRTL(false);
        }

    }

    public function Header() {
        $helper = Mage::helper('pdfcustomiser/pdf');
	$helper->setStoreId($this->getStoreId());
        $imagePath = $helper->getPdfBgImage();
        if(file_exists($imagePath)){
            $this->SetAutoPageBreak(false, 0);
            $this->Image($imagePath, 0, 0, $this->getPageWidth(), $this->getPageHeight(), $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=true, $hidden=false);
            $this->SetAutoPageBreak(true,$helper->getPdfMargins('bottom'));
        }
        // Line break
        $this->Ln();
    }

    public function Footer() {
        $helper = Mage::helper('pdfcustomiser/pdf');
	$helper->setStoreId($this->getStoreId());
        $footers = $helper->getFooters();

        if($footers[0]>0){
            $marginBetween=5;
            $width = ($this->getPageWidth() - 2* $helper->getPdfMargins('sides') - ($footers[0]-1)*$marginBetween) / $footers[0];
            $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize('small'));
            foreach ($footers as $key =>$footer){
                //don't display first element
                if($key > 0){
                    if($key < $footers[0]){
                        //not last element
                        $this->MultiCell($width, $this->getLastH(), $footer, 0, 'L', 0, 0);
                        $this->SetX($this->GetX()+$marginBetween);
                    }elseif($key == $footers[0]) {
                        //last element
                        if(!empty($footer)){
                            $this->MultiCell($width, $this->getLastH(), $footer, 0, 'L', 0, 1);
    }
                    }
                }
            }
            $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize(''));
        }
    }

    public function Line2($space=1) {
        $this->SetY($this->GetY()+$space);
        $margins =$this->getMargins();
        $this->Line($margins['left'],$this->GetY(),$this->getPageWidth()-$margins['right'],$this->GetY());
        $this->SetY($this->GetY()+$space);

    }

    /*
     *  get product name and Sku, take into consideration configurable products and product options
     */
    public function getItemNameAndSku($item){
        $return = array();
        $return['Name'] = $item->getName();
        $return['Sku'] = $item->getSku();
        $return['Options'] = '';

        //check if we are printing an non-order = item has a method getOrderItem
        if(method_exists($item,'getOrderItem')){
            $item = $item->getOrderItem();
        }
        if ($options = $item->getProductOptions()) {
            if (isset($options['options'])) {
                foreach ($options['options'] as $option) {
                    $return['Options'] .= "<br/>&nbsp;&nbsp;" . $option['label'] . ": " . $option['value'];
                }
                $return['Options'] .= "<br/>";
            }
            if (isset($options['additional_options'])) {
                foreach ($options['additional_options'] as $additionalOption) {
                    $return['Options'] .= "<br/>&nbsp;&nbsp;" . $additionalOption['label'] . ": " . $additionalOption['value'];
                }
                $return['Options'] .= "<br/>";
            }
            if (isset($options['attributes_info'])) {
                foreach ($options['attributes_info'] as $attribute) {
                    $return['Options'] .= "<br/>&nbsp;&nbsp;" . $attribute['label'] . ": " . $attribute['value'];
                }
            }
            if($item->getProductType() == 'ugiftcert'){
                foreach (Mage::helper('ugiftcert')->getGiftcertOptionVars() as $attribute=>$label) {
                    if(isset($options['info_buyRequest'][$attribute]) && !empty($options['info_buyRequest'][$attribute])){
                        $return['Options'] .= "<br/>&nbsp;&nbsp;" . $label . ": " . Mage::helper('core')->htmlEscape($options['info_buyRequest'][$attribute]);
                    }
                }
            }
            if ($item->getProductOptionByCode('simple_sku')) {
                $return['Sku'] = $item->getProductOptionByCode('simple_sku');
            }
        }
        /*
        //Uncomment this block: delete /* and * / and enter your attribute code below
        $attributeCode ='attribute_code_from_Magento_backend';
        $productAttribute = Mage::getModel('catalog/product')->load($item->getProductId())->getData($attributeCode);
        if(!empty($productAttribute)){
            $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attributeCode);
            $return['Name'] .= "<br/><br/>".$attribute->getFrontendLabel().": ".$productAttribute;
        }
         */
        return $return;
    }

    /*
     *  output customer addresses
     */
    public function OutputCustomerAddresses($helper, $order, $which){

        if($order->getCustomerTaxvat()){
            $billingAddress = $this->_fixAddress($order->getBillingAddress()->format('pdf')."<br/>".Mage::helper('sales')->__('TAX/VAT Number').": ".$order->getCustomerTaxvat());
        }else{
            $billingAddress = $this->_fixAddress($order->getBillingAddress()->format('pdf'));
        }
	if(!$order->getIsVirtual()){
        	$shippingAddress = $this->_fixAddress($order->getShippingAddress()->format('pdf'));
	}else {
		$shippingAddress ='';
	}
        $shippingAddress = str_replace("|","<br/>",$shippingAddress);
        $billingAddress = str_replace("|","<br/>",$billingAddress);
        // show the email address underneath the billing address
        if(Mage::getStoreConfig('sales_pdf/all/alldisplayemail',$helper->getStoreId())){
            $billingAddress.="<br/>".$order->getCustomerEmail();
        }

        //which addresses are we supposed to show
        switch($which){
            case 'both':
                //swap order for Packing Slips - shipping on the left
                if($helper instanceof Fooman_PdfCustomiser_Shipment){
                    $this->SetX($helper->getPdfMargins('sides') + 5);
                    $this->Cell($this->getPageWidth() / 2 - $helper->getPdfMargins('sides'), 0, Mage::helper('sales')->__('SHIP TO:'), 0, 0, 'L');
                    if(!$order->getIsVirtual()){
                        $this->Cell(0, 0, Mage::helper('sales')->__('SOLD TO:'), 0, 1, 'L');
                    }else{
                        $this->Cell(0, $this->getLastH(), '', 0, 1, 'L');
                    }
                    $this->SetX($helper->getPdfMargins('sides') + 10);
                    $this->writeHTMLCell($this->getPageWidth() / 2 - $helper->getPdfMargins('sides'), 0, null, null,$shippingAddress,null,0);
                    if(!$order->getIsVirtual()){
                        $this->writeHTMLCell(0, $this->getLastH(), null, null, $billingAddress,null,1);
                    }else{
                        $this->Cell(0, $this->getLastH(), '', 0, 1, 'L');
                    }
                    $this->Ln(10);
                    break;
                }else{
                    $this->SetX($helper->getPdfMargins('sides') + 5);
                    $this->Cell($this->getPageWidth() / 2 - $helper->getPdfMargins('sides'), 0, Mage::helper('sales')->__('SOLD TO:'), 0, 0, 'L');
                    if(!$order->getIsVirtual()){
                        $this->Cell(0, 0, Mage::helper('sales')->__('SHIP TO:'), 0, 1, 'L');
                    }else{
                        $this->Cell(0, $this->getLastH(), '', 0, 1, 'L');
                    }
                    $this->SetX($helper->getPdfMargins('sides') + 10);
                    $this->writeHTMLCell($this->getPageWidth() / 2 - $helper->getPdfMargins('sides'), 0, null, null, $billingAddress,null,0);
                    if(!$order->getIsVirtual()){
                        $this->writeHTMLCell(0, $this->getLastH(), null, null, $shippingAddress,null,1);
                    }else{
                        $this->Cell(0, $this->getLastH(), '', 0, 1, 'L');
                    }
                    $this->Ln(10);
                    break;
            }

            case 'billing':
                $this->SetX($helper->getPdfMargins('sides') + 5);
                $this->writeHTMLCell(0, 0, null, null, $billingAddress,null,1);
                $this->Ln(10);
                break;
            case 'shipping':
                $this->SetX($helper->getPdfMargins('sides') + 5);
                if(!$order->getIsVirtual()){
                    $this->writeHTMLCell(0, 0, null, null, $shippingAddress,null,1);
                }
                $this->Ln(10);
                break;
            case 'singlebilling':
                $this->SetAutoPageBreak(false, 85);
                $this->SetXY(-180, -67);
                $this->writeHTMLCell(75, 0, null, null, $billingAddress,null,0);
                $this->SetAutoPageBreak(true, 85);
                break;
            case 'singleshipping':
                $this->SetAutoPageBreak(false, 85);
                $this->SetXY(-180, -67);
                if(!$order->getIsVirtual()){
                    $this->writeHTMLCell(75, $this->getLastH(), null, null, $shippingAddress,null,1);
                }
                $this->SetAutoPageBreak(true, 85);
                break;
            case 'double':
                $this->SetAutoPageBreak(false, 85);
                $this->SetXY(-180, -67);
                $this->writeHTMLCell(75, 0, null, null, $billingAddress,null,0);
                $this->SetXY(-95, -67);
                if(!$order->getIsVirtual()){
                    $this->writeHTMLCell(75, $this->getLastH(), null, null, $shippingAddress,null,1);
                }
                $this->SetAutoPageBreak(true, 85);
                break;
            case 'doublereturn':
                $this->SetAutoPageBreak(false);
                $this->MultiCell(75, 47, Mage::helper('pdfcustomiser')->__('Return Address').":\n\n".$helper->getPdfOwnerAddresss(), 0, 'L', 0, 0,30,230);
                if(!$order->getIsVirtual()){
                    $this->writeHTMLCell(75, 47, 115, 230, $shippingAddress, null, 0 );
                }
                $this->SetAutoPageBreak(true, 85);
                break;
            default:
                $this->SetX($helper->getPdfMargins('sides') + 5);
                $this->writeHTMLCell(0, 0, null, null, $billingAddress,null,1);
                $this->Ln(10);
        }        
    }


    /*
     *  output payment and shipping blocks
     */
     public function OutputPaymentAndShipping($helper, $order, $printItem) {

         //save current area - then set to admin
         $oldArea = Mage::getDesign()->getArea();
         Mage::getDesign()->setArea('adminhtml');
         //3-15-16 This module is the initial release. The functionality inside the try block does not work
         //in Magento Enterprise. Instead of creating our own exception and then catching/doing something else
         //Just do the thing up front that we know works.
         Mage::getDesign()->setArea($oldArea);
         $paymentInfo = Mage::helper('payment')->getInfoBlock($order->getPayment())
                     ->setIsSecureMode(true)
                     ->toHtml();

         Mage::getDesign()->setArea($oldArea);
         $paymentInfo = str_replace("{{pdf_row_separator}}","<br/>",$paymentInfo);

         $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize());
         $this->Cell(0.5*($this->getPageWidth() - 2*$helper->getPdfMargins('sides')), 0, Mage::helper('sales')->__('Payment Method'), 0, 0, 'L');
         if(!$order->getIsVirtual()) {
             $this->Cell(0, 0,Mage::helper('sales')->__('Shipping Method'), 0, 1, 'L');
         }else {
             $this->Cell(0, 0, '', 0, 1, 'L');
         }

         $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
         $this->writeHTMLCell(0.5*($this->getPageWidth() - 2*$helper->getPdfMargins('sides')), 0, null, null, $paymentInfo,0,0);

         if(!$order->getIsVirtual()) {
             $trackingInfo ="";
             $tracks = $order->getTracksCollection();
             if (count($tracks)) {
                 $trackingInfo ="\n";
                 foreach ($tracks as $track) {
                     if ($track->getNumber()) {
                         $trackingInfo .="\n".$track->getTitle().": ".$track->getNumber();
                     }
                 }
             }

             //display depending on if Total Weight should be displayed or not
             if($helper->displayWeight()) {
                 //calculate weight
                 $totalWeight = 0;
                 foreach ($printItem->getAllItems() as $item) {
                     if ($printItem instanceof Mage_Sales_Model_Order) {
                         $totalWeight +=$item->getQtyOrdered()*$item->getWeight();
                     }else {
                         $totalWeight +=$item->getQty()*$item->getOrderItem()->getWeight();
                     }
                 }
                 //Output Shipping description with tracking info and Total Weight
                 $this->MultiCell(0, $this->getLastH(), $order->getShippingDescription().$trackingInfo."\n\n".Mage::helper('pdfcustomiser')->__('Total Weight').': '.$totalWeight.' '.Mage::getStoreConfig('sales_pdf/all/allweightunit',$helper->getStoreId()), 0, 'L', 0, 1);
             }else {
                 //Output Shipping description with tracking info
                 $this->MultiCell(0, $this->getLastH(), $order->getShippingDescription().$trackingInfo, 0, 'L', 0, 1);
             }
         }else {
             $this->Cell(0, $this->getLastH(), '', 0, 1, 'L');
         }
         $this->Cell(0, 0, '', 0, 1, 'L');
     }

    /*
     *  output totals for invoice and creditmemo
     */
    public function OutputTotals($helper, $order,$item){

        $totals = array();

        //Prepare Subtotal
        $sortOrder = Mage::getStoreConfig('sales/totals_sort/subtotal',$helper->getStoreId());
        if(Mage::getStoreConfig('tax/sales_display/subtotal',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX){
            $totals[$sortOrder][] = array(
                    'label'=>Mage::helper('sales')->__('Order Subtotal').':',
                    'amount'=>$item->getSubtotal() + $item->getTaxAmount() + $this->_HiddenTaxAmount - $item->getFoomanSurchargeTaxAmount()- $item->getShippingTaxAmount() - $item->getCodTaxAmount(),
                    'baseAmount'=>$item->getBaseSubtotal() + $item->getBaseTaxAmount() + $this->_BaseHiddenTaxAmount - $item->getBaseFoomanSurchargeTaxAmount() - $item->getBaseShippingTaxAmount() - $item->getBaseCodTaxAmount()
            );
        }elseif(Mage::getStoreConfig('tax/sales_display/subtotal',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH){
            $totals[$sortOrder][] = array(
                    'label'=>Mage::helper('sales')->__('Order Subtotal').' '.Mage::helper('tax')->__('Incl. Tax').':',
                    'amount'=>$item->getSubtotal() + $item->getTaxAmount() + $this->_HiddenTaxAmount - $item->getFoomanSurchargeTaxAmount()- $item->getShippingTaxAmount() - $item->getCodTaxAmount(),
                    'baseAmount'=>$item->getBaseSubtotal() + $item->getBaseTaxAmount() + $this->_BaseHiddenTaxAmount - $item->getBaseFoomanSurchargeTaxAmount() - $item->getBaseShippingTaxAmount() - $item->getBaseCodTaxAmount()
            );
            $totals[$sortOrder][] = array(
                    'label'=>Mage::helper('sales')->__('Order Subtotal').' '.Mage::helper('tax')->__('Excl. Tax').':',
                    'amount'=>$item->getSubtotal(),
                    'baseAmount'=>$item->getBaseSubtotal()
            );
        }else{
            $totals[$sortOrder][] = array(
                    'label'=>Mage::helper('sales')->__('Order Subtotal').':',
                    'amount'=>$item->getSubtotal(),
                    'baseAmount'=>$item->getBaseSubtotal()
            );
        }

        //Prepare Discount
        if ((float)$item->getDiscountAmount()>0 || (float)$item->getDiscountAmount()<0){
            //Prepare positive or negative Discount to display with minus sign
            $sign = ((float)$item->getDiscountAmount()>0)?-1:1;
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/discount',$helper->getStoreId());

            if(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX){
                $totals[$sortOrder][] = array(
                        'label'=>Mage::helper('sales')->__('Discount').':',
                        'amount'=>$sign*$item->getDiscountAmount(),
                        'baseAmount'=>$sign*$item->getBaseDiscountAmount()
                );
            }elseif(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH){
                $totals[$sortOrder][] = array(
                        'label'=>Mage::helper('sales')->__('Discount').' '.Mage::helper('tax')->__('Incl. Tax').':',
                        'amount'=>$sign*$item->getDiscountAmount(),
                        'baseAmount'=>$sign*$item->getBaseDiscountAmount()
                );
                $totals[$sortOrder][] = array(
                        'label'=>Mage::helper('sales')->__('Discount').' '.Mage::helper('tax')->__('Excl. Tax').':',
                        'amount'=>$sign*$item->getDiscountAmount() + $this->_HiddenTaxAmount,
                        'baseAmount'=>$sign*$item->getBaseDiscountAmount()+ $this->_BaseHiddenTaxAmount
                );
            }else{
                $totals[$sortOrder][] = array(
                        'label'=>Mage::helper('sales')->__('Discount').':',
                        'amount'=>$sign*$item->getDiscountAmount() + $this->_HiddenTaxAmount,
                        'baseAmount'=>$sign*$item->getBaseDiscountAmount() + $this->_BaseHiddenTaxAmount
                );
            }
        }
        //Prepare Shipping
        if ((float)$item->getShippingAmount()){
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/shipping',$helper->getStoreId());
            if(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX){
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::helper('sales')->__('Shipping & Handling')).':',
                        'amount'=>$item->getShippingAmount() + $order->getShippingTaxAmount(),
                        'baseAmount'=>$item->getBaseShippingAmount() + $order->getBaseShippingTaxAmount()
                );
            }elseif(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH){
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::helper('sales')->__('Shipping & Handling')).' '.Mage::helper('tax')->__('Incl. Tax').':',
                        'amount'=>$item->getShippingAmount() + $order->getShippingTaxAmount(),
                        'baseAmount'=>$item->getBaseShippingAmount() + $order->getBaseShippingTaxAmount()
                );
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::helper('sales')->__('Shipping & Handling')).' '.Mage::helper('tax')->__('Excl. Tax').':',
                        'amount'=>$item->getShippingAmount(),
                        'baseAmount'=>$item->getBaseShippingAmount()
                );
            }else{
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::helper('sales')->__('Shipping & Handling')).':',
                        'amount'=>$item->getShippingAmount(),
                        'baseAmount'=>$item->getBaseShippingAmount()
                );
            }
        }

        //Prepare Cash on Delivery
        //use same settings as shipping (total does not provide separate settings)
        if ((float)$item->getCodFee()){
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/shipping',$helper->getStoreId());
            if(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX){
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::getStoreConfig('payment/cashondelivery/title',$helper->getStoreId())).':',
                        'amount'=>$item->getCodFee() + $order->getCodTaxAmount(),
                        'baseAmount'=>$item->getBaseCodFee() + $order->getBaseCodTaxAmount()
                );
            }elseif(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH){
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::getStoreConfig('payment/cashondelivery/title',$helper->getStoreId())).' '.Mage::helper('tax')->__('Incl. Tax').':',
                        'amount'=>$item->getCodFee() + $order->getCodTaxAmount(),
                        'baseAmount'=>$item->getBaseCodFee() + $order->getBaseCodTaxAmount()
                );
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::getStoreConfig('payment/cashondelivery/title',$helper->getStoreId())).' '.Mage::helper('tax')->__('Excl. Tax').':',
                        'amount'=>$item->getCodFee(),
                        'baseAmount'=>$item->getBaseCodFee()
                );
            }else{
                $totals[$sortOrder][] = array(
                        'label'=>str_replace(' &amp; ',' & ',Mage::getStoreConfig('payment/cashondelivery/title',$helper->getStoreId())).':',
                        'amount'=>$item->getCodFee(),
                        'baseAmount'=>$item->getBaseCodFee()
                );
            }
        }


        //Prepare Gift Certificate Amount (separate extension: ugiftcert)
        //use same settings as shipping (total does not provide separate settings)
       if ((float)$order->getGiftcertAmount()){
            $sign = ((float)$item->getGiftcertAmount()>0)?-1:1;
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/ugiftcert',$helper->getStoreId());
            $totals[$sortOrder][] = array(
                    'label'=>str_replace(' &amp; ',' & ',Mage::helper('ugiftcert')->__('Gift Certificates (%s)', $order->getGiftcertCode())).':',
                    'amount'=>$sign*$order->getGiftcertAmount(),
                    'baseAmount'=>$sign*$order->getBaseGiftcertAmount()
            );
        }



        //Prepare Tax
        if ((float)$item->getTaxAmount() > 0
                && !Mage::getStoreConfigFlag('tax/sales_display/grandtotal')
                || Mage::getStoreConfigFlag('sales_pdf/all/allonly1grandtotal',$helper->getStoreId())
                ){
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/tax',$helper->getStoreId());
            //Magento looses information of tax rates if an order is split into multiple invoices
            //so only display summary if both tax amounts equal
            if (Mage::getStoreConfig('tax/sales_display/full_summary',$helper->getStoreId())
                && $order->getTaxAmount() == $item ->getTaxAmount()
                    ){
                $filteredTaxrates = array();
                //need to filter out doubled up taxrates on edited/reordered items -> Magento bug
                foreach ($order->getFullTaxInfo() as $taxrate){
                    foreach ($taxrate['rates'] as $rate){
                        $taxId= $rate['code'];
                        if(!isset($rate['title'])){
                            $rate['title']=$taxId;
                        }
                        $filteredTaxrates[$taxId]= array('id'=>$rate['code'],'percent'=>$rate['percent'],'amount'=>$taxrate['amount'],'baseAmount'=>$taxrate['base_amount'],'title'=>$rate['title']);
                    }
                }
                foreach ($filteredTaxrates as $taxId => $filteredTaxrate){
                        $totals[$sortOrder][] = array(
                                'label'=>$filteredTaxrate['title'].':',
                                'amount'=>(float)$filteredTaxrate['amount'],
                                'baseAmount'=>(float)$filteredTaxrate['baseAmount']
                        );
                }
            }else{
                $totals[$sortOrder][] = array(
                        'label'=>Mage::helper('sales')->__('Tax').":",
                        'amount'=>(float)$item->getTaxAmount(),
                        'baseAmount'=>(float)$item->getBaseTaxAmount()
                );
            }
        }elseif(Mage::getStoreConfig('sales/totals_sort/zero_tax',$helper->getStoreId())){
                $totals[$sortOrder][] = array(
                        'label'=>Mage::helper('sales')->__('Tax').":",
                        'amount'=>(float)0,
                        'baseAmount'=>(float)0
                );
        }

        //Prepare Fooman Surcharge
        if ((float)$item->getFoomanSurchargeAmount()){
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/surcharge',$helper->getStoreId());
            if(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX){
                $totals[$sortOrder][] = array(
                        'label'=>$order->getFoomanSurchargeDescription().':',
                        'amount'=>$item->getFoomanSurchargeAmount() + $item->getFoomanSurchargeTaxAmount(),
                        'baseAmount'=>$item->getBaseFoomanSurchargeAmount() + $item->getBaseFoomanSurchargeTaxAmount()
                );
            }elseif(Mage::getStoreConfig('tax/sales_display/shipping',$helper->getStoreId()) == Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH){
                $totals[$sortOrder][] = array(
                        'label'=>$order->getFoomanSurchargeDescription().':',
                        'amount'=>$item->getFoomanSurchargeAmount() + $item->getFoomanSurchargeTaxAmount(),
                        'baseAmount'=>$item->getBaseFoomanSurchargeAmount() + $item->getBaseFoomanSurchargeTaxAmount()
                );
                $totals[$sortOrder][] = array(
                        'label'=>$order->getFoomanSurchargeDescription().':',
                        'amount'=>$item->getFoomanSurchargeAmount(),
                        'baseAmount'=>$item->getBaseFoomanSurchargeAmount()
                );
            }else{
                $totals[$sortOrder][] = array(
                        'label'=>$order->getFoomanSurchargeDescription().':',
                        'amount'=>$item->getFoomanSurchargeAmount(),
                        'baseAmount'=>$item->getBaseFoomanSurchargeAmount()
                );
            }
        }

        //Prepare Enterprise Gift Cards
        if ((float)$item->getGiftCardsAmount()){
            $sign = ((float)$item->getGiftCardsAmount()>0)?-1:1;
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/giftcardaccount',$helper->getStoreId());
            $totals[$sortOrder][] = array(
                    'label'=>str_replace(' &amp; ',' & ',Mage::helper('enterprise_giftcardaccount')->__('Gift Cards')).':',
                    'amount'=>$sign*$item->getGiftCardsAmount(),
                    'baseAmount'=>$sign*$item->getBaseGiftCardsAmount()
            );
        }

        //Prepare Enterprise Store Credit
        if ((float)$item->getCustomerBalanceAmount()){
            $sign = ((float)$item->getCustomerBalanceAmount()>0)?-1:1;
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/customerbalance',$helper->getStoreId());
            $totals[$sortOrder][] = array(
                    'label'=>str_replace(' &amp; ',' & ',Mage::helper('enterprise_giftcardaccount')->__('Store Credit')).':',
                    'amount'=>$sign*$item->getCustomerBalanceAmount(),
                    'baseAmount'=>$sign*$item->getBaseCustomerBalanceAmount()
            );
        }

        //Prepare Enterprise paid from reward points
        if ((float)$item->getRewardCurrencyAmount()){
            $sign = ((float)$item->getRewardCurrencyAmount()>0)?-1:1;
            $sortOrder = Mage::getStoreConfig('sales/totals_sort/giftcardaccount',$helper->getStoreId());
            $totals[$sortOrder][] = array(
                    'label'=>str_replace(' &amp; ',' & ',Mage::helper('enterprise_reward')->formatReward($item->getRewardPointsBalance())).':',
                    'amount'=>$sign*$item->getRewardCurrencyAmount(),
                    'baseAmount'=>$sign*$item->getBaseRewardCurrencyAmount()
            );
        }

        ksort($totals);
        $totalsSorted = array();
        foreach ($totals as $sortOrder){
            foreach($sortOrder as $total){
                $totalsSorted[]=$total;
            }
        }

        //Prepare AdjustmentPositive
        if ((float)$item->getAdjustmentPositive()){
            $totalsSorted[] = array(
                    'label'=>Mage::helper('sales')->__('Adjustment Refund').':',
                    'amount'=> $item->getAdjustmentPositive(),
                    'baseAmount'=> $item->getBaseAdjustmentPositive()
            );
        }
        //Prepare AdjustmentNegative
        if ((float)$item->getAdjustmentNegative()){
            $totalsSorted[] = array(
                    'label'=>Mage::helper('sales')->__('Adjustment Fee').':',
                    'amount'=> $item->getAdjustmentNegative(),
                    'baseAmount'=> $item->getBaseAdjustmentNegative()
            );
        }

        //Display both currencies if flag is set and order is in a different currency
        $displayBoth = $helper->getDisplayBoth() && $order->isCurrencyDifferent();

        $widthTextTotals = $displayBoth ? $this->getPageWidth() - 2*$helper->getPdfMargins('sides') - 4.7*$helper->getPdfFontsize():
                                          $this->getPageWidth() - 2*$helper->getPdfMargins('sides') - 2.7*$helper->getPdfFontsize();

        //Ouput the sorted totals
        foreach ($totalsSorted as $totalsSorted){
            $this->MultiCell($widthTextTotals, 0, $totalsSorted['label'], 0, 'R', 0, 0);
            $this->OutputTotalPrice($totalsSorted['amount'], $totalsSorted['baseAmount'],$displayBoth,$order);

        }

        //Total separated with line plus bolded
        $this->Ln(5);
        $this->Cell($this->getPageWidth()/2 - $helper->getPdfMargins('sides'), 5, '', 0, 0, 'C');
        $this->Cell(0, 5, '', 'T', 1, 'C');
        $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize());
        if(Mage::getStoreConfigFlag('sales_pdf/all/allonly1grandtotal',$helper->getStoreId())){
            $this->MultiCell($widthTextTotals, 0, Mage::helper('sales')->__('Grand Total').':', 0, 'R', 0, 0);
            $this->OutputTotalPrice($item->getGrandTotal(), $item->getBaseGrandTotal(),$displayBoth,$order);
        }elseif(Mage::getStoreConfig('tax/sales_display/grandtotal',$helper->getStoreId())){
            $this->MultiCell($widthTextTotals, 0, Mage::helper('sales')->__('Grand Total (Excl.Tax)').':', 0, 'R', 0, 0);
            $this->OutputTotalPrice($item->getGrandTotal()-$item->getTaxAmount(), $item->getBaseGrandTotal()-$item->getBaseTaxAmount(),$displayBoth,$order);
            $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
            if ((float)$item->getTaxAmount() > 0 ){
                $sortOrder = Mage::getStoreConfig('sales/totals_sort/tax',$helper->getStoreId());
                //Magento looses information of tax rates if an order is split into multiple invoices
                //so only display summary if both tax amounts equal
                if (Mage::getStoreConfig('tax/sales_display/full_summary',$helper->getStoreId())
                    && $order->getTaxAmount() == $item ->getTaxAmount()
                        ){
                    $filteredTaxrates = array();
                    //need to filter out doubled up taxrates on edited/reordered items -> Magento bug
                    foreach ($order->getFullTaxInfo() as $taxrate){
                        foreach ($taxrate['rates'] as $rate){
                            $taxId= $rate['code'];
                            if(!isset($rate['title'])){
                                $rate['title']=$taxId;
                            }
                            $filteredTaxrates[$taxId]= array('id'=>$rate['code'],'percent'=>$rate['percent'],'amount'=>$taxrate['amount'],'baseAmount'=>$taxrate['base_amount'],'title'=>$rate['title']);
                        }
                    }
                    foreach ($filteredTaxrates as $filteredTaxrate){
                        $this->MultiCell($widthTextTotals, 0, $filteredTaxrate['title'].':', 0, 'R', 0, 0);
                        $this->OutputTotalPrice((float)$filteredTaxrate['amount'], (float)$filteredTaxrate['baseAmount'],$displayBoth,$order);
                    }
                }else{
                        $this->MultiCell($widthTextTotals, 0, Mage::helper('sales')->__('Tax').":", 0, 'R', 0, 0);
                        $this->OutputTotalPrice((float)$item->getTaxAmount(), (float)$item->getBaseTaxAmount(),$displayBoth,$order);
                }
            }elseif(Mage::getStoreConfig('sales/totals_sort/zero_tax',$helper->getStoreId())){
                        $this->MultiCell($widthTextTotals, 0, Mage::helper('sales')->__('Tax').":", 0, 'R', 0, 0);
                        $this->OutputTotalPrice((float)0,(float)0,$displayBoth,$order);
            }
            $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize());
            $this->MultiCell($widthTextTotals, 0, Mage::helper('sales')->__('Grand Total (Incl.Tax)').':', 0, 'R', 0, 0);
            $this->OutputTotalPrice($item->getGrandTotal(), $item->getBaseGrandTotal(),$displayBoth,$order);
        }else{
            $this->MultiCell($widthTextTotals, 0, Mage::helper('sales')->__('Grand Total').':', 0, 'R', 0, 0);
            $this->OutputTotalPrice($item->getGrandTotal()-$item->getTaxAmount(), $item->getBaseGrandTotal()-$item->getBaseTaxAmount(),$displayBoth,$order);
        }
        $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());

        //Enterprise output refunded to store credit
        if ((float)$item->getCustomerBalanceTotalRefunded()){
            $this->MultiCell($widthTextTotals, 0, Mage::helper('enterprise_giftcardaccount')->__('Refunded to Store Credit').':', 0, 'R', 0, 0);
            $this->OutputTotalPrice($item->getCustomerBalanceTotalRefunded(), $item->getCustomerBalanceTotalRefunded(),$displayBoth,$order);
        }

    }

    /*
     *  output tax summary
     */
    public function OutputTaxSummary($helper, $order, $item) {
        $filteredTaxrates = array();
	$this->Ln();
        $zero = '0.0000';

        foreach ($order->getFullTaxInfo() as $taxrate) {
            foreach ($taxrate['rates'] as $rate) {
                $taxId= $rate['code'];
                $filteredTaxrates[$taxId]= array('id'=>$rate['code'],'percent'=>$rate['percent'],'amount'=>$taxrate['amount'],'baseAmount'=>$taxrate['base_amount']);
            }
        }

        if ($filteredTaxrates){
            $html='<table border="0" cellpadding="2" cellspacing="0">';
                $html.=' <tr>
                <td width="8%">'.Mage::helper('pdfcustomiser')->__('Tax Rate').'</td>
                <td align="right" width="20%">'.Mage::helper('pdfcustomiser')->__('Base Amount').'</td>
                <td align="right" width="20%">'.Mage::helper('pdfcustomiser')->__('Tax Amount').'</td>
                <td align="right" width="20%">'.Mage::helper('sales')->__('Subtotal').'</td>
            </tr>';

            foreach ($filteredTaxrates as $filteredTaxrate) {
                    if(isset($this->_TaxTotal[sprintf("%01.4f",$filteredTaxrate['percent'])])) {
                        $taxBase = $this->_TaxTotal[sprintf("%01.4f",$filteredTaxrate['percent'])];
                    } else {
                        $taxBase = 0;
                    }
                    if (isset($this->_TaxAmount[sprintf("%01.4f",$filteredTaxrate['percent'])])) {
                        $taxBaseAmount = $this->_TaxAmount[sprintf("%01.4f",$filteredTaxrate['percent'])];
                    } else {
                        $taxBaseAmount = 0;
                    }
                $html.=' <tr>
                <td align="right" width="8%">'.(float)$filteredTaxrate['percent']."%".'</td>
                <td align="right" width="20%">'.$order->formatPriceTxt($taxBase).'</td>
                <td align="right" width="20%">'.$order->formatPriceTxt($taxBaseAmount).'</td>
                <td align="right" width="20%">'.$order->formatPriceTxt($taxBaseAmount + $taxBase).'</td>
            </tr>';

            }
            if(isset($this->_TaxTotal[$zero]) && $this->_TaxTotal[$zero] > 0) {
              $html.=' <tr>
                <td align="right" width="8%">'.(float)$zero."%".'</td>
                <td align="right" width="20%">'.$order->formatPriceTxt($this->_TaxTotal[$zero]).'</td>
                <td align="right" width="20%">'.$order->formatPriceTxt($zero).'</td>
                <td align="right" width="20%">'.$order->formatPriceTxt($this->_TaxTotal[$zero]).'</td>
                </tr>';
            }
            $html.='</table>';
            $this->writeHTML($html, true, true, false, false, 'L');
        }
    }


    /*
     *  output Gift Message for Order
     */
    public function OutputGiftMessage($helper, $order){

       if ($order->getGiftMessageId() && $giftMessage = Mage::helper('giftmessage/message')->getGiftMessage($order->getGiftMessageId())){
            $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize());
            $this->Cell(0, 0, Mage::helper('giftmessage')->__('Gift Message'), 0, 1, 'L',null,null,1);
            $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());

            $message = "<b>".Mage::helper('giftmessage')->__('From:')."</b> ".htmlspecialchars($giftMessage->getSender())."<br/>";
            $message .= "<b>".Mage::helper('giftmessage')->__('To:')."</b> ".htmlspecialchars($giftMessage->getRecipient())."<br/>";
            $message .= "<b>".Mage::helper('giftmessage')->__('Message:')."</b> ".htmlspecialchars($giftMessage->getMessage())."<br/>";
            $this->writeHTMLCell(0, 0, null, null,$message, null,1);
        }
    }

    /*
     *  output Gift Message Item
     */
    public function OutputGiftMessageItem ($message)
    {
        $html = '';
        if ($message['message']){
            $html = '<br/><br/>';
            $html .= "<b>" . Mage::helper('giftmessage')->__('From:') . "</b> " . $message['from'] . "<br/>";
            $html .= "<b>" . Mage::helper('giftmessage')->__('To:') . "</b> " . $message['to'] . "<br/>";
            $html .= "<b>" . Mage::helper('giftmessage')->__('Message:') . "</b> " . $message['message'] . "<br/>";
        }
        return $html;
    }

    /*
     *  return Gift Message as Array
     */
    public function getGiftMessage($item){
       $returnArray=array();
       $returnArray['title']='';
       $returnArray['from']= '';
       $returnArray['to']='';
       $returnArray['message']='';
       if ($item->getGiftMessageId() && $giftMessage = Mage::helper('giftmessage/message')->getGiftMessage($item->getGiftMessageId())){

            $returnArray['title']=Mage::helper('giftmessage')->__('Gift Message');
            $returnArray['from']= Mage::helper('giftmessage')->__('From:')." ".htmlspecialchars($giftMessage->getSender());
            $returnArray['to']= Mage::helper('giftmessage')->__('To:')." ".htmlspecialchars($giftMessage->getRecipient());
            $returnArray['message']= Mage::helper('giftmessage')->__('Message:')." ".htmlspecialchars($giftMessage->getMessage());

        }
        return $returnArray;
    }

    /*
     *  output Comments on item - complete comment history
     *
     */
    public function OutputComment($helper, $item){
        if($helper->getPrintComments()){
            $comments ='';
            if ($item instanceof Mage_Sales_Model_Order){
                foreach ($item->getAllStatusHistory() as $history){
                    $comments .=Mage::helper('core')->formatDate($history->getCreatedAtStoreDate(), 'medium') ." | ".$history->getStatusLabel()."  ".$history->getComment()."\n";
                }
            }else{
                if ($item->getCommentsCollection()){
                    foreach($item->getCommentsCollection() as $comment){
                        $comments .=Mage::helper('core')->formatDate($comment->getCreatedAtStoreDate(), 'medium') ." | ".$comment->getComment()."\n";
                    }

                }
            }
            if(!empty($comments)){
                $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize());
                $this->Cell(0, 0, Mage::helper('sales')->__('Comments'), 0, 1, 'L',null,null,1);
                $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
                $this->MultiCell(0, 0, $comments, 0, 'L', 0, 1);
            }
        }
    }

    /*
     *  output customer order comments
     *  magento-community/Biebersdorf_CustomerOrderComment
     *  http://www.magentocommerce.com/magento-connect/TanRambun/extension/1036/customer-order-comment
     */

    public function OutputCustomerOrderComment ($helper, $order)
    {
        
        if ($order->getBiebersdorfCustomerordercomment()) {
            $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize());
            $this->Cell(0, 0, Mage::helper('biebersdorfcustomerordercomment')->__('Customer Order Comment'), 0, 1, 'L', null, null, 1);
            $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
            $this->MultiCell(0, 0, Mage::helper('biebersdorfcustomerordercomment')->htmlEscape($order->getBiebersdorfCustomerordercomment()), 0, 'L', 0, 1);
        }
        
        if ($order->getOnestepcheckoutCustomercomment()) {
            $this->SetFont($helper->getPdfFont(), 'B', $helper->getPdfFontsize());
            $this->Cell(0, 0, Mage::helper('onestepcheckout')->__('Customer Comments'), 0, 1, 'L', null, null, 1);
            $this->SetFont($helper->getPdfFont(), '', $helper->getPdfFontsize());
            $this->MultiCell(0, 0, Mage::helper('pdfcustomiser')->htmlEscape($order->getOnestepcheckoutCustomercomment()), 0, 'L', 0, 1);
        }
    }

    /*
     *  output prices for invoice and creditmemo
     */
    public function OutputPrice($price, $basePrice,$displayBoth,$order)
    {

        return $displayBoth ? (strip_tags($order->formatBasePrice($basePrice)).'<br/>'.strip_tags($order->formatPrice($price)))
                        : $order->formatPriceTxt($price);
    }

    /*
     *  output total prices for invoice and creditmemo
     */
    public function OutputTotalPrice($price, $basePrice,$displayBoth,$order)
    {
        if($displayBoth){
            $this->MultiCell(2.25*$this->getFontSizePt(), 0, strip_tags($order->formatBasePrice($basePrice)), 0, 'R', 0, 0);
        }
        $this->MultiCell(0, 0, $order->formatPriceTxt($price), 0, 'R', 0, 1);
    }

    public function write1DBarcode($code, $type, $x='', $y='', $w='', $h='', $xres=0.4, $style='', $align='T') {
        $style =array(
        'position' => 'S',
        'border' => false,
        'padding' => 1,
        'fgcolor' => array(0,0,0),
        'bgcolor' => false,
        'text' => true,
        'font' => 'helvetica',
        'fontsize' => 8,
        'stretchtext' => 4
        );
        parent::write1DBarcode($code,$type, $x, $y, $w, $h, $xres, $style, $align);
    }

    /**
     * replace any htmlspecialchars from input address except <br/>
     *
     * @param string $address
     * @return string
     */
    private function _fixAddress($address) {
        $address = htmlspecialchars($address);
        $pattern = array('&lt;br/&gt;','&lt;br /&gt;');
        $replacement = array('<br/>','<br/>');
        return str_replace($pattern, $replacement, $address);
    }
}
