<?php

class USWF_AdminGridEnhancement_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid {


    public function __construct() {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _getCollectionClass() {
        return 'sales/order_grid_collection';
    }

    protected function _prepareCollection() {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
	$resource = Mage::getSingleton('core/resource');
        $collection->getSelect()->join(
            array('order' => $resource->getTableName('sales/order')),
           'main_table.entity_id = order.entity_id', array('order.customer_email')
        );
        $collection->getSelect()->join(
            array('billing' => $resource->getTableName('sales/order_address')),
            'order.billing_address_id = billing.entity_id',
            array('telephone')
        );
        $this->setCollection($collection);
	return $collection;
    }

    protected function _prepareColumns() {
        $this->addColumn('customer_email', array(
            'header'    =>  Mage::helper('sales')->__('Customer Email'),
            'index' => 'customer_email',
            'type'      => 'text'
        ));

        $this->addColumn('telephone', array(
            'header'    =>  Mage::helper('sales')->__('Billing Phone'),
            'index' => 'telephone',
            'type'      => 'text',
            'filter_index' => 'billing.telephone'
        ));

        return parent::_prepareColumns();
    }
}
