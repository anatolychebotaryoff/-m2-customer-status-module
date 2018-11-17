<?php

class USWF_ComparePage_Model_Resource_Compare_Widget_Product_Options extends Mage_Core_Model_Resource_Db_Abstract
{
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

    protected function _construct()
    {
        $this->_init('uswf_comparepage/compare_widget_product_options', 'compare_product_options_id');
    }

    public function save(Mage_Core_Model_Abstract $object) {
//        if ($object->getWidgetStore()->hasDataChanges() || $object->getWidgetDefault()->hasDataChanges()) {
//            $this->_resourceWidgetStore->save($object->getWidgetStore());
//            $this->_resourceWidgetDefault->save($object->getWidgetDefault());
//        } else {
            parent::save($object);
//        }
        return $this;
    }

    /**
     * Get widget by product id and store id
     *
     * @param $object
     * @param $productId
     * @param $storeId
     * @return $this
     */
    public function loadByProductId($object, $productId, $storeId)
    {
        if ($storeId == Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) {
            $selectDefault = $this->_getSelectByStoreIdDefault($productId, Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
            $data = $this->_getReadAdapter()->fetchRow($selectDefault);
        } else {
            $select = $this->_getSelectByStoreId($storeId);
            $data = $this->_getReadAdapter()->fetchRow($select);
            if (!$data){
                $selectDefault = $this->_getSelectByStoreIdDefault($productId, Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
                $data = $this->_getReadAdapter()->fetchRow($selectDefault);
            }
        }

        if ($data) {
            $object->setData($data);
        }
        $this->unserializeFields($object);
        $this->_afterLoad($object);
        return $this;
    }

    protected function _getSelectByStoreIdDefault($productId, $storeId) {
        $select = $this->_getReadAdapter()->select()
            ->from(array('cwpo' => $this->getMainTable()))
            ->where('cwpo.parent_product_id = ?', $productId)
            ->where('cwpo.website_id = ?', $storeId)
            ->limit(1);
        return $select;
    }

    protected function _getSelectByStoreId($storeId) {
        $select = $this->_getReadAdapter()->select()
            ->from(array('cw' => $this->getMainTable()),'')
            ->join(array('cws' => $this->getTable('uswf_comparepage/compare_widget_store')), '`cw`.parent_product_id = `cws`.parent_product_id','')
            ->join(array('cwd' => $this->getTable('uswf_comparepage/compare_widget_default')), '`cw`.parent_product_id = `cwd`.parent_product_id','')
            ->columns($this::$compareWidgetDefaultColumn)
            ->where('cw.website_id = ?', 0)
            ->where('cws.website_id  = ?', $storeId)
            ->where('cwd.website_id = cws.website_id')
            ->limit(1);
        return $select;
    }
}