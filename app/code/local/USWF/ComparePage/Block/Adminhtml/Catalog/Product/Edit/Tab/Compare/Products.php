<?php

/**
 * ComparedProducts products admin grid
 */
class USWF_ComparePage_Block_Adminhtml_Catalog_Product_Edit_Tab_Compare_Products extends Mage_Adminhtml_Block_Widget_Grid
{
    const NAME_ID_COMPARED_PRODUCT_GRID = 'compared_product_grid';
    protected $selectedComparedProducts;

    /**
     * Set grid params
     *
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->setId(self::NAME_ID_COMPARED_PRODUCT_GRID);
        
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
        if ($this->_getProduct()->getId()) {
            $this->setDefaultFilter(array('in_products'=>1));
        }
        if ($this->isReadonly()) {
            $this->setFilterVisibility(false);
        }
    }

    /**
     * Retirve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return USWF_ComparePage_Block_Adminhtml_Catalog_Product_Edit_Tab_Compare_Products
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField('websites',
                    'catalog/product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left');
            }
        }
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            } else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Checks when this block is readonly
     *
     * @return boolean
     */
    public function isReadonly()
    {
        return $this->_getProduct()->getUpsellReadonly();
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product_link')
            ->setLinkTypeId(USWF_ComparePage_Model_Compare_Widget::LINK_TYPE_COMPARE)
            ->getProductCollection()
            ->setProduct($this->_getProduct())
            ->addAttributeToSelect('*');

        if ($this->isReadonly()) {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = array(0);
            }
            $collection->addFieldToFilter('entity_id', array('in'=>$productIds));
        }

        $this->setCollection($collection);
        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        //if (!$this->_getProduct()->getUpsellReadonly()) {
        if (1) {
            $this->addColumn('in_products', array(
                'header_css_class' => 'a-center',
                'type'      => 'checkbox',
                'name'      => 'in_products',
                'values'    => $this->_getSelectedProducts(),
                'align'     => 'center',
                'index'     => 'entity_id'
            ));
        }

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id'
        ));
        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('type', array(
            'header'    => Mage::helper('catalog')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name', array(
            'header'    => Mage::helper('catalog')->__('Attrib. Set Name'),
            'width'     => 90,
            'index'     => 'attribute_set_id',
            'type'      => 'options',
            'options'   => $sets,
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('catalog')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('visibility', array(
            'header'    => Mage::helper('catalog')->__('Visibility'),
            'width'     => 90,
            'index'     => 'visibility',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => 80,
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'        => Mage::helper('catalog')->__('Price'),
            'type'          => 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'         => 'price',
            'width'     => 30,
        ));

        $websiteOption = array();
        foreach (Mage::getModel('core/website')->getCollection()->toOptionHash() as $key => $value) {
            $websiteOption[$key] = $value.'(Id:'.$key.')';
        }
        $this->addColumn('websites',
            array(
                'header'=> Mage::helper('catalog')->__('Websites'),
                'width' => '100px',
                'sortable'  => false,
                'index'     => 'websites',
                'type'      => 'options',
                'options'   => $websiteOption,
            ));

        $this->addColumn('compared_position', array(
            'header'            => Mage::helper('catalog')->__('Position'),
            'name'              => 'compared_position',
            'type'              => 'number',
            'width'             => 30,
            'validate_class'    => 'validate-number',
            'index'             => 'compared_position',
            'editable'          => 'true',
            'edit_only'         => !$this->_getProduct()->getId()
        ));

        $this->addColumn('compared_website_id', array(
            'header'            => Mage::helper('catalog')->__('Website Ids'),
            'name'              => 'compared_website_id',
            'width'             => 30,
            'index'             => 'compared_website_id',
            'editable'          => 'true',
            'edit_only'         => !$this->_getProduct()->getId()
        ));

        $this->addColumn('actions', array(
            'header'    => $this->helper('catalog')->__('Action'),
            'width'     => 15,
            'sortable'  => false,
            'filter'    => false,
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption' => $this->helper('catalog')->__('Edit'),
                    'url'     => array('base'=>'*/*/edit'),
                    'field'   => 'id'
                )
            ),
        ));

        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/comparedProductsGrid', array('_current'=>true));
    }

    /**
     * Retrieve selected upsell products
     *
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = array_keys($this->getSelectedComparedProducts());
        return $products;
    }

    /**
     * Retrieve compared products
     *
     * @return array
     */
    public function getSelectedComparedProducts()
    {
        if (is_null($this->selectedComparedProducts)) {
            $element = $this->getElement();
            if (!is_null($element)) {
                /** @var USWF_ComparePage_Model_Compare_Widget $comparePage */
                $comparePage = $this->getElement()->getForm()->getDataObject();
            } else {
                $storeId = (int)Mage::app()->getRequest()->getParam('store');
                /** @var USWF_ComparePage_Model_Compare_Widget $comparePage */
                $comparePage = Mage::getModel('uswf_comparepage/compare_widget')->loadByProductId($this->_getProduct()->getId(), $storeId);
            }

            $comparedProducts = $comparePage->getComparedProducts();
            $products = array();
            foreach ($comparedProducts as $product) {
                $products[$product->getId()] = array(
                    'compared_position' => $product->getComparedPosition(),
                    'compared_website_id' => $product->getComparedWebsiteId());
            }
            $this->selectedComparedProducts = $products;
        }

        return $this->selectedComparedProducts;
    }
}
