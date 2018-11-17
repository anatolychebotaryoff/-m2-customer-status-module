<?php

class USWF_PreviewCart_Helper_Data extends Mage_Core_Helper_Abstract {

    const XML_PATH_SEOSUITE_NOINDEX = 'mageworx_seo/seosuite/noindex_nofollow_pages_user';
    const XML_PATH_PREVIEWCART_FRONTNAME = 'frontend/routers/uswf_previewcart/args/frontName';
    const XML_PATH_PREVIEWCART_ACTIVE = 'uswf_previewcart/general/active';
    const XML_PATH_UPSELL_PRODUCT = 'uswf_previewcart/general/upsell_product';
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