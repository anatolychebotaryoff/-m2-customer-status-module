<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$compareWidgetDefaultColumn = array(
    'page_is_active' => 'Page is Active Default',
    'page_title' => 'Page Title Default',
    'page_identifier' => 'Page Identifier Default',
    'page_meta_robots' => 'Page Meta Robots Default',
    'page_exclude_from_sitemap' => 'Page Exclude From Sitemap Default',
    'options_tier_price_output' => 'Options Tier Price Output Default',
    'options_active_tabs' => 'Options Active Tabs Default',
    'options_display_sku' => 'Options Display Sku',
    'options_attributes' => 'Options Attributes Default'
);
$option = USWF_ComparePage_Helper_Data::$COMPARE_PRODUCTS_OPTIONS;

$installer->startSetup();
$connection = $installer->getConnection();

$linkTypeTable = $installer->getTable('catalog/product_link_type');
$select = $connection->select()
    ->from($linkTypeTable)
    ->where($linkTypeTable . '.link_type_id = ?', USWF_ComparePage_Model_Compare_Widget::LINK_TYPE_COMPARE)
    ->where($linkTypeTable . '.code = ?', 'compared');
$row = $connection->fetchRow($select);
if (!$row) {
    /**
     * Install product link types
     */
    $data = array(
        array(
            'link_type_id'  => USWF_ComparePage_Model_Compare_Widget::LINK_TYPE_COMPARE,
            'code'          => 'compared'
        )
    );
    foreach ($data as $bind) {
        $installer->getConnection()->insertForce($installer->getTable('catalog/product_link_type'), $bind);
    }

    /**
     * Install product link attributes
     */
    $data = array(
        array(
            'link_type_id'                  => USWF_ComparePage_Model_Compare_Widget::LINK_TYPE_COMPARE,
            'product_link_attribute_code'   => 'compared_position',
            'data_type'                     => 'int'
        ),
        array(
            'link_type_id'                  => USWF_ComparePage_Model_Compare_Widget::LINK_TYPE_COMPARE,
            'product_link_attribute_code'   => 'compared_website_id',
            'data_type'                     => 'varchar'
        )
    );
    $connection->insertMultiple($installer->getTable('catalog/product_link_attribute'), $data);

}

