<?php
/**
 * Featuredproducts.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Block_Featuredproducts extends Mage_Catalog_Block_Product_New
{

    /**
     * Initialize block's cache
     */
    protected function _construct()
    {
        $this->setProductsCount(Mage::helper('uswf_smartfit')->getFeaturedProductLimit());
        $this->setColumnCount(Mage::helper('uswf_smartfit')->getFeaturedColumnCount());
        $this->addPriceBlockType('bundle', 'bundle/catalog_product_price', 'bundle/catalog/product/price.phtml');
        parent::_construct();
    }
    
    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/featured.phtml');
        return parent::_prepareLayout();
    }

    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            'CATALOG_PRODUCT_FEATURED',
            Mage::app()->getStore()->getId(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            'template' => $this->getTemplate(),
            $this->getProductsCount()
        );
    }

    /**
     * Prepare collection with new products and applied page limits.
     *
     * return Mage_Catalog_Block_Product_New
     */
    protected function _beforeToHtml()
    {

        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
        $this->_addProductAttributesAndPrices($collection)
            ->addStoreFilter()
            ->addAttributeToFilter('uswf_featured', 1)
            ->setPageSize($this->getProductsCount())
            ->setCurPage(1);
        $collection->getSelect()->order(new Zend_Db_Expr('RAND()'));
        $this->setProductCollection($collection);
        return Mage_Catalog_Block_Product_Abstract::_beforeToHtml();
    }

    /**
     * Set how much product should be displayed at once.
     *
     * @param $count
     * @return Mage_Catalog_Block_Product_New
     */
    public function setProductsCount($count)
    {
        $this->_productsCount = $count;
        return $this;
    }

    /**
     * Get how much products should be displayed at once.
     *
     * @return int
     */
    public function getProductsCount()
    {
        if (null === $this->_productsCount) {
            $this->_productsCount = self::DEFAULT_PRODUCTS_COUNT;
        }
        return $this->_productsCount;
    }
}