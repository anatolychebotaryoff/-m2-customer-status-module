<?php
/**
 * USWF Parameter Dispatch Event
 *
 * @category    USWF
 * @package     USWF_ParameterDispatch
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_ParameterDispatch_Block_Adminhtml_ParameterDispatch_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid, add sorting
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('ParameterDispatchGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }

    /**
     * Prepare Parameter Dispatch Event collection
     *
     * @return USWF_ParameterDispatch_Block_Adminhtml_ParameterDispatch_Grid
     */
    protected function _prepareCollection()
    {
        /** @var $collection USWF_ParameterDispatch_Model_Resource_ParameterDispatch_Collection */
        $collection = Mage::getModel('uswf_parameterdispatch/event')->getCollection();
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
            'header' => Mage::helper('uswf_parameterdispatch')->__('ID'),
            'align' => 'left',
            'width' => '30px',
            'index' => 'id',
        ));

        $this->addColumn('param', array(
            'header' => Mage::helper('uswf_parameterdispatch')->__('Parameter'),
            'align' => 'left',
            'index' => "param",
        ));

        $this->addColumn('event', array(
            'header' => Mage::helper('uswf_parameterdispatch')->__('Event'),
            'align' => 'left',
            'index' => "event",
        ));

        $this->addColumn('description', array(
            'header' => Mage::helper('uswf_parameterdispatch')->__('Description'),
            'align' => 'left',
            'index' => 'description',
        ));

        $this->addColumn('priority', array(
            'header' => Mage::helper('uswf_parameterdispatch')->__('Priority'),
            'align' => 'left',
            'index' => "priority",
        ));

        $this->addColumn('enabled', array(
            'header' => Mage::helper('uswf_parameterdispatch')->__('Status'),
            'index' => 'enabled',
            'type' => 'options',
            'options' => array(
                0 => Mage::helper('uswf_parameterdispatch')->__('Disabled'),
                1 => Mage::helper('uswf_parameterdispatch')->__('Enabled'),
            ),
        ));


        return parent::_prepareColumns();
    }

    /**
     * Prepare massactions
     *
     * @return USWF_ParameterDispatch_Block_Adminhtml_ParameterDispatch_Grid|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('massaction');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('uswf_parameterdispatch')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('uswf_parameterdispatch')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('uswf_parameterdispatch')->__('Change Status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('uswf_parameterdispatch')->__('Status'),
                    'values' => array(
                        0 => Mage::helper('uswf_parameterdispatch')->__('Disabled'),
                        1 => Mage::helper('uswf_parameterdispatch')->__('Enabled'),
                    ),
                )
            )
        ));

        return $this;
    }

    /**
     * Prepare link for edit
     *
     * @param USWF_ParameterDispatch_Model_ParameterDispatch $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
