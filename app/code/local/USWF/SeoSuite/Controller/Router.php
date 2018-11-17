<?php
/**
 * Router.php
 *
 * @category    USWF
 * @package     USWF_SeoSuite
 * @copyright
 * @author
 */
class USWF_SeoSuite_Controller_Router extends MageWorx_SeoFriendlyLN_Controller_Router
{
    public function initControllerRouters($observer)
    {
        $front  = $observer->getEvent()->getFront();
        //  Varien_Autoload::registerScope('catalog');
        $router = new USWF_SeoSuite_Controller_Router();
        $front->addRouter('seosuite', $router);
    }
    
    protected function _getUrlData() {
        $urlData = parent::_getUrlData();
        if (($priceKey = array_search('price', $urlData[1])) !== false) {
            if (isset($urlData[1][$priceKey + 1])) {
                $pFilters = explode(',' , $urlData[1][$priceKey + 1]);
                $tmpFilters = array();
                foreach ($pFilters as $item ){
                    list($priceFrom, $priceTo)  = explode('-' , $item);
                    $priceFrom   = floatval($priceFrom);
                    $priceTo = floatval($priceTo) - 0.01;
                    $tmpFilters[] = $priceFrom . '-' . $priceTo;
                }
                $tmpFilters = implode(',' , $tmpFilters);

                $urlData[1][$priceKey] = $urlData[1][$priceKey] . 
                    Mage::helper('seofriendlyln/config')->getAttributeValueDelimiter() . $tmpFilters;
                unset($urlData[1][$priceKey + 1]);
            }
        }
        return $urlData;
    }
}
