<?php
class Fooman_PdfCustomiser_Helper_Pdf extends Mage_Core_Helper_Abstract
{
    public function __construct( $storeId=Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) {
        $this->setStoreId($storeId);
    }

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
     * store owner address
     * @access protected
     */
    protected $_PdfOwnerAddress;

   /**
     * store owner address
     * @return  string | false
     * @access public
     */
    public function getPdfOwnerAddresss(){
        $this->_PdfOwnerAddress = Mage::getStoreConfig('sales_pdf/all/allowneraddress',$this->getStoreId());
        if(empty($this->_PdfOwnerAddress)){
            return false;
        }
        return $this->_PdfOwnerAddress;
    }

   /**
     * get store flag to display base and order currency
     * @return  bool
     * @access public
     */
    public function getDisplayBoth(){
        return Mage::getStoreConfig('sales_pdf/all/displayboth',$this->getStoreId());
    }

    /**
     * font for pdf - courier, times, helvetica
     * not embedded
     * @return  string
     * @access public
     */
    public function getPdfFont(){
        return Mage::getStoreConfig('sales_pdf/all/allfont',$this->getStoreId());
    }

    /**
     * fontsize
     * @access protected
     */
    protected $_PdfFontsize;

    /**
     * getfontsize
     * @param (otpional) $size  normal | large | small
     * @return  int
     * @access public
     */
    public function getPdfFontsize($size='normal'){
        $this->_PdfFontsize = (int) Mage::getStoreConfig('sales_pdf/all/allfontsize',$this->getStoreId());
        switch ($size){
            case 'normal':
                return $this->_PdfFontsize;
                break;
            case 'large':
                return $this->_PdfFontsize*1.33;
                break;
            case 'small':
                return $this->_PdfFontsize*($this->_PdfFontsize < 12 ? 1 : 0.8);
                break;
            default:
                return $this->_PdfFontsize;
        }
    }


    /**
     * font for pdf - courier, times, helvetica
     * not embedded
     * @return  string
     * @access public
     */
    public function getPdfQtyAsInt(){
        return Mage::getStoreConfig('sales_pdf/all/allqtyasint',$this->getStoreId());
    }

    /**
     * path to print logo
     * @access protected
     */
    protected $_PdfLogo;

    /**
     * get path for print logo
     * @return string path information for logo
     * @access public
     */
    public function getPdfLogo(){
        if(Mage::getStoreConfig('sales_pdf/all/alllogo',$this->getStoreId())){
            $this->_PdfLogo = BP.DS.'media'.DS.'pdf-printouts'.DS. Mage::getStoreConfig('sales_pdf/all/alllogo',$this->getStoreId());
        }else{
             $this->_PdfLogo = false;
        }
        return $this->_PdfLogo;
    }

    /**
     * get logo placement auto / manual
     * @return string
     * @access public
     */
    public function getPdfLogoPlacement(){
        return Mage::getStoreConfig('sales_pdf/all/alllogoplacement',$this->getStoreId());
    }

    /**
     * get logo placement coordinates
     * @return array
     * @access public
     */
    public function getPdfLogoCoords(){
        $returnArray = array();
            $returnArray['w']= Mage::getStoreConfig('sales_pdf/all/alllogoheight',$this->getStoreId());
            $returnArray['h']= Mage::getStoreConfig('sales_pdf/all/alllogoheight',$this->getStoreId());
            $returnArray['x']= Mage::getStoreConfig('sales_pdf/all/alllogofromleft',$this->getStoreId());
            $returnArray['y']= Mage::getStoreConfig('sales_pdf/all/alllogofromtop',$this->getStoreId());
        return $returnArray;
    }

    /**
     * path to background image
     * @access protected
     */
    protected $_PdfBgImage;

    /**
     * get path for print logo
     * @return string path information for logo
     * @access public
     */
    public function getPdfBgImage(){
        if(Mage::getStoreConfig('sales_pdf/all/allbgimage',$this->getStoreId())){
            $this->_PdfBgImage = BP.DS.'media'.DS.'pdf-printouts'.DS. Mage::getStoreConfig('sales_pdf/all/allbgimage',$this->getStoreId());
        }else{
             $this->_PdfBgImage = false;
        }
        return $this->_PdfBgImage;
    }

    /**
     * Logo Dimensions
     * @access protected
     */
    protected $_PdfLogoDimensions = array();

