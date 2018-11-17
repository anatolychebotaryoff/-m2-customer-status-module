<?php
/**
 * Catalog rules resource model
 */
class USWF_GiftPurchase_Model_Resource_Rule extends Mage_Rule_Model_Resource_Abstract
{
    /**
     * Store number of seconds in a day
     */
    const SECONDS_IN_DAY = 86400;

    /**
     * Number of products in range for insert
     */
    const RANGE_PRODUCT_STEP = 100000;

    /**
     * Store associated with rule entities information map
     *
     * @var array
     */
    protected $_associatedEntitiesMap = array(
        'website' => array(
            'associations_table' => 'uswf_giftpurchase/website',
            'rule_id_field'      => 'rule_id',
            'entity_id_field'    => 'website_id'
        ),
        'customer_group' => array(
            'associations_table' => 'uswf_giftpurchase/customer_group',
            'rule_id_field'      => 'rule_id',
            'entity_id_field'    => 'customer_group_id'
        )
    );

    /**
     * Factory instance
     *
     * @var Mage_Core_Model_Factory
     */
    protected $_factory;

    /**
     * App instance
     *
     * @var Mage_Core_Model_App
     */
    protected $_app;

    /**
     * Constructor with parameters
     * Array of arguments with keys
     *  - 'factory' Mage_Core_Model_Factory
     *
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        $this->_factory = !empty($args['factory']) ? $args['factory'] : Mage::getSingleton('core/factory');
        $this->_app     = !empty($args['app']) ? $args['app'] : Mage::app();

        parent::__construct();
    }

    /**
     * Initialize main table and table id field
     */
    protected function _construct()
    {
        $this->_init('uswf_giftpurchase/rule', 'rule_id');
    }

    /**
     * Add customer group ids and website ids to rule data after load
     *
     * @param Mage_Core_Model_Abstract $object
     *
     * @return Mage_CatalogRule_Model_Resource_Rule
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $object->setData('customer_group_ids', (array)$this->getCustomerGroupIds($object->getId()));
        $object->setData('website_ids', (array)$this->getWebsiteIds($object->getId()));

        return parent::_afterLoad($object);
    }

    /**
     * Bind catalog rule to customer group(s) and website(s).
     * Update products which are matched for rule.
     *
     * @param Mage_Core_Model_Abstract $object
     *
     * @return Mage_CatalogRule_Model_Resource_Rule
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->hasWebsiteIds()) {
            $websiteIds = $object->getWebsiteIds();
            if (!is_array($websiteIds)) {
                $websiteIds = explode(',', (string)$websiteIds);
            }
            $this->bindRuleToEntity($object->getId(), $websiteIds, 'website');
        }

        if ($object->hasCustomerGroupIds()) {
            $customerGroupIds = $object->getCustomerGroupIds();
            if (!is_array($customerGroupIds)) {
                $customerGroupIds = explode(',', (string)$customerGroupIds);
            }
            $this->bindRuleToEntity($object->getId(), $customerGroupIds, 'customer_group');
        }

        parent::_afterSave($object);
        return $this;
    }

    /**
     * Deletes records in uswf_giftpurchase/product_data by rule ID and product IDs
     *
     * @param int $ruleId
     * @param array $productIds
     */
    public function cleanProductData($ruleId, array $productIds = array())
    {
        /** @var $write Varien_Db_Adapter_Interface */
        $write = $this->_getWriteAdapter();

        $conditions = array('rule_id = ?' => $ruleId);

        if (count($productIds) > 0) {
            $conditions['product_id IN (?)'] = $productIds;
        }

        $write->delete($this->getTable('uswf_giftpurchase/rule_product'), $conditions);
    }

