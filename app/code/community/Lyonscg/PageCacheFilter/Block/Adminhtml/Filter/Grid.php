<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Block_Adminhtml_Filter_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid, add sorting
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('FiltersGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }

    /**
     * Prepare filter collection
     *
     * @return Lyonscg_PageCacheFilter_Block_Adminhtml_Filter_Grid
     */
    protected function _prepareCollection()
    {
        /** @var $collection Lyonscg_PageCacheFilter_Model_Resource_Filter_Collection */
        $collection = Mage::getModel('lyonscg_pagecachefilter/filter')->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * Prepare visible columns in grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('lyonscg_pagecachefilter')->__('ID'),
            'align' => 'left',
            'width' => '30px',
            'index' => 'id',
        ));

        $this->addColumn('param', array(
            'header' => Mage::helper('lyonscg_pagecachefilter')->__('Parameter'),
            'align' => 'left',
            'index' => "param",
        ));

        $this->addColumn('description', array(
            'header' => Mage::helper('lyonscg_pagecachefilter')->__('Description'),
            'align' => 'left',
            'index' => 'description',
        ));

        $this->addColumn('enabled', array(
            'header' => Mage::helper('lyonscg_pagecachefilter')->__('Status'),
            'index' => 'enabled',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('lyonscg_pagecachefilter')->__('Disabled'),
                1 => Mage::helper('lyonscg_pagecachefilter')->__('Enabled'),
            ),
        ));

        $this->addColumn('target', array(
            'header' => Mage::helper('lyonscg_pagecachefilter')->__('Filter Level'),
            'index' => 'target',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('lyonscg_pagecachefilter')->__('Full Page Cache Only'),
                1 => Mage::helper('lyonscg_pagecachefilter')->__('Application'),
            ),
        ));

        return parent::_prepareColumns();
    }

    /**
     * Prepare massactions
     *
     * @return Lyonscg_PageCacheFilter_Block_Adminhtml_Filter_Grid|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('massaction');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('lyonscg_pagecachefilter')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('lyonscg_pagecachefilter')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('lyonscg_pagecachefilter')->__('Change Status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('lyonscg_pagecachefilter')->__('Status'),
                    'values' => array(
                        0 => Mage::helper('lyonscg_pagecachefilter')->__('Disabled'),
                        1 => Mage::helper('lyonscg_pagecachefilter')->__('Enabled'),
                    ),
                )
            )
        ));

        return $this;
    }

    /**
     * Prepare link for edit
     *
     * @param Lyonscg_PageCacheFilter_Model_Filter $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
