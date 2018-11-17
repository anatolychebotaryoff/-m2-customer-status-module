<?php
/**
 * Replaced By Admin Panel Tab
 *
 * @category   Lyons
 * @package    Lyonscg_ReplacedBy
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_ReplacedBy_Block_Adminhtml_Catalog_Product_Edit_Tab_Replaced extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Related
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('replaced_product_grid');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product_link')->useReplacedLinks()
            ->getProductCollection()
            ->setProduct($this->_getProduct())
            ->addAttributeToSelect('*');

        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    public function getGridUrl()
    {
        return $this->getData('grid_url') ? $this->getData('grid_url') : $this->getUrl('*/*/replaced', array('_current' => true));
    }

    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('products_replaced', null);
        if (!is_array($products)) {
            $products = $this->_getProduct()->getReplacedProductIds();
        }
        return $products;
    }

    /**
     * Retrieve related products
     *
     * @return array
     */
    public function getSelectedReplaced()
    {
        $products = array();
        foreach (Mage::registry('current_product')->getReplacedProducts() as $product) {
            $products[$product->getId()] = array('position' => $product->getPosition());
        }
        return $products;
    }

}