    /**
     * Return whether the product fits the rule
     *
     * @param USWF_GiftPurchase_Model_Rule $rule
     * @param Varien_Object $product
     * @param array $websiteIds
     * @return bool
     */
    public function validateProduct(USWF_GiftPurchase_Model_Rule $rule, Varien_Object $product, $websiteIds = array())
    {
        /** @var $helper Mage_Catalog_Helper_Product_Flat */
        $helper = $this->_factory->getHelper('catalog/product_flat');
        if ($helper->isEnabled() && $helper->isBuiltAllStores()) {
            /** @var $store Mage_Core_Model_Store */
            foreach ($this->_app->getStores(false) as $store) {
                if (count($websiteIds) == 0 || in_array($store->getWebsiteId(), $websiteIds)) {
                    /** @var $selectByStore Varien_Db_Select */
                    $selectByStore = $rule->getProductFlatSelect($store->getId());
                    $selectByStore->where('p.entity_id = ?', $product->getId());
                    $selectByStore->limit(1);
                    if ($this->_getReadAdapter()->fetchOne($selectByStore)) {
                        return true;
                    }
                }
            }
            return false;
        } else {
            return $rule->getConditions()->validate($product);
        }
    }

    /**
     * Inserts rule data into catalogrule/rule_product table
     *
     * @param USWF_GiftPurchase_Model_Rule $rule
     * @param array $websiteIds
     * @param array $productIds
     */
    public function insertRuleData(USWF_GiftPurchase_Model_Rule $rule, array $websiteIds, array $productIds = array())
    {
        /** @var $write Varien_Db_Adapter_Interface */
        $write = $this->_getWriteAdapter();

        $customerGroupIds = $rule->getCustomerGroupIds();
        $fromTime = (int) strtotime($rule->getFromDate());
        $toTime = (int) strtotime($rule->getToDate());
        $toTime = $toTime ? ($toTime + self::SECONDS_IN_DAY - 1) : 0;
        $sortOrder = (int) $rule->getSortOrder();
        /** @var $helper Mage_Catalog_Helper_Product_Flat */
        $helper = $this->_factory->getHelper('catalog/product_flat');

        if ($helper->isEnabled() && $helper->isBuiltAllStores()) {
            /** @var $store Mage_Core_Model_Store */
            foreach ($this->_app->getStores(false) as $store) {
                if (in_array($store->getWebsiteId(), $websiteIds)) {
                    /** @var $selectByStore Varien_Db_Select */
                    $selectByStore = $rule->getProductFlatSelect($store->getId())
                        ->joinLeft(array('cg' => $this->getTable('customer/customer_group')),
                            $write->quoteInto('cg.customer_group_id IN (?)', $customerGroupIds),
                            array('cg.customer_group_id'))
                        ->reset(Varien_Db_Select::COLUMNS)
                        ->columns(array(
                            new Zend_Db_Expr($store->getWebsiteId()),
                            'cg.customer_group_id',
                            'p.entity_id',
                            new Zend_Db_Expr($rule->getId()),
                            new Zend_Db_Expr($fromTime),
                            new Zend_Db_Expr($toTime),
                            new Zend_Db_Expr($sortOrder),
                        ));

                    if (count($productIds) > 0) {
                        $selectByStore->where('p.entity_id IN (?)', $productIds);
                    }

                    $selects = $write->selectsByRange('entity_id', $selectByStore, self::RANGE_PRODUCT_STEP);
                    foreach ($selects as $select) {
                        $write->query(
                            $write->insertFromSelect(
                                $select, $this->getTable('uswf_giftpurchase/rule_product'), array(
                                    'website_id',
                                    'customer_group_id',
                                    'product_id',
                                    'rule_id',
                                    'from_time',
                                    'to_time',
                                    'sort_order',
                                ), Varien_Db_Adapter_Interface::INSERT_IGNORE
                            )
                        );
                    }
                }
            }
        } else {
            if (count($productIds) == 0) {
                Varien_Profiler::start('__MATCH_PRODUCTS__');
                $productIds = $rule->getMatchingProductIds();
                Varien_Profiler::stop('__MATCH_PRODUCTS__');
            }

            $rows = array();
            foreach ($productIds as $productId => $validationByWebsite) {
                foreach ($websiteIds as $websiteId) {
                    foreach ($customerGroupIds as $customerGroupId) {
                        if (empty($validationByWebsite[$websiteId])) {
                            continue;
                        }
                        $rows[] = array(
                            'rule_id'             => $rule->getId(),
                            'from_time'           => $fromTime,
                            'to_time'             => $toTime,
                            'website_id'          => $websiteId,
                            'customer_group_id'   => $customerGroupId,
                            'product_id'          => $productId,
                            'sort_order'          => $sortOrder,
                        );

                        if (count($rows) == 1000) {
                            $write->insertMultiple($this->getTable('uswf_giftpurchase/rule_product'), $rows);
                            $rows = array();
                        }
                    }
                }
            }

            if (!empty($rows)) {
                $write->insertMultiple($this->getTable('uswf_giftpurchase/rule_product'), $rows);
            }
        }
    }

