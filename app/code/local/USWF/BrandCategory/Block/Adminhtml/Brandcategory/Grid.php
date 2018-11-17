<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Block_Adminhtml_BrandCategory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid, add sorting
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('BrandCategoryGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }

    /**
     * Prepare Brand Category Record collection
     *
     * @return USWF_BrandCategory_Block_Adminhtml_BrandCategory_Grid
     */
    protected function _prepareCollection()
    {

        $collection = Mage::getModel('uswf_brandcategory/record')->getCollection()
            ->join(
                array('brandref' => 'eav/attribute_option_value'),
                'brand=option_id AND brandref.store_id = 0');
        $collection->getSelect()->joinLeft(
            array('categoryref' => 'catalog_category_entity'),
            'record=entity_id', '*');

        $this->setCollection($collection);
        parent::_prepareCollection();

        return $this;

    }

    protected function _filterStoreCondition($collection, $column){

        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);

    }

    /**
     * Prepare visible columns in grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('uswf_brandcategory')->__('ID'),
            'align' => 'left',
            'width' => '30px',
            'index' => 'id',
        ));

        $brands = Mage::helper('uswf_brandcategory')->getAllBrandsArray(false);
        $_brands = array();
        foreach ($brands as $brand) {
            $_brands[$brand["value"]] = $brand["label"];
        }

        $this->addColumn('brand', array(
            'header' => Mage::helper('uswf_brandcategory')->__('Brand'),
            'align' => 'left',
            'index' => "value",
            'options' => $_brands,
            'type' => 'options',
            'getter' => 'getValue',
        ));

        $categories = Mage::helper('uswf_brandcategory')->getAllCategoriesArray(false);
        $_categories = array();

        foreach ($categories as $parentCategory) {
            foreach ($parentCategory["value"] as $category) {
                $_categories[$category["value"]] = $category["label"];
            }
        }


        $this->addColumn('record', array(
            'header' => Mage::helper('uswf_brandcategory')->__('Category'),
            'align' => 'left',
            'index' => "entity_id",
            'type' => 'options',
            'options' => $_categories,
        ));

        $this->addColumn('description', array(
            'header' => Mage::helper('uswf_brandcategory')->__('Description'),
            'align' => 'left',
            'index' => 'description',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('uswf_brandcategory')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => true,
                'filter_condition_callback' => array($this,
                    '_filterStoreCondition'),
            ));
        }

        $this->addColumn('enabled', array(
            'header' => Mage::helper('uswf_brandcategory')->__('Status'),
            'index' => 'enabled',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('uswf_brandcategory')->__('Disabled'),
                1 => Mage::helper('uswf_brandcategory')->__('Enabled'),
            ),
        ));


        return parent::_prepareColumns();
    }

    /**
     * Prepare massactions
     *
     * @return USWF_BrandCategory_Block_Adminhtml_BrandCategory_Grid|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('massaction');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('uswf_brandcategory')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('uswf_brandcategory')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('uswf_brandcategory')->__('Change Status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('uswf_brandcategory')->__('Status'),
                    'values' => array(
                        0 => Mage::helper('uswf_brandcategory')->__('Disabled'),
                        1 => Mage::helper('uswf_brandcategory')->__('Enabled'),
                    ),
                )
            )
        ));

        return $this;
    }

    /**
     * Prepare link for edit
     *
     * @param USWF_BrandCategory_Model_BrandCategory $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
