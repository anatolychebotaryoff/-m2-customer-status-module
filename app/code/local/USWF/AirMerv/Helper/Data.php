<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_CMS
 * @copyright
 * @author
 */
class USWF_AirMerv_Helper_Data extends Mage_Core_Helper_Abstract
{


    public function getJsonCollectionData($productCollection)
    {

        $pageName = Mage::getSingleton('cms/page')->getName();


        $data = array();
        $data['@context']    = 'http://schema.org';
        $data['@type']       = 'WebPage';
        $data['url']         = Mage::helper('core/url')->getCurrentUrl();
        $data['mainEntity']                    = array();
        $data['mainEntity']['@context']        = 'http://schema.org';
        $data['mainEntity']['@type']           = 'ItemList';
        $data['mainEntity']['name']            = $pageName;
        $data['mainEntity']['url']             = Mage::helper('core/url')->getCurrentUrl();
        $data['mainEntity']['numberOfItems']   = count($productCollection->getItems());
        $data['mainEntity']['itemListElement'] = array();

        $position = 1;
        foreach ($productCollection as $product) {
            $data['mainEntity']['itemListElement'][] = $this->_getProductData($product, $position);
            $position++;
        }

        $catJson = '<script type="application/ld+json">' . json_encode($data) . '</script>';

        return $catJson;
    }

    protected function _getProductData($product, $position)
    {

        $wrap = array();
        $wrap['@type']    = "ListItem";
        $wrap['position'] = $position;

        $data = array();
        $data['@type']    = "Product";
        $data['url']      = Mage::helper('mageworx_seomarkup')->getStoreBaseUrl() . $product->getUrlPath();
        $data['name']     = $product->getName();
        $data['image']    = $product->getImageUrl();

        if (Mage::helper('mageworx_seomarkup/config')->isUseOfferForCategoryProducts()) {
            $offerData        = $this->_getOfferData($product);
            if (!empty($offerData['price'])) {
                $data['offers'] = $offerData;
            }
        }
        $wrap['item'] = $data;
        return $wrap;
    }

    protected function _getOfferData($product)
    {
        $data   = array();
        $prices = Mage::helper('mageworx_seomarkup/price')->getPricesByProductType($product->getTypeId(), $product);

        if (is_array($prices) && count($prices)) {
            $data['price'] = $prices[0];
        }

        $data['priceCurrency'] = Mage::app()->getStore()->getCurrentCurrencyCode();

        $availability = Mage::helper('mageworx_seomarkup')->getAvailability($product);
        if ($availability) {
            $data['availability'] = $availability;
        }

        $condition = Mage::helper('mageworx_seomarkup')->getConditionValue($product);
        if ($condition) {
            $data['itemCondition'] = $condition;
        }

        return $data;
    }

}