    /**
     * Update products which are matched for rule
     *
     * @param USWF_GiftPurchase_Model_Rule $rule
     *
     * @throws Exception
     * @return Mage_CatalogRule_Model_Resource_Rule
     */
    public function updateRuleProductData(USWF_GiftPurchase_Model_Rule $rule)
    {
        $ruleId = $rule->getId();
        $write  = $this->_getWriteAdapter();
        $write->beginTransaction();
        if ($rule->getProductsFilter()) {
            $this->cleanProductData($ruleId, $rule->getProductsFilter());
        } else {
            $this->cleanProductData($ruleId);
        }

        if (!$rule->getIsActive()) {
            $write->commit();
            return $this;
        }

        $websiteIds = $rule->getWebsiteIds();
        if (!is_array($websiteIds)) {
            $websiteIds = explode(',', $websiteIds);
        }
        if (empty($websiteIds)) {
            return $this;
        }

        try {
            $this->insertRuleData($rule, $websiteIds);
            $write->commit();
        } catch (Exception $e) {
            $write->rollback();
            throw $e;
        }

        return $this;
    }

    /**
     * Get all product ids matched for rule
     *
     * @param int $ruleId
     *
     * @return array
     */
    public function getRuleProductIds($ruleId)
    {
        $read = $this->_getReadAdapter();
        $select = $read->select()->from($this->getTable('uswf_giftpurchase/rule_product'), 'product_id')
            ->where('rule_id=?', $ruleId);

        return $read->fetchCol($select);
    }

    /**
     * Get DB resource statement for processing query result
     *
     * @param int $fromDate
     * @param int $toDate
     * @param int|null $productId
     * @param int|null $websiteId
     *
     * @return Zend_Db_Statement_Interface
     */
    protected function _getRuleProductsStmt($fromDate, $toDate, $productId = null, $websiteId = null)
    {
        $read = $this->_getReadAdapter();
        /**
         * Sort order is important
         * It used for check stop price rule condition.
         * website_id   customer_group_id   product_id  sort_order
         *  1           1                   1           0
         *  1           1                   1           1
         *  1           1                   1           2
         * if row with sort order 1 will have stop flag we should exclude
         * all next rows for same product id from price calculation
         */
        $select = $read->select()
            ->from(array('rp' => $this->getTable('uswf_giftpurchase/rule_product')))
            ->where($read->quoteInto('rp.from_time = 0 or rp.from_time <= ?', $toDate)
            . ' OR ' . $read->quoteInto('rp.to_time = 0 or rp.to_time >= ?', $fromDate))
            ->order(array('rp.website_id', 'rp.customer_group_id', 'rp.product_id', 'rp.sort_order', 'rp.rule_id'));

        if (!is_null($productId)) {
            $select->where('rp.product_id=?', $productId);
        }

        /**
         * Join default price and websites prices to result
         */
        $priceAttr  = Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'price');
        $priceTable = $priceAttr->getBackend()->getTable();
        $attributeId= $priceAttr->getId();

        $joinCondition = '%1$s.entity_id=rp.product_id AND (%1$s.attribute_id=' . $attributeId
            . ') and %1$s.store_id=%2$s';

        $select->join(
            array('pp_default'=>$priceTable),
            sprintf($joinCondition, 'pp_default', Mage_Core_Model_App::ADMIN_STORE_ID),
            array('default_price'=>'pp_default.value')
        );

