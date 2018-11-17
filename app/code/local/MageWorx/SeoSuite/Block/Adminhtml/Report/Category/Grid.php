<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */
class MageWorx_Seosuite_Block_Adminhtml_Report_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('entity_id');
        $this->setUseAjax(true);
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);

        if (!Mage::registry('error_types')){
            Mage::register('error_types', Mage::helper('seosuite/report')->getErrorTypes());
        }
    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return $storeId;
    }

    protected function _prepareCollection()
    {
        $store      = $this->_getStore();
        $maxLengthMetaTitle = Mage::helper('seosuite/report')->getMaxLengthMetaTitle();
        $maxLengthMetaDescription = Mage::helper('seosuite/report')->getMaxLengthMetaDescription();

        $collection = Mage::getResourceModel('seosuite/report_category_collection');
        if ($store) {
            $collection->addFieldToFilter('store_id', $store);
        }
        else {
            $collection->getSelect()->where('store_id <>?', 0);
        }

        $collection->getSelect()->where('store_id <>?', 0);

        $collection->getSelect()->where("`meta_title_len` = 0   OR
                                        `meta_title_len` > " . $maxLengthMetaTitle . "  OR
                                        `meta_descr_len` = 0   OR
                                        `meta_descr_len` > " . $maxLengthMetaDescription . " OR
                                        `name_dupl` > 1        OR
                                        `meta_title_dupl` > 1 OR
                                        `prepared_meta_title` = ''");

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('id',
                array(
            'header' => Mage::helper('seosuite')->__('ID'),
            'width'  => '50px',
            'type'   => 'number',
            'index'  => 'entity_id',
            'align'  => 'center',
        ));

//        $this->addColumn('category_id', array(
//            'header'=> Mage::helper('seosuite')->__('Category ID'),
//            'width' => '50px',
//            'type'  => 'hidden',
//            'index' => 'category_id',
//            'align' => 'center',
//        ));

        $this->addColumn('name',
                array(
            'header' => Mage::helper('seosuite')->__('Category Name'),
            //'width' => '300px',
            'type'   => 'text',
            'index'  => 'name',
            'align'  => 'left',
        ));

        $this->addColumn('url',
                array(
            'header'   => Mage::helper('seosuite')->__('Url'),
            'renderer' => 'seosuite/adminhtml_report_grid_renderer_url',
            //'width' => '300px',
            'type'     => 'text',
            'index'    => 'url_path',
            'align'    => 'left',
        ));

        $this->addColumn('level',
                array(
            'header' => Mage::helper('seosuite')->__('Level'),
            'width'  => '50px',
            'type'   => 'number',
            'index'  => 'level',
            'align'  => 'center',
        ));

        $this->addColumn('name_error',
                array(
            'renderer' => 'seosuite/adminhtml_report_grid_renderer_error',
            'filter'   => 'seosuite/adminhtml_report_grid_filter_error',
            'type'     => 'options',
            'options'  => Mage::helper('seosuite/report')->getErrorTypes(array('duplicate')),
            'header'   => Mage::helper('seosuite')->__('Name'),
            'index'    => 'name_error',
            //'width'    => '100px',
            'width'    => '150px',
            'align'    => 'center',
            'sortable' => false,
        ));

        $this->addColumn('meta_title_error',
                array(
            'renderer' => 'seosuite/adminhtml_report_grid_renderer_error',
            'filter'   => 'seosuite/adminhtml_report_grid_filter_error',
            'type'     => 'options',
            'options'  => Mage::helper('seosuite/report')->getErrorTypes(),
            'header'   => Mage::helper('seosuite')->__('Meta Title'),
            'index'    => 'meta_title_error',
            //'width'    => '100px',
            'width'    => '150px',
            'sortable' => false,
            'align'    => 'center',
        ));

        $this->addColumn('meta_descr_error',
                array(
            'renderer' => 'seosuite/adminhtml_report_grid_renderer_error',
            'filter'   => 'seosuite/adminhtml_report_grid_filter_error',
            'type'     => 'options',
            'options'  => Mage::helper('seosuite/report')->getErrorTypes(array('missing', 'long')),
            'header'   => Mage::helper('seosuite')->__('Meta Description'),
            'index'    => 'meta_descr_error',
            //'width'    => '100px',
            'width'    => '150px',
            'sortable' => false,
            'align'    => 'center',
        ));
        $this->addColumn('store',
                array(
            'header'                    => Mage::helper('seosuite')->__('Store View'),
            'index'                     => 'store_id',
            'type'                      => 'store',
            'store_all'                 => true,
            'store_view'                => true,
            'sortable'                  => false,
            'filter_condition_callback'
            => array($this, '_filterStoreCondition'),
        ));

        /**
         * @TODO Category page redirect to root category by js.

        $this->addColumn('action',
                array(
            'header'    => Mage::helper('seosuite')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'    => 'getCategoryId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('seosuite')->__('Edit'),
                    'url'     => array('base'   => 'adminhtml/catalog_category/edit/', 'params' => array('store' => $this->getRequest()->getParam('store'))),
                    'field'   => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'align'     => 'center',
            'is_system' => true,
        ));
        */

        return parent::_prepareColumns();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addFieldToFilter('store_id', $value);
    }

    protected function _prepareMassaction()
    {
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/catalog_category/edit',
                        array('id'    => $row->getCategoryId(), 'store' => $this->getRequest()->getParam('store')));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

}