    /**
     * get Logo Dimensions
     * @param  (optional) $which identify the dimension to return  all | w | h
     * @return array |  int | bool
     * @access public
     */
    public function getPdfLogoDimensions($which = 'all'){
        if(!$this->getPdfLogo()){
                return false;
        }

        list($width, $height, $type, $attr) = getimagesize($this->getPdfLogo());
        $this->_PdfLogoDimensions['width'] = $width/Fooman_PdfCustomiser_Model_Mypdf::FACTOR_PIXEL_PER_MM;
        $this->_PdfLogoDimensions['height'] = $height/Fooman_PdfCustomiser_Model_Mypdf::FACTOR_PIXEL_PER_MM;

        switch ($which){
            case 'w':
                return $this->_PdfLogoDimensions['width'];
                break;
            case 'h-scaled':
                //calculate if image will be scaled apply factor to height
                $maxWidth = ($this->getPageWidth()/2) - $this->getPdfMargins('sides');
                if($this->getPdfLogoDimensions('w') > $maxWidth ){
                    $scaleFactor = $maxWidth / $this->getPdfLogoDimensions('w');
                }else{
                    $scaleFactor = 1;
                }
                return $scaleFactor*$this->_PdfLogoDimensions['height'];
                break;
            case 'h':
                return $this->_PdfLogoDimensions['height'];
                break;
            case 'all':
            default:
                return $this->_PdfLogoDimensions;
        }
    }

    /**
     * Page Margins
     * @access protected
     */
    protected $_PdfMargins = array();

    /**
     * get Margins
     * @param  (optional) $which identify the dimension to return  all | top | bottom | sides
     * @return array |  int
     * @access public
     */
    public function getPdfMargins($which = 'all'){
        $this->_PdfMargins['top'] = Mage::getStoreConfig('sales_pdf/all/allmargintop',$this->getStoreId());
        $this->_PdfMargins['bottom'] = Mage::getStoreConfig('sales_pdf/all/allmarginbottom',$this->getStoreId());
        $this->_PdfMargins['sides'] = Mage::getStoreConfig('sales_pdf/all/allmarginsides',$this->getStoreId());

        switch ($which){
            case 'top':
                return $this->_PdfMargins['top'];
                break;
            case 'bottom':
                return $this->_PdfMargins['bottom'];
                break;
            case 'sides':
                return $this->_PdfMargins['sides'];
                break;
            case 'all':
            default:
                return $this->_PdfMargins;
        }
    }


    /**
     * get getPageWidth
     * @param  void
     * @return float
     * @access public
     */
    public function getPageWidth(){
        $pageSize = Mage::getStoreConfig('sales_pdf/all/allpagesize',$this->getStoreId());

        switch ($pageSize){
            case 'A4':
                return 21.000155556*10;
                break;
            case 'letter':
                return 21.59*10;
                break;
            default:
                return 21.000155556*10;
        }
    }

    /**
     * return if we want to print comments and statusses
     * @param  void
     * @return bool
     * @access public
     */
    public function getPrintComments(){
        return Mage::getStoreConfig('sales_pdf/all/allprintcomments',$this->getStoreId());
    }


    /**
     * Footers
     * @access protected
     */
    protected $_Footers = array();


    /**
     * return data for all blocks set for the footers
     *
     * @return array    $this->_Footers[0] contains how many blocks we need to set up
     */
    public function getFooters(){
        if(!empty($this->_Footers)){
            return $this->_Footers;
        }
        $this->_Footers[0]=0;
        for ($i=1;$i<5;$i++){
            $this->_Footers[$i] = Mage::getStoreConfig('sales_pdf/all/allfooter'.$i,$this->getStoreId());
            if(!empty($this->_Footers[$i])){
                $this->_Footers[0]=$i;
            }
        }
        return $this->_Footers;

    }
    /**
     * return data for all blocks set for the footers
     *
     * @return bool
     */
    public function hasFooter(){
        $footers = $this->getFooters();
        return $footers[0];

    }
    
    
    /**
     * return if weight should be displayed as part of the shipping information
     *
     * @return bool
     */
    public function displayWeight(){
        return Mage::getStoreConfigFlag('sales_pdf/all/alldisplayweight',$this->getStoreId());
    }

    /**
     * return flag if detailed tax breakdown should be displayed
     *
     * @return bool
     */
    public function displayTaxSummary(){
        return Mage::getStoreConfigFlag('sales_pdf/all/alltaxsummary',$this->getStoreId());
    }

    /**
     * print product images on orders, invoices and creditmemos
     * @return  bool
     * @access public
     */
    public function printProductImages(){
        return false;
    }


}