        if ($websiteId !== null) {
            $website  = Mage::app()->getWebsite($websiteId);
            $defaultGroup = $website->getDefaultGroup();
            if ($defaultGroup instanceof Mage_Core_Model_Store_Group) {
                $storeId = $defaultGroup->getDefaultStoreId();
            } else {
                $storeId = Mage_Core_Model_App::ADMIN_STORE_ID;
            }

            $select->joinInner(
                array('product_website' => $this->getTable('catalog/product_website')),
                'product_website.product_id=rp.product_id ' .
                'AND rp.website_id=product_website.website_id ' .
                'AND product_website.website_id='.$websiteId,
                array()
            );

            $tableAlias = 'pp'.$websiteId;
            $fieldAlias = 'website_'.$websiteId.'_price';
            $select->joinLeft(
                array($tableAlias=>$priceTable),
                sprintf($joinCondition, $tableAlias, $storeId),
                array($fieldAlias=>$tableAlias.'.value')
            );
        } else {
            foreach (Mage::app()->getWebsites() as $website) {
                $websiteId  = $website->getId();
                $defaultGroup = $website->getDefaultGroup();
                if ($defaultGroup instanceof Mage_Core_Model_Store_Group) {
                    $storeId = $defaultGroup->getDefaultStoreId();
                } else {
                    $storeId = Mage_Core_Model_App::ADMIN_STORE_ID;
                }

                $tableAlias = 'pp' . $websiteId;
                $fieldAlias = 'website_' . $websiteId . '_price';
                $select->joinLeft(
                    array($tableAlias => $priceTable),
                    sprintf($joinCondition, $tableAlias, $storeId),
                    array($fieldAlias => $tableAlias.'.value')
                );
            }
        }

        return $read->query($select);
    }

    /**
     * Get active rule data based on few filters
     *
     * @param int|string $date
     * @param int $websiteId
     * @param int $customerGroupId
     * @param int $productId
     * @param string $field
     * @return array
     */
    public function getRulesFromProduct($date, $websiteId, $customerGroupId, $productId, $field = '*')
    {
        $adapter = $this->_getReadAdapter();
        if (is_string($date)) {
            $date = strtotime($date);
        }
        $select = $adapter->select()
            ->from($this->getTable('uswf_giftpurchase/rule_product'), $field)
            ->where('website_id = ?', $websiteId)
            ->where('customer_group_id = ?', $customerGroupId)
            ->where('product_id = ?', $productId)
            ->where('from_time = 0 or from_time <= ?', $date)
            ->where('to_time = 0 or to_time >= ?', $date);

        return $adapter->fetchAll($select);
    }

    /**
     * Apply catalog rule to product
     *
     * @param Mage_CatalogRule_Model_Rule $rule
     * @param Mage_Catalog_Model_Product $product
     * @param array $websiteIds
     *
     * @throws Exception
     * @return Mage_CatalogRule_Model_Resource_Rule
     */
    public function applyToProduct($rule, $product, $websiteIds)
    {
        if (!$rule->getIsActive()) {
            return $this;
        }

        $ruleId    = $rule->getId();
        $productId = $product->getId();

        $write = $this->_getWriteAdapter();
        $write->beginTransaction();

        if ($this->_isProductMatchedRule($ruleId, $product)) {
            $this->cleanProductData($ruleId, array($productId));
        }
        if ($this->validateProduct($rule, $product, $websiteIds)) {
            try {
                $this->insertRuleData($rule, $websiteIds, array(
                    $productId => array_combine(array_values($websiteIds), array_values($websiteIds)))
                );
            } catch (Exception $e) {
                $write->rollback();
                throw $e;
            }
        }

        $write->commit();
        return $this;
    }

    /**
     * Get ids of matched rules for specific product
     *
     * @param int $productId
     * @return array
     */
    public function getProductRuleIds($productId)
    {
        $read = $this->_getReadAdapter();
        $select = $read->select()->from($this->getTable('uswf_giftpurchase/rule_product'), 'rule_id');
        $select->where('product_id = ?', $productId);
        return array_flip($read->fetchCol($select));
    }

    /**
     * Is product has been matched the rule
     *
     * @param int $ruleId
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     */
    protected function _isProductMatchedRule($ruleId, $product)
    {
        $rules = $product->getMatchedRules();
        return isset($rules[$ruleId]);
    }

}
