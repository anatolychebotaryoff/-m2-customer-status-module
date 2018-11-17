<?php

class USWF_ComparePage_Helper_Data extends Mage_Core_Helper_Abstract {
    public static $COMPARE_PRODUCTS_OPTIONS   = array(1,2,3,4);
    public static $compareWidgetDefaultColumn = array(
        'compare_widget_id' => 'cw.compare_widget_id',
        'compare_widget_id_store' => 'cws.compare_widget_id',
        'compare_widget_id_default' => 'cwd.compare_widget_id',
        'parent_product_id' => 'cw.parent_product_id',
        'website_id' => 'cws.website_id',
        'is_create_compare_page' => 'cw.is_create_compare_page',
        'page_is_active' => 'IF(cwd.page_is_active = 1, cw.page_is_active, cws.page_is_active)',
        'page_title' => 'IF(cwd.page_title = 1, cw.page_title, cws.page_title)',
        'page_identifier' => 'IF(cwd.page_identifier = 1, cw.page_identifier, cws.page_identifier)',
        'page_meta_robots' => 'IF(cwd.page_meta_robots = 1, cw.page_meta_robots, cws.page_meta_robots)',
        'page_exclude_from_sitemap' => 'IF(cwd.page_exclude_from_sitemap = 1, cw.page_exclude_from_sitemap, cws.page_exclude_from_sitemap)',
        'options_tier_price_output' => 'IF(cwd.options_tier_price_output = 1, cw.options_tier_price_output, cws.options_tier_price_output)',
        'options_active_tabs' => 'IF(cwd.options_active_tabs = 1, cw.options_active_tabs, cws.options_active_tabs)',
        'options_display_sku' => 'IF(cwd.options_display_sku = 1, cw.options_display_sku, cws.options_display_sku)',
        'options_attributes' => 'IF(cwd.options_attributes = 1, cw.options_attributes, cws.options_attributes)'
    );
    public static $compareWidgetDefaultColumnOption = array(
        'product_custom_name_option_',
        'review_id_option_',
        'review_text_option_',
        'static_block_id_quality_icons_option_',
        'title_bar_text_option_',
        'ribbon_pos_option_',
        'details_option_',
        'compatibility_option_'
    );
    public static $COMPARE_WIDGET_DEFAULT_COLUMN = array(
        'page_is_active' => 0,
        'page_title' => 0,
        'page_identifier' => 0,
        'page_meta_robots' => 0,
        'page_exclude_from_sitemap' => 0,
        'options_tier_price_output' => 0,
        'options_active_tabs' => 0,
        'options_display_sku' => 0,
        'options_attributes' => 0
    );

    public $_cacheYotpoReviewClient = array();
    public $_cacheYotpoReview = array();

    public function getIdsArr($element){
        return $element['product_id'];
    }

    public function changedCheckbox($checkbox){
        $product_ids=array_map(array($this,"getIdsArr"), $checkbox);
        return $product_ids;
    }

    public function getYotpoReview($productId, $store) {
        if (!isset($this->_cacheYotpoReviewClient[$productId][$store])) {
            $yotpoHelper = Mage::helper('yotpo/apiClient');
            $reviewsTotal = array();
            list($count, $total, $curPage) = array(0,0,0);
            do{
                $curPage++;
                $result = $yotpoHelper->createApiGet("v1/widget/".$yotpoHelper->getAppKey($store)."/products/".$productId."/reviews.json?page=".$curPage."&per_page=50&sort[]=date&direction[]=desc");
                if ($result['code'] == 200) {
                    $body = $result['body'];
                    $response = $body->response;
                    $curPage = $body->response->pagination->page;
                    $total = $body->response->pagination->total;
                    $reviews = $response->reviews;
                    $count += count($reviews);
                    $reviewsTotal = array_merge($reviewsTotal, array_map(function($el){return (array)$el;},$reviews));
                } else {
                    break;
                }
            }
            while($count < $total);
            $this->_cacheYotpoReviewClient[$productId][$store] = $reviewsTotal;
        }
        return $this->_cacheYotpoReviewClient[$productId][$store];
    }

    public function getYotpoReviewId($_product, $store) {
        if (is_null($_product)) {
            return array();
        }
        $productType = $_product->getTypeId();
        $productId = 0;
        switch ($productType) {
            case Mage_Catalog_Model_Product_Type::TYPE_SIMPLE :
                $productId = $_product->getId();
                break;
            case Mage_Catalog_Model_Product_Type::TYPE_GROUPED :
                $_associatedProducts = $_product->getTypeInstance(true)->getAssociatedProducts($_product);
                foreach ($_associatedProducts as $_associatedProduct) {
                    if ($_associatedProduct->getTypeId() == 'simple') {
                        $productId = $_associatedProduct->getId();
                        break;
                    }
                }
                break;
            case Mage_Catalog_Model_Product_Type::TYPE_BUNDLE :
                $options = $_product->getTypeInstance(true)->getOptionsIds($_product);
                if (sizeOf($options) > 0) {
                    $selections = $_product->getTypeInstance(true)->getSelectionsCollection($options, $_product);
                    foreach($selections as $selection) {
                        if ($selection->getTypeId() == 'simple') {
                            $productId = $selection->getId();
                            break;
                        }
                    }
                }
                break;
            default:
                $productId = 0;
                break;
        }

        if (!isset($this->_cacheYotpoReview[$_product->getId()][$store])) {
            $result = array();
            if (!$store) {
                return $result;
            }
            $reviewsTotal = $this->getYotpoReview($productId, $store);
            foreach ($reviewsTotal as $key =>$val) {
                $id = $val['id'];
                $content = substr($val['content'], 0, 50).'...';
                $result[$id] = $content;
            }
            $this->_cacheYotpoReview[$productId][$store] = $result;
        }
        return $this->_cacheYotpoReview[$productId][$store];
    }

    public function getYotpoReviewDetail($_product, $store, $reviewId) {
        $content = '';
        $reviewsTotal = $this->getYotpoReviewId($_product, $store);
        if (isset($reviewsTotal[$reviewId])) {
            $content = $reviewsTotal[$reviewId];
        }
        return $content;
    }

    public function checkUseDefaultProductId($productId, $column) {
        $select = $this->getSelectDefaultProductId($productId, $column);
        $data = Mage::getSingleton('core/resource')->getConnection('read')->fetchRow($select);
        if (isset($data) && array_key_exists('count', $data)){
            return (int)$data['count'];
        }
        return null;
    }

    protected function getSelectDefaultProductId($productId, $column) {
        $table = Mage::getSingleton('core/resource')->getTableName('uswf_comparepage/compare_widget_default');
        $select = Mage::getSingleton('core/resource')->getConnection('read')->select()
            ->from(array('cwd' => $table),'')
            ->where('cwd.parent_product_id = ?', $productId)
            ->where("cwd.{$column} = ?", 0)
            ->columns(array('count' => "COUNT({$column})"));

        return $select;
    }
}