$compareTable = $installer->getTable('uswf_comparepage/compare_widget');
if (!$connection->isTableExists($compareTable)) {
    $table = $connection->newTable($compareTable)
        ->addColumn('compare_widget_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Compare Widget Id')
        ->addColumn('parent_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Parent Product Id')
        ->addColumn('compared_products', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Compared Products')
        ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Website Id')
        ->addColumn('is_create_compare_page', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Is Create Compare Page')
        ->addColumn('page_is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Page Is Active')
        ->addColumn('page_title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ),'Page Title')
        ->addColumn('page_identifier', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ),'URL Key')
        ->addColumn('page_meta_robots', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Meta Robots')
        ->addColumn('page_exclude_from_sitemap', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), 'Exclude from XML Sitemap')
        ->addColumn('options_tier_price_output', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Output Tier Prices')
        ->addColumn('options_active_tabs', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Enabled Tabs')
        ->addColumn('options_display_sku', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), 'Display SKU')
        ->addColumn('options_attributes', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Attributes to Include');
    foreach ($option as $item) {
        $table
            ->addColumn('product_custom_name_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Product Custom Name '.$item)
            ->addColumn('review_id_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Review Id '.$item)
            ->addColumn('review_text_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Review Text '.$item)
            ->addColumn('static_block_id_quality_icons_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Static Block Id for Product1(quality-icons) '.$item)
            ->addColumn('title_bar_text_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Title Bar Text '.$item)
            ->addColumn('ribbon_pos_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Ribbon Position '.$item)
            ->addColumn('details_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Details Tab Text '.$item)
            ->addColumn('compatibility_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Compatibility Tab Text '.$item);
    }
//        ->addIndex($installer->getIdxName($compareTable, array('compare_widget_default_id')),
//            array('compare_widget_default_id'))
//        ->addForeignKey($installer->getFkName($compareTable, 'compare_widget_default_id', 'uswf_comparepage/compare_widget_default', 'compare_widget_default_id'),
//            'compare_widget_default_id', $installer->getTable('uswf_comparepage/compare_widget_default'), 'compare_widget_default_id',
//            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
    $connection->createTable($table);
}

$compareTable = $installer->getTable('uswf_comparepage/compare_widget_store');
if (!$connection->isTableExists($compareTable)) {
    $table = $connection->newTable($compareTable)
        ->addColumn('compare_widget_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Compare Widget Id')
        ->addColumn('parent_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Parent Product Id')
        ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Website Id')
        ->addColumn('is_create_compare_page', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Is Create Compare Page')
        ->addColumn('page_is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Page Is Active')
        ->addColumn('page_title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ),'Page Title')
        ->addColumn('page_identifier', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ),'URL Key')
        ->addColumn('page_meta_robots', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Meta Robots')
        ->addColumn('page_exclude_from_sitemap', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), 'Exclude from XML Sitemap')
        ->addColumn('options_tier_price_output', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Output Tier Prices')
        ->addColumn('options_active_tabs', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Enabled Tabs')
        ->addColumn('options_display_sku', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), 'Display SKU')
        ->addColumn('options_attributes', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Attributes to Include');
    foreach ($option as $item) {
        $table
            ->addColumn('product_custom_name_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Product Custom Name '.$item)
            ->addColumn('review_id_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Review Id '.$item)
            ->addColumn('review_text_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Review Text '.$item)
            ->addColumn('static_block_id_quality_icons_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Static Block Id for Product1(quality-icons) '.$item)
            ->addColumn('title_bar_text_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Title Bar Text '.$item)
            ->addColumn('ribbon_pos_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Ribbon Position '.$item)
            ->addColumn('details_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Details Tab Text '.$item)
            ->addColumn('compatibility_option_'.$item, Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'unsigned'  => true,
                'nullable'  => false,
            ), 'Compatibility Tab Text '.$item);
    }
    $connection->createTable($table);
}

$compareDefaultTable = $installer->getTable('uswf_comparepage/compare_widget_default');
if (!$connection->isTableExists($compareDefaultTable)) {
    $table = $connection->newTable($compareDefaultTable)
        ->addColumn('compare_widget_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Compare Widget Id Default')
        ->addColumn('parent_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Parent Product Default Id')
        ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Website Id Default');
    foreach ($compareWidgetDefaultColumn as $nameColumn => $comment) {
        $table->addColumn($nameColumn, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), $comment);
    }
    foreach ($option as $item) {
        $table
            ->addColumn('product_custom_name_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Product Custom Name '.$item)
            ->addColumn('review_id_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Review Id '.$item)
            ->addColumn('review_text_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Review Text '.$item)
            ->addColumn('static_block_id_quality_icons_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Static Block Id for Product1(quality-icons) '.$item)
            ->addColumn('title_bar_text_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Title Bar Text '.$item)
            ->addColumn('ribbon_pos_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Ribbon Position '.$item)
            ->addColumn('details_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Details Tab Text '.$item)
            ->addColumn('compatibility_option_'.$item, Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
                'nullable'  => false,
                'default'   => '1',
            ), 'Compatibility Tab Text '.$item);
    }
    $connection->createTable($table);
}


//$setup = Mage::getResourceModel('catalog/setup','catalog_setup');
//$setup->removeAttribute('catalog_product','compare_widget_id');
//$installerEav = Mage::getResourceModel('catalog/setup','catalog_setup');
//$installerEav->addAttribute('catalog_product', 'compare_widget_id', array(
//    'label' => 'Compare Widget Id',
//    'type' => 'int',
//    'input' => 'text',
//    'visible' => false,
//    'required' => false,
//    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
//    'default'           => '',
//    'searchable'        => false,
//    'filterable'        => false,
//    'comparable'        => false,
//    'visible_on_front'  => false,
//    'unique'            => false,
//));

$installer->endSetup();