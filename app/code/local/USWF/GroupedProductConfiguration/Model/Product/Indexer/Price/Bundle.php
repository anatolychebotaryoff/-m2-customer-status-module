<?php
/**
 * Bundle.php
 *
 * @category    USWF
 * @package     USWF_GroupedProductConfiguration
 * @copyright
 * @author
 */

class USWF_GroupedProductConfiguration_Model_Product_Indexer_Price_Bundle
    extends Mage_Bundle_Model_Resource_Indexer_Price {
    /**
     * Prepare temporary price index data for bundle products by price type
     *
     * @param int $priceType
     * @param int|array $entityIds the entity ids limitatation
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
    protected function _prepareBundlePriceByType($priceType, $entityIds = null)
    {
        $write = $this->_getWriteAdapter();
        $table = $this->_getBundlePriceTable();

        $select = $write->select()
            ->from(array('e' => $this->getTable('catalog/product')), array('entity_id'))
            ->join(
                array('cg' => $this->getTable('customer/customer_group')),
                '',
                array('customer_group_id')
            );
        $this->_addWebsiteJoinToSelect($select, true);
        $this->_addProductWebsiteJoinToSelect($select, 'cw.website_id', 'e.entity_id');
        $select->columns('website_id', 'cw')
            ->join(
                array('cwd' => $this->_getWebsiteDateTable()),
                'cw.website_id = cwd.website_id',
                array()
            )
            ->joinLeft(
                array('tp' => $this->_getTierPriceIndexTable()),
                'tp.entity_id = e.entity_id AND tp.website_id = cw.website_id'
                . ' AND tp.customer_group_id = cg.customer_group_id',
                array()
            )
            ->joinLeft(
                array('gp' => $this->_getGroupPriceIndexTable()),
                'gp.entity_id = e.entity_id AND gp.website_id = cw.website_id'
                . ' AND gp.customer_group_id = cg.customer_group_id',
                array()
            )
            ->joinLeft(
                array('gps' => 'catalog_product_entity_group_price'),
                'gps.entity_id = e.entity_id AND gps.website_id = cw.website_id'
                . ' AND gps.customer_group_id = cg.customer_group_id',
                array())
            ->where('e.type_id=?', $this->getTypeId());

        // add enable products limitation
        $statusCond = $write->quoteInto('=?', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        $this->_addAttributeToSelect($select, 'status', 'e.entity_id', 'cs.store_id', $statusCond, true);
        if (Mage::helper('core')->isModuleEnabled('Mage_Tax')) {
            $taxClassId = $this->_addAttributeToSelect($select, 'tax_class_id', 'e.entity_id', 'cs.store_id');
        } else {
            $taxClassId = new Zend_Db_Expr('0');
        }

        if ($priceType == Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC) {
            $select->columns(array('tax_class_id' => new Zend_Db_Expr('0')));
        } else {
            $select->columns(
                array('tax_class_id' => $write->getCheckSql($taxClassId . ' IS NOT NULL', $taxClassId, 0))
            );
        }

        $priceTypeCond = $write->quoteInto('=?', $priceType);
        $this->_addAttributeToSelect($select, 'price_type', 'e.entity_id', 'cs.store_id', $priceTypeCond);

        $price          = $this->_addAttributeToSelect($select, 'price', 'e.entity_id', 'cs.store_id');
        $specialPrice   = $this->_addAttributeToSelect($select, 'special_price', 'e.entity_id', 'cs.store_id');
        $specialFrom    = $this->_addAttributeToSelect($select, 'special_from_date', 'e.entity_id', 'cs.store_id');
        $specialTo      = $this->_addAttributeToSelect($select, 'special_to_date', 'e.entity_id', 'cs.store_id');
        $packageQty     = $this->_addAttributeToSelect($select, 'package_qty', 'e.entity_id', 'cs.store_id');
        $msrp           = $this->_addAttributeToSelect($select, 'msrp', 'e.entity_id', 'cs.store_id');
        $curentDate     = new Zend_Db_Expr('cwd.website_date');

        $specialExpr    = $write->getCheckSql(
            $write->getCheckSql(
                $specialFrom . ' IS NULL',
                '1',
                $write->getCheckSql(
                    $specialFrom . ' <= ' . $curentDate,
                    '1',
                    '0'
                )
            ) . " > 0 AND ".
            $write->getCheckSql(
                $specialTo . ' IS NULL',
                '1',
                $write->getCheckSql(
                    $specialTo . ' >= ' . $curentDate,
                    '1',
                    '0'
                )
            )
            . " > 0 AND {$specialPrice} > 0 AND {$specialPrice} < 100 ",
            $specialPrice,
            '0'
        );

        $groupPriceExpr = $write->getCheckSql(
            'gp.price IS NOT NULL AND gp.price > 0',
            'gp.price',
            '0'
        );

        $tierExpr       = new Zend_Db_Expr("tp.min_price");

        if ($priceType == Mage_Bundle_Model_Product_Price::PRICE_TYPE_FIXED) {
            $finalPrice = $write->getCheckSql(
                $specialExpr . ' > 0',
                'ROUND(' . $price . ' * (' . $specialExpr . '  / 100), 2)',
                $price
            );
            $tierPrice = $write->getCheckSql(
                $tierExpr . ' IS NOT NULL',
                'ROUND(' . $price . ' - ' . '(' . $price . ' * (' . $tierExpr . ' / 100)), 2)',
                'NULL'
            );
            $groupPrice = $write->getCheckSql(
                $groupPriceExpr . ' > 0',
                'ROUND(' . $price . ' - ' . '(' . $price . ' * (' . $groupPriceExpr . ' / 100)), 2)',
                'NULL'
            );
            $groupPrice = $write->getCheckSql(
                'gps.isfixed > 0',
                'ROUND(' . $groupPriceExpr .', 2)',
                $groupPrice
            );
            $finalPrice = $write->getCheckSql(
                "{$groupPrice} IS NOT NULL AND {$groupPrice} < {$finalPrice}",
                $groupPrice,
                $finalPrice
            );
            $minUnitPrice = $write->getCheckSql(
                "{$packageQty} IS NOT NULL",
                'ROUND(' . $finalPrice . ' / ' . $packageQty . ', 2)',
                $finalPrice
            );
        } else {
            $finalPrice     = new Zend_Db_Expr("0");
            $minUnitPrice   = new Zend_Db_Expr("0");
            $tierPrice      = $write->getCheckSql($tierExpr . ' IS NOT NULL', '0', 'NULL');
            $groupPrice     = $write->getCheckSql($groupPriceExpr . ' > 0', $groupPriceExpr, 'NULL');
        }

        $select->columns(array(
            'price_type'          => new Zend_Db_Expr($priceType),
            'special_price'       => $specialExpr,
            'tier_percent'        => $tierExpr,
            'orig_price'          => $write->getCheckSql($price . ' IS NULL', '0', $price),
            'price'               => $finalPrice,
            'min_price'           => $finalPrice,
            'max_price'           => $finalPrice,
            'tier_price'          => $tierPrice,
            'base_tier'           => $tierPrice,
            'group_price'         => $groupPrice,
            'base_group_price'    => $groupPrice,
            'group_price_percent' => new Zend_Db_Expr('gp.price'),
            'min_unit_price'      => $minUnitPrice
        ));

        if (!is_null($entityIds)) {
            $select->where('e.entity_id IN(?)', $entityIds);
        }

        /**
         * Add additional external limitation
         */
        Mage::dispatchEvent('catalog_product_prepare_index_select', array(
            'select'        => $select,
            'entity_field'  => new Zend_Db_Expr('e.entity_id'),
            'website_field' => new Zend_Db_Expr('cw.website_id'),
            'store_field'   => new Zend_Db_Expr('cs.store_id')
        ));

        $query = $select->insertFromSelect($table);
        $write->query($query);

        return $this;
    }

    /**
     * Calculate fixed bundle product selections price
     *
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
    protected function _calculateBundleOptionPrice()
    {
        $write = $this->_getWriteAdapter();

        $this->_prepareBundleSelectionTable();
        $this->_calculateBundleSelectionPrice(Mage_Bundle_Model_Product_Price::PRICE_TYPE_FIXED);
        $this->_calculateBundleSelectionPrice(Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC);

        $this->_prepareBundleOptionTable();

        $select = $write->select()
            ->from(
                array('i' => $this->_getBundleSelectionTable()),
                array('entity_id', 'customer_group_id', 'website_id', 'option_id')
            )
            ->group(array('entity_id', 'customer_group_id', 'website_id', 'option_id', 'is_required', 'group_type'))
            ->columns(array(
                'min_price' => $write->getCheckSql('i.is_required = 1', 'MIN(i.price)', '0'),
                'alt_price' => $write->getCheckSql('i.is_required = 0', 'MIN(i.price)', '0'),
                'max_price' => $write->getCheckSql('i.group_type = 1', 'SUM(i.price)', 'MAX(i.price)'),
                'tier_price' => $write->getCheckSql('i.is_required = 1', 'MIN(i.tier_price)', '0'),
                'alt_tier_price' => $write->getCheckSql('i.is_required = 0', 'MIN(i.tier_price)', '0'),
                'group_price' => $write->getCheckSql('i.is_required = 1', 'MIN(i.group_price)', '0'),
                'alt_group_price' => $write->getCheckSql('i.is_required = 0', 'MIN(i.group_price)', '0'),
            ));

        $query = $select->insertFromSelect($this->_getBundleOptionTable());
        $write->query($query);

        $this->_prepareDefaultFinalPriceTable();

        $minPrice  = new Zend_Db_Expr($write->getCheckSql(
                'SUM(io.min_price) = 0',
                'MIN(io.alt_price)',
                'SUM(io.min_price)'
            ) . ' + i.price');
        $maxPrice  = new Zend_Db_Expr("SUM(io.max_price) + i.price");
        $tierPrice = $write->getCheckSql(
            'MIN(i.tier_percent) IS NOT NULL',
            $write->getCheckSql(
                'SUM(io.tier_price) = 0',
                'SUM(io.alt_tier_price)',
                'SUM(io.tier_price)'
            ) . ' + MIN(i.tier_price)',
            'NULL'
        );
        $groupPrice = $write->getCheckSql(
            'MIN(i.group_price_percent) IS NOT NULL',
            $write->getCheckSql(
                'SUM(io.group_price) = 0',
                'SUM(io.alt_group_price)',
                'SUM(io.group_price)'
            ) . ' + MIN(i.group_price)',
            'NULL'
        );

        $select = $write->select()
            ->from(
                array('io' => $this->_getBundleOptionTable()),
                array('entity_id', 'customer_group_id', 'website_id')
            )
            ->join(
                array('i' => $this->_getBundlePriceTable()),
                'i.entity_id = io.entity_id AND i.customer_group_id = io.customer_group_id'
                . ' AND i.website_id = io.website_id',
                array()
            )
            ->group(array('io.entity_id', 'io.customer_group_id', 'io.website_id',
                'i.tax_class_id', 'i.orig_price', 'i.price'))
            ->columns(array('i.tax_class_id',
                'orig_price'       => 'i.orig_price',
                'price'            => 'i.price',
                'min_price'        => $minPrice,
                'max_price'        => $maxPrice,
                'tier_price'       => $tierPrice,
                'base_tier'        => 'MIN(i.base_tier)',
                'group_price'      => $groupPrice,
                'base_group_price' => 'MIN(i.base_group_price)',
                'min_unit_price'   => 'i.min_unit_price'
            ));

        $query = $select->insertFromSelect($this->_getDefaultFinalPriceTable());
        $write->query($query);

        return $this;
    }

    /**
     * Mode Final Prices index to primary temporary index table
     *
     * @return Mage_Catalog_Model_Resource_Product_Indexer_Price_Default
     */
    protected function _movePriceDataToIndexTable()
    {
        $columns = array(
            'entity_id'         => 'entity_id',
            'customer_group_id' => 'customer_group_id',
            'website_id'        => 'website_id',
            'tax_class_id'      => 'tax_class_id',
            'price'             => 'orig_price',
            'final_price'       => 'price',
            'min_price'         => 'min_price',
            'max_price'         => 'max_price',
            'tier_price'        => 'tier_price',
            'group_price'       => 'group_price',
            'min_unit_price'    => 'min_unit_price'
        );

        $write  = $this->_getWriteAdapter();
        $table  = $this->_getDefaultFinalPriceTable();
        $select = $write->select()
            ->from($table, $columns);

        $query = $select->insertFromSelect($this->getIdxTable(), array(), true);
        $write->query($query);

        $write->delete($table);

        return $this;
    }
}