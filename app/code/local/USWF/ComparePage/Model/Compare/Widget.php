<?php

class USWF_ComparePage_Model_Compare_Widget extends Mage_Core_Model_Abstract
{
    const LINK_TYPE_COMPARE   = 7;
    /** @var USWF_ComparePage_Model_Compare_Widget_Default */
    protected $_widgetDefault;
    /** @var USWF_ComparePage_Model_Compare_Widget_Store  */
    protected $_widgetStore;
    protected $_comparedProducts;

    protected function _construct()
    {
        $this->_init('uswf_comparepage/compare_widget');
    }

    public function save() {
        if (!is_null($this->_widgetStore) || !is_null($this->_widgetDefault)) {
            if ($this->_widgetStore->hasDataChanges() || $this->_widgetDefault->hasDataChanges()) {
                $this->setDataChanges(true);
            }
        }
        return parent::save();
    }

    /**
     * @param $identifier
     * @param $storeId
     * @return $this
     */
    public function loadByPageIdentifier($identifier, $storeId) {
        $this->getResource()->loadByPageIdentifier($this, $identifier, $storeId);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        return $this;
    }

    /**
     * @param $productId
     * @param $storeId
     * @return $this
     */
    public function loadByProductId($productId, $storeId) {
        $this->getResource()->loadByProductId($this, $productId, $storeId);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        return $this;
    }

    /**
     * Processing object after load data
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _afterLoad()
    {
        return parent::_afterLoad();
    }

    /**
     * Prepare data before saving
     *
     * @return Mage_Rule_Model_Abstract
     */
    protected function _beforeSave() {
        if (is_object($this->_widgetStore) && is_object($this->_widgetDefault)) {
            if ($this->_widgetDefault->getPageIdentifier()) {
                $pageIdentifier = $this->getPageIdentifier();
                $this->_widgetStore->setPageIdentifier($pageIdentifier);
            }
            $optionsActiveTabs = $this->_widgetStore->getOptionsActiveTabs();
            if (!is_string($optionsActiveTabs) && !empty($optionsActiveTabs)) {
                $this->_widgetStore->setOptionsActiveTabs(implode(',', $optionsActiveTabs));
            }
            $optionsAttributes = $this->_widgetStore->getOptionsAttributes();
            if (!is_string($optionsAttributes) && !empty($optionsAttributes)) {
                $this->_widgetStore->setOptionsAttributes(implode(',', $optionsAttributes));
            }
        }
        if ($this->hasOptionsActiveTabs()) {
            $optionsActiveTabs = $this->getOptionsActiveTabs();
            if (!is_string($optionsActiveTabs) && !empty($optionsActiveTabs)) {
                $this->setOptionsActiveTabs(implode(',', $optionsActiveTabs));
            }
        }
        if ($this->hasOptionsAttributes()) {
            $optionsAttributes = $this->getOptionsAttributes();
            if (!is_string($optionsAttributes) && !empty($optionsAttributes)) {
                $this->setOptionsAttributes(implode(',', $optionsAttributes));
            }
        }
        return parent::_beforeSave();
    }

    public function getWidgetDefault() {
        if (is_null($this->_widgetDefault)) {
            $this->_widgetDefault = Mage::getModel('uswf_comparepage/compare_widget_default');
            $this->_widgetDefault->load($this->getCompareWidgetIdDefault());
        }
        return $this->_widgetDefault;
    }

    public function getWidgetStore() {
        if (is_null($this->_widgetStore)) {
            $this->_widgetStore = Mage::getModel('uswf_comparepage/compare_widget_store');
            $this->_widgetStore->load($this->getCompareWidgetIdStore());
        }
        return $this->_widgetStore;
    }

    /**
     * Retrieve array of compared products
     *
     * @return array
     */
    public function getComparedProducts()
    {
        if (is_null($this->_comparedProducts)) {
            $products = array();
            foreach ($this->getComparedProductCollection() as $product) {
                $products[] = $product;
            }
            $this->_comparedProducts = $products;
        }
        return $this->_comparedProducts;
    }
    public function getComparedProductByPos($pos)
    {
        $result = null;
        foreach ($this->getComparedProducts() as $product)  {
            if ($product->getComparedPosition() == $pos) {
                $result = $product;
                break;
            }
        }
        return $result;
    }

    /**
     * Retrieve collection compared product
     *
     * @return Mage_Catalog_Model_Resource_Product_Link_Product_Collection
     */
    public function getComparedProductCollection()
    {
        $_product = Mage::getModel('catalog/product')
            ->setId($this->getParentProductId())
            ->setStoreId($this->getWebsiteId());
        $collection = $_product->getLinkInstance()
            ->setLinkTypeId(self::LINK_TYPE_COMPARE)
            ->getProductCollection()
            ->setIsStrongMode();
        $collection->setProduct($_product);
        if (!Mage::app()->getStore()->isAdmin()) {
            /** @var Zend_Db_Select $select */
            $select = $collection->getSelect();
            $adapter = $select->getAdapter();

            $whereCondition[] = $adapter->quoteInto('FIND_IN_SET((?),link_attribute_compared_website_id_varchar.value)', (int)Mage::app()->getStore()->getId());
            $whereCondition[] = $adapter->quoteInto('link_attribute_compared_website_id_varchar.value = ?', '*');
            $select->where(implode(' OR ', $whereCondition));
        }
        return $collection;
    }

}