<?php

class USWF_ComparePage_Model_Resource_Compare_Widget extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * @var USWF_ComparePage_Model_Resource_Compare_Widget_Store
     */
    protected $_resourceWidgetStore;
    /**
     * @var USWF_ComparePage_Model_Resource_Compare_Widget_Default
     */
    protected $_resourceWidgetDefault;

    protected function _construct()
    {
        $this->_init('uswf_comparepage/compare_widget', 'compare_widget_id');
        $this->_resourceWidgetStore = Mage::getResourceSingleton('uswf_comparepage/compare_widget_store');
        $this->_resourceWidgetDefault = Mage::getResourceSingleton('uswf_comparepage/compare_widget_default');
    }

    public function save(Mage_Core_Model_Abstract $object) {
        if ($object->getWidgetStore()->hasDataChanges() || $object->getWidgetDefault()->hasDataChanges()) {
            $this->_resourceWidgetStore->save($object->getWidgetStore());
            $this->_resourceWidgetDefault->save($object->getWidgetDefault());
        } else {
            parent::save($object);
        }
        return $this;
    }

    /**
     * Perform actions after object delete
     *
     * @param Varien_Object $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $_parentId = $object->getParentProductId();
        $widgetStore = Mage::getModel('uswf_comparepage/compare_widget_store')->load($_parentId, 'parent_product_id');
        $widgetDefault = Mage::getModel('uswf_comparepage/compare_widget_default')->load($_parentId, 'parent_product_id');
        $this->_resourceWidgetStore->delete($widgetStore);
        $this->_resourceWidgetDefault->delete($widgetDefault);
        return parent::_beforeDelete($object);
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
            $select = $this->_getSelectByStoreId($productId, $storeId);
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

    /**
     * Get widget by page identifier id and store id
     *
     * @param $object
     * @param $identifier
     * @param $storeId
     * @return $this
     */
    public function loadByPageIdentifier($object, $identifier, $storeId)
    {
        if ($storeId == Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID) {
            $selectDefault = $this->_getSelectByIdentifierDefault($identifier, Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
            $data = $this->_getReadAdapter()->fetchRow($selectDefault);
        } else {
            $select = $this->_getSelectByIdentifier($identifier, $storeId);
            $data = $this->_getReadAdapter()->fetchRow($select);
            if (!$data){
                $selectDefault = $this->_getSelectByIdentifierDefault($identifier, Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
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
            ->from(array('cw' => $this->getMainTable()))
            ->where('cw.parent_product_id = ?', $productId)
            ->where('cw.website_id = ?', $storeId)
            ->limit(1);
        return $select;
    }

    protected function _getSelectByStoreId($productId, $storeId) {
        $result = USWF_ComparePage_Helper_Data::$compareWidgetDefaultColumn;
        $option = USWF_ComparePage_Helper_Data::$COMPARE_PRODUCTS_OPTIONS;
        foreach ($option as $pos) {
            foreach (USWF_ComparePage_Helper_Data::$compareWidgetDefaultColumnOption as $colName) {
                $result[$colName . $pos] = 'IF(cwd.'.$colName . $pos.' = 1, cw.'.$colName . $pos.', cws.'.$colName . $pos.')';
            }
        }
        $select = $this->_getReadAdapter()->select()
            ->from(array('cw' => $this->getMainTable()),'')
            ->join(array('cws' => $this->getTable('uswf_comparepage/compare_widget_store')), '`cw`.parent_product_id = `cws`.parent_product_id','')
            ->join(array('cwd' => $this->getTable('uswf_comparepage/compare_widget_default')), '`cw`.parent_product_id = `cwd`.parent_product_id','')
            ->columns($result)
            ->where('cw.parent_product_id = ?', $productId)
            ->where('cw.website_id = ?', 0)
            ->where('cws.website_id  = ?', $storeId)
            ->where('cwd.website_id = cws.website_id')
            ->limit(1);
        return $select;
    }

    protected function _getSelectByIdentifierDefault($identifier, $storeId) {
        $select = $this->_getReadAdapter()->select()
            ->from(array('cw' => $this->getMainTable()))
            ->where('cw.page_identifier = ?', $identifier)
            ->where('cw.website_id = ?', $storeId)
            ->limit(1);
        return $select;
    }

    protected function _getSelectByIdentifier($identifier, $storeId) {
        $result = USWF_ComparePage_Helper_Data::$compareWidgetDefaultColumn;
        $option = USWF_ComparePage_Helper_Data::$COMPARE_PRODUCTS_OPTIONS;
        foreach ($option as $pos) {
            foreach (USWF_ComparePage_Helper_Data::$compareWidgetDefaultColumnOption as $colName) {
                $result[$colName . $pos] = 'IF(cwd.'.$colName . $pos.' = 1, cw.'.$colName . $pos.', cws.'.$colName . $pos.')';
            }
        }
        $select = $this->_getReadAdapter()->select()
            ->from(array('cw' => $this->getMainTable()))
            ->join(array('cws' => $this->getTable('uswf_comparepage/compare_widget_store')), '`cw`.parent_product_id = `cws`.parent_product_id','')
            ->join(array('cwd' => $this->getTable('uswf_comparepage/compare_widget_default')), '`cw`.parent_product_id = `cwd`.parent_product_id','')
            ->columns($result)
            ->where('cws.page_identifier = ?', $identifier)
            ->where('cw.website_id = ?', 0)
            ->where('cws.website_id  = ?', $storeId)
            ->where('cwd.website_id = cws.website_id')
            ->limit(1);
        return $select;
    }

}