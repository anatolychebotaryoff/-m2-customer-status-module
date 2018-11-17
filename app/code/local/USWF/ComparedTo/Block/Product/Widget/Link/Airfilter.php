<?php
/**
 * Airfilter.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Link_Airfilter extends USWF_ComparedTo_Block_Product_Widget_Link
    implements Mage_Widget_Block_Interface
{

    protected function _prepareLayout() {
        Mage_Core_Block_Template::_prepareLayout();
        $jsCssBlock = Mage::app()->getLayout()->getBlock('foot') ?
            Mage::app()->getLayout()->getBlock('foot') : Mage::app()->getLayout()->getBlock('head');
        $jsCssBlock->addJs('varien/product.js');
        $jsCssBlock->addItem('skin_js', 'js/bundle.js');
        $jsCssBlock->addJs('itoris/groupedproductconfiguration/groupedproduct.js');
        $this->setChild('compare-page-tabs',
            $this->getLayout()
                ->createBlock('uswf_comparedto/product_widget_tabs', '', array('widget' => $this))
        );
        $this->setChild(
            'compare-page-product-airfilter',
            $this->getLayout()->createBlock('uswf_comparedto/product_widget_product_airfilter')
        );
        return $this;
    }

    protected function _beforeToHtml() {
        $tier1Merv1Id = $this->getCorrectId($this->getData('product1_merv1'), 'product');
        $tier1Merv2Id = $this->getCorrectId($this->getData('product1_merv2'), 'product');
        $tier1Merv3Id = $this->getCorrectId($this->getData('product1_merv3'), 'product');
        $oemMerv1Id = $this->getCorrectId($this->getData('product2_merv1'), 'product');
        $oemMerv2Id = $this->getCorrectId($this->getData('product2_merv2'), 'product');
        $oemMerv3Id = $this->getCorrectId($this->getData('product2_merv3'), 'product');
        $attributes = $this->getAttributes() ? explode(',', $this->getAttributes()) : array();
        $quantity = $this->getData('quantity') > 0 ? $this->getData('quantity') : 1;
        $tier1CustomName = trim($this->getData('product1_custom_name'));
        $oemCustomName = trim($this->getData('product2_custom_name'));

        $tier1Products = array();
        foreach (array($tier1Merv1Id, $tier1Merv2Id, $tier1Merv3Id) as $id) {
            $product = Mage::getModel('catalog/product')->load($id);
            Mage::getModel('review/review')->getEntitySummary($product, Mage::app()->getStore()->getId());
            $tier1Products[] = $product;
        }
        $tier1Product = reset($tier1Products);
        $tier1CustomName && $tier1Product->setName($tier1CustomName);
        $oemProducts = array();
        foreach (array($oemMerv1Id, $oemMerv2Id, $oemMerv3Id) as $id) {
            $product = Mage::getModel('catalog/product')->load($id);
            Mage::getModel('review/review')->getEntitySummary($product, Mage::app()->getStore()->getId());
            $oemProducts[] = $product;
        }
        $oemProduct = reset($oemProducts);
        $oemCustomName && $oemProduct->setName($oemCustomName);

        $tier1ReviewId = $this->getCorrectId($this->getData('review1'), 'review');
        $oemReviewId = $this->getCorrectId($this->getData('review2'), 'review');
        $this->_reviewResource->addFieldToFilter(
            'main_table.review_id', array('in' => array($tier1ReviewId, $oemReviewId))
        )
            ->addRateVotes();
        $tier1Review = $this->_reviewResource->getItemById($tier1ReviewId);
        $oemReview = $this->_reviewResource->getItemById($oemReviewId);

        if (!$tier1Product || !$oemProduct) {
            $products = array();
        } else {
            $tier1Products = Mage::helper('uswf_comparedto')->mapProductsMerv($tier1Products, $quantity);
            $oemProducts = Mage::helper('uswf_comparedto')->mapProductsMerv($oemProducts, $quantity);
            list($minTier1Price, $tier1Prices) =
                Mage::helper('uswf_comparedto')->getProductsMervPriceInfo($tier1Products, $quantity);
            list($minOemPrice, $oemPrices) =
                Mage::helper('uswf_comparedto')->getProductsMervPriceInfo($oemProducts, $quantity);
            $this->setData('attributes', $attributes);
            $this->setData('tier1_product', $tier1Product);
            $this->setData('oem_prices', $oemPrices);
            $tier1Product->setExtReview($tier1Review)
                ->setExtQuantity($quantity)
                ->setExtLabel($this->getData('label1'))
                ->setExtPrices($tier1Prices)
                ->setExtLowestPrice($minTier1Price)
                ->setExtPkgQty($quantity)
                ->setData('is_tier1', true)
                ->setMervItems($tier1Products);
            $oemProduct->setExtReview($oemReview)
                ->setExtQuantity($quantity)
                ->setExtLabel($this->getData('label2'))
                ->setExtPrices($oemPrices)
                ->setExtLowestPrice($minOemPrice)
                ->setExtPkgQty($quantity)
                ->setData('is_tier1', false)
                ->setMervItems($oemProducts);
            $products = !$this->getData('tier1_position') ?
                array(1 => $tier1Product, 2 => $oemProduct) : array(1 => $oemProduct, 2 => $tier1Product);
        }
        $this->setProducts($products);
        $this->setAirfilters(true);

        return $this;
    }

    /**
     * Returns product related html
     *
     * @param Mage_Catalog_Model_Product $product
     */
    public function getProductHtml($product) {
        return $this->getChild('compare-page-product-airfilter')
            ->setData('product', $product)
            ->setData('tier1_products', $this->getData('tier1_product')->getMervItems())
            ->setData('tier1_product', $this->getData('tier1_product'))
            ->setData('oem_prices', $this->getData('oem_prices'))
            ->toHtml();
    }
}