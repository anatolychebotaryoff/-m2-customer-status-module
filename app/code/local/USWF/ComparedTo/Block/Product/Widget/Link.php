<?php
/**
 * Link.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Link extends Lyonscg_ComparedTo_Block_Product_Widget_Link
    implements Mage_Widget_Block_Interface
{
    /**
     * Product Review Resource
     */
    protected $_reviewResource = '';

    /**
     * Initialize entity model
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_reviewResource = Mage::getResourceModel('review/review_collection');
    }

    protected function _prepareLayout() {
        Mage_Core_Block_Template::_prepareLayout();
        $jsCssBlock = Mage::app()->getLayout()->getBlock('foot') ?
            Mage::app()->getLayout()->getBlock('foot') : Mage::app()->getLayout()->getBlock('head');
        Mage::app()->getLayout()->removeOutputBlock('breadcrumbs');
        $jsCssBlock->addJs('varien/product.js');
        $jsCssBlock->addItem('skin_js', 'js/bundle.js');
        $jsCssBlock->addJs('itoris/groupedproductconfiguration/groupedproduct.js');
        $comparePage = Mage::registry('compare_page');
        if (isset($comparePage) && !$comparePage->isEmpty()) {
            $this->setData('active_tabs', $comparePage->getData('options_active_tabs'));
        }
        $this->setChild('compare-page-tabs',
            $this->getLayout()
                ->createBlock('uswf_comparedto/product_widget_tabs', '', array('widget' => $this))
        );
        $this->setChild(
            'compare-page-product-simple',
            $this->getLayout()->createBlock('uswf_comparedto/product_widget_product_type_simple')
        );
        $this->setChild(
            'compare-page-product-grouped',
            $this->getLayout()->createBlock('uswf_comparedto/product_widget_product_type_grouped')
        );
        $this->setChild(
            'compare-page-product-bundle',
            $this->getLayout()->createBlock('uswf_comparedto/product_widget_product_type_bundle')
        );
        return $this;
    }

    protected function _beforeToHtml() {
        /** @var USWF_ComparePage_Model_Compare_Widget $comparePage */
        $comparePage = Mage::registry('compare_page');
        if (isset($comparePage) && !$comparePage->isEmpty()) {
            $tier1Id = $comparePage->getParentProductId();
            $comparedProduct2 = $comparePage->getComparedProductByPos(2);
            if ($comparedProduct2) {
                $oemId = $comparedProduct2->getId();
            } else {
                $oemId = $tier1Id;
            }
            $tier1Product = Mage::getModel('catalog/product')->load($tier1Id);
            $oemProduct = Mage::getModel('catalog/product')->load($oemId);
            
            $attributes = $comparePage->getOptionsAttributes() ? explode(',', $comparePage->getOptionsAttributes()) : array();
            $tier1CustomName = trim($comparePage->getData('product_custom_name_option_1'));
            $oemCustomName = trim($comparePage->getData('product_custom_name_option_2'));

            $tier1YotpoReview = new Varien_Object();
            $detail = Mage::helper('uswf_comparepage')->getYotpoReviewDetail($tier1Product, $comparePage->getWebsiteId(),$comparePage->getData('review_id_option_1'));
            $tier1YotpoReview->addData(array(
                'detail' => trim($detail),
                'block_id' => trim($comparePage->getData('static_block_id_quality_icons_option_1'))
            ));
            $oemYotpoReview = new Varien_Object();
            $detail = Mage::helper('uswf_comparepage')->getYotpoReviewDetail($oemProduct, $comparePage->getWebsiteId(),$comparePage->getData('review_id_option_2'));
            $oemYotpoReview->addData(array(
                'detail' => trim($detail),
                'block_id' => trim($comparePage->getData('static_block_id_quality_icons_option_2'))
            ));
            $this->setData('display_sku',$comparePage->getData('options_display_sku'));
            $this->setData('ribbon_pos1',$comparePage->getData('ribbon_pos_option_1'));
            $this->setData('ribbon_pos2',$comparePage->getData('ribbon_pos_option_2'));
            $this->setData('details1',$comparePage->getData('details_option_1'));
            $this->setData('details2',$comparePage->getData('details_option_2'));
            $this->setData('compatibility1',$comparePage->getData('compatibility_option_1'));
            $this->setData('compatibility2',$comparePage->getData('compatibility_option_2'));
            $this->setData('label1',$comparePage->getData('title_bar_text_option_1'));
            $this->setData('label2',$comparePage->getData('title_bar_text_option_2'));
            $this->setData('tier_price_output',$comparePage->getData('options_tier_price_output'));
        } else {
            $tier1Id = $this->getCorrectId($this->getData('product1'), 'product');
            $oemId = $this->getCorrectId($this->getData('product2'), 'product');
            $tier1Product = Mage::getModel('catalog/product')->load($tier1Id);
            $oemProduct = Mage::getModel('catalog/product')->load($oemId);
            $attributes = $this->getAttributes() ? explode(',', $this->getAttributes()) : array();
            $tier1CustomName = trim($this->getData('product1_custom_name'));
            $oemCustomName = trim($this->getData('product2_custom_name'));

            $tier1YotpoReview = new Varien_Object();
            $yotpoStar = floatval(trim($this->getData('review_star_product1'))) > 5.0 ? 5.0: floatval(trim($this->getData('review_star_product1')));
            $tier1YotpoReview->addData(array(
                'star' => $yotpoStar,
                'count' => intval(trim($this->getData('review_count_product1'))),
                'detail' => trim($this->getData('review_detail_product1')),
                'block_id' => $this->getData('quality_icons_product1')
            ));
            $oemYotpoReview = new Varien_Object();
            $yotpoStar = floatval(trim($this->getData('review_star_product2'))) > 5.0 ? 5.0: floatval(trim($this->getData('review_star_product2')));
            $oemYotpoReview->addData(array(
                'star' => $yotpoStar,
                'count' => intval(trim($this->getData('review_count_product2'))),
                'detail' => trim($this->getData('review_detail_product2')),
                'block_id' => $this->getData('quality_icons_product2')
            ));
        }

        $tier1CustomName && $tier1Product->setName($tier1CustomName);
        $oemCustomName && $oemProduct->setName($oemCustomName);

        $tier1Options = $this->getData('options1') ? explode(',', $this->getData('options1')) : array();//-
        $oemOptions = $this->getData('options2') ? explode(',', $this->getData('options2')) : array();//-
        $tier1DefaultOption = $this->getData('default1');//-
        $oemDefaultOption = $this->getData('default2');//-

        if (!$tier1Product || !$oemProduct) {
            $products = array();
        } else {
            list($tier1LowestPrice, $tier1PkgQty, $tier1Prices) =
                Mage::helper('uswf_comparedto')->getPriceInfo($tier1Product);
            list($oemLowestPrice, $oemPkgQty, $oemPrices) =
                Mage::helper('uswf_comparedto')->getPriceInfo($oemProduct);
            $this->setData('tier1_is_saleable', $tier1Product->isSaleable());
            $this->setData('tier1_can_show_price', $tier1Product->getCanShowPrice());
            $this->setData('oem_prices', $oemPrices);
            $this->setData('attributes', $attributes);
            $this->setData('tier1_product', $tier1Product);
            $tier1Product//->setExtReview($tier1Review)
                ->setExtOptions($tier1Options)
                ->setExtDefaultOption($tier1DefaultOption)
                ->setExtAssociatedProducts(Mage::helper('uswf_comparedto')->getAssociatedProducts($tier1Product))
                ->setExtLabel($this->getData('label1'))
                ->setExtLowestPrice($tier1LowestPrice)
                ->setExtPkgQty($tier1PkgQty)
                ->setExtPrices($tier1Prices)
                ->setData('is_tier1', true)
                ->setYotpoReview($tier1YotpoReview);
            $oemProduct//->setExtReview($oemReview)
                ->setExtOptions($oemOptions)
                ->setExtDefaultOption($oemDefaultOption)
                ->setExtAssociatedProducts(Mage::helper('uswf_comparedto')->getAssociatedProducts($oemProduct))
                ->setExtLabel($this->getData('label2'))
                ->setExtLowestPrice($oemLowestPrice)
                ->setExtPkgQty($oemPkgQty)
                ->setExtPrices($oemPrices)
                ->setData('is_tier1', false)
                ->setYotpoReview($oemYotpoReview);;
            $products = !$this->getData('tier1_position') ?
                array(1 => $tier1Product, 2 => $oemProduct) : array(1 => $oemProduct, 2 => $tier1Product);
        }
        $this->setProducts($products);

        return $this;
    }

    /**
     * Returns product related html
     *
     * @param Mage_Catalog_Model_Product $product
     */
    public function getProductHtml($product) {
        return $this->getChild('compare-page-product-' . $product->getTypeId())
            ->setData('product', $product)
            ->setData('tier1_is_saleable', $this->getData('tier1_is_saleable'))
            ->setData('tier1_can_show_price', $this->getData('tier1_can_show_price'))
            ->setData('oem_prices', $this->getData('oem_prices'))
            ->setData('tier_price_output', $this->getData('tier_price_output'))
            ->toHtml();
    }

    /**
     * Returns yotpo html
     *
     * @param Mage_Catalog_Model_Product $product
     */
    public function getDummyReviewHtml($product) {
        $reviewBlock = $this->getLayout()->createBlock('core/template')
            ->setTemplate('catalog/product/widget/compare/product/review/dummy.phtml')
            ->setProduct($product);
        return $reviewBlock->toHtml();
    }

    /**
     * Retrieve is product available for sale
     *
     * @return array
     */
    public function getSaleableAssociatedProducts($product)
    {
        if ($product->isGrouped()) {
            $associatedProducts = $product->getTypeInstance(true)
                ->getAssociatedProducts($product);
            foreach ($associatedProducts as $key => $item) {
                if (!$item->isSaleable()) {
                    unset($associatedProducts[$key]);
                }
            }
            return $associatedProducts;
        }
    }
}