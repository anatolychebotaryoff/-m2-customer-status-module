<?php

class Sam_HardnessDatabase_Block_Adminhtml_Zipcodes_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    
    public function __construct()
    {
        parent::__construct();
        $this->setId('hardnessGrid');
        $this->setDefaultSort('hardness_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('hardness/hardness')->getCollection();
        /**
         * @var $collection Sam_HardnessDatabase_Model_Resource_Hardness_Collection
         */
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    
    protected function _prepareColumns()
    {
        $this->addColumn('zip_code', array(
            'header' => Mage::helper('hardness')->__('ZIP code'),
            'align'  => 'center',
            'index'  => 'zip_code'
        ));
        $this->addColumn('hardness_range', array(
            'header' => Mage::helper('hardness')->__('Range of Hardness'),
            'align'  => 'center',
            'index'  => 'hardness_range'
        ));
        $this->addColumn('primary_city', array(
            'header' => Mage::helper('hardness')->__('Primary City'),
            'align'  => 'center',
            'index'  => 'primary_city'
        ));
        $this->addColumn('secondary_cities', array(
            'header' => Mage::helper('hardness')->__('Secondary Cities'),
            'align'  => 'center',
            'index'  => 'secondary_cities'
        ));
        $this->addColumn('state', array(
            'header' => Mage::helper('hardness')->__('State'),
            'align'  => 'center',
            'index'  => 'state'
        ));
        $this->addColumn('county', array(
            'header' => Mage::helper('hardness')->__('County'),
            'align'  => 'center',
            'index'  => 'county'
        ));
        $this->addColumn('country', array(
            'header' => Mage::helper('hardness')->__('Country'),
            'align'  => 'center',
            'index'  => 'country'
        ));
        parent::_prepareColumns();
        return $this;
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('hardness_id');
        $this->getMassactionBlock()->setIdFieldName('hardness_id');
        $this->getMassactionBlock()
            ->addItem('delete',
                array(
                    'label' => Mage::helper('hardness')->__('Delete'),
                    'url' => $this->getUrl('*/*/massDelete'),
                    'confirm' => Mage::helper('hardness')->__('Are you sure?')
                )
            );
        
        return $this;
    }
    
    
    /**
     * Row click url
     *
     * @return string|void
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('hardness_id' => $row->getId()));
    }
    
    public function getGridUrl()
    {
        return $this->getCurrentUrl();
    }
}