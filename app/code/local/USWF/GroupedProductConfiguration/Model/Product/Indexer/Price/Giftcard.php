<?php
/**
 * Giftcard.php
 *
 * @category    USWF
 * @package     USWF_GroupedProductConfiguration
 * @copyright
 * @author
 */

class USWF_GroupedProductConfiguration_Model_Product_Indexer_Price_Giftcard
    extends Enterprise_GiftCard_Model_Resource_Indexer_Price {

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

    /**
     * Prepare giftCard products prices in temporary index table
     *
     * @param int|array $entityIds  the entity ids limitation
     * @return Enterprise_GiftCard_Model_Resource_Indexer_Price
     */
    protected function _prepareFinalPriceData($entityIds = null)
    {
        $this->_prepareDefaultFinalPriceTable();

        $write  = $this->_getWriteAdapter();
        $select = $write->select()
            ->from(array('e' => $this->getTable('catalog/product')), array('entity_id'))
            ->join(
                array('cg' => $this->getTable('customer/customer_group')),
                '',
                array('customer_group_id')
            );
        $this->_addWebsiteJoinToSelect($select, true);
        $this->_addProductWebsiteJoinToSelect($select, 'cw.website_id', 'e.entity_id');
        $select->columns(array('website_id'), 'cw')
            ->columns(array('tax_class_id'  => new Zend_Db_Expr('0')))
            ->where('e.type_id = ?', $this->getTypeId());

        // add enable products limitation
        $statusCond = $write->quoteInto('=?', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        $this->_addAttributeToSelect($select, 'status', 'e.entity_id', 'cs.store_id', $statusCond, true);

        $allowOpenAmount = $this->_addAttributeToSelect($select, 'allow_open_amount', 'e.entity_id', 'cs.store_id');
        $openAmountMin    = $this->_addAttributeToSelect($select, 'open_amount_min', 'e.entity_id', 'cs.store_id');
//        $openAmounMax    = $this->_addAttributeToSelect($select, 'open_amount_max', 'e.entity_id', 'cs.store_id');



        $attrAmounts = $this->_getAttribute('giftcard_amounts');
        // join giftCard amounts table
        $select->joinLeft(
            array('gca' => $this->getTable('enterprise_giftcard/amount')),
            'gca.entity_id = e.entity_id AND gca.attribute_id = '
            . $attrAmounts->getAttributeId()
            . ' AND (gca.website_id = cw.website_id OR gca.website_id = 0)',
            array()
        );

        $amountsExpr    = 'MIN(' . $write->getCheckSql('gca.value_id IS NULL', 'NULL', 'gca.value') . ')';

        $openAmountExpr = 'MIN(' . $write->getCheckSql(
                $allowOpenAmount . ' = 1',
                $write->getCheckSql($openAmountMin . ' > 0', $openAmountMin, '0'),
                'NULL'
            ) . ')';

        $priceExpr = new Zend_Db_Expr(
            'ROUND(' . $write->getCheckSql(
                $openAmountExpr . ' IS NULL',
                $write->getCheckSql($amountsExpr . ' IS NULL', '0', $amountsExpr),
                $write->getCheckSql(
                    $amountsExpr . ' IS NULL',
                    $openAmountExpr,
                    $write->getCheckSql(
                        $openAmountExpr . ' > ' . $amountsExpr,
                        $amountsExpr,
                        $openAmountExpr
                    )
                )
            ) . ', 4)'
        );

        $select->group(array('e.entity_id', 'cg.customer_group_id', 'cw.website_id'))
            ->columns(array(
                'price'            => new Zend_Db_Expr('NULL'),
                'final_price'      => $priceExpr,
                'min_price'        => $priceExpr,
                'max_price'        => new Zend_Db_Expr('NULL'),
                'tier_price'       => new Zend_Db_Expr('NULL'),
                'base_tier'        => new Zend_Db_Expr('NULL'),
                'group_price'      => new Zend_Db_Expr('NULL'),
                'base_group_price' => new Zend_Db_Expr('NULL'),
                'min_unit_price'   => new Zend_Db_Expr('NULL')
            ));

        if (!is_null($entityIds)) {
            $select->where('e.entity_id IN(?)', $entityIds);
        }

        /**
         * Add additional external limitation
         */
        Mage::dispatchEvent('prepare_catalog_product_index_select', array(
            'select'        => $select,
            'entity_field'  => new Zend_Db_Expr('e.entity_id'),
            'website_field' => new Zend_Db_Expr('cw.website_id'),
            'store_field'   => new Zend_Db_Expr('cs.store_id')
        ));

        $query = $select->insertFromSelect($this->_getDefaultFinalPriceTable());
        $write->query($query);

        return $this;
    }
}