<?php
/**
 * Bundle.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Product_Type_Bundle extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle
{
    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/widget/compare/product/type/bundle.phtml');
        $this->addRenderer('select', 'itoris_groupedproductconfiguration/product_bundle_options_select');
        return parent::_prepareLayout();
    }

    public function getOptionsNew($product)
    {
            $typeInstance = $product->getTypeInstance(true);
            $typeInstance->setStoreFilter($product->getStoreId(), $product);

            $optionCollection = $typeInstance->getOptionsCollection($product);

            $selectionCollection = $typeInstance->getSelectionsCollection(
                $typeInstance->getOptionsIds($product),
                $product
            );

            $_options = $optionCollection->appendSelections($selectionCollection, false,
                Mage::helper('catalog/product')->getSkipSaleableCheck()
            );

        return $_options;
    }

    public function getOptionHtmlNew($option, $product)
    {
        if (!isset($this->_optionRenderers[$option->getType()])) {
            return $this->__('There is no defined renderer for "%s" option type.', $option->getType());
        }
        $block = $this->getLayout()->createBlock($this->_optionRenderers[$option->getType()])
            ->setProduct($product)
            ->setOption($option);
        return $block->toHtml();
    }
}