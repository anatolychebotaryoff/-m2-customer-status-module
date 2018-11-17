<?php
/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */
class MageWorx_SeoSuite_Helper_Richsnippet extends Mage_Core_Helper_Abstract
{
    const XML_PATH_PRODUCT_OG_ENABLED               = 'mageworx_seo/richsnippets/product_og_enabled';

    const XML_PATH_RICHSNIPPET_ENABLED              = 'mageworx_seo/richsnippets/enable';
    const XML_PATH_RICHSNIPPET_SELLER_ENABLED       = 'mageworx_seo/richsnippets/enable_seller';
    const XML_PATH_RICHSNIPPET_SKU_ENABLED          = 'mageworx_seo/richsnippets/enable_sku';
    const XML_PATH_RICHSNIPPET_SKU_CODE             = 'mageworx_seo/richsnippets/attribute_code_sku';
    const XML_PATH_RICHSNIPPET_PAYMENT_ENABLED      = 'mageworx_seo/richsnippets/enable_payment';
    const XML_PATH_RICHSNIPPET_DELIVERY_ENABLED     = 'mageworx_seo/richsnippets/enable_delivery';
    const XML_PATH_RICHSNIPPET_COLOR_ENABLED        = 'mageworx_seo/richsnippets/enable_color';
    const XML_PATH_RICHSNIPPET_COLOR_CODE           = 'mageworx_seo/richsnippets/attribute_code_color';
    const XML_PATH_RICHSNIPPET_HEIGHT_ENABLED       = 'mageworx_seo/richsnippets/enable_height';
    const XML_PATH_RICHSNIPPET_HEIGHT_CODE          = 'mageworx_seo/richsnippets/attribute_code_height';
    const XML_PATH_RICHSNIPPET_WIDTH_ENABLED        = 'mageworx_seo/richsnippets/enable_width';
    const XML_PATH_RICHSNIPPET_WIDTH_CODE           = 'mageworx_seo/richsnippets/attribute_code_width';
    const XML_PATH_RICHSNIPPET_DEPTH_ENABLED        = 'mageworx_seo/richsnippets/enable_depth';
    const XML_PATH_RICHSNIPPET_DEPTH_CODE           = 'mageworx_seo/richsnippets/attribute_code_depth';
    const XML_PATH_RICHSNIPPET_WEIGHT_ENABLED       = 'mageworx_seo/richsnippets/enable_weight';
    const XML_PATH_RICHSNIPPET_WEIGHT_UNIT          = 'mageworx_seo/richsnippets/weight_unit';
    const XML_PATH_RICHSNIPPET_MANUFACTURER_ENABLED = 'mageworx_seo/richsnippets/enable_manufacturer';
    const XML_PATH_RICHSNIPPET_MANUFACTURER_CODE    = 'mageworx_seo/richsnippets/attribute_code_manufacturer';
    const XML_PATH_RICHSNIPPET_BRAND_ENABLED        = 'mageworx_seo/richsnippets/enable_brand';
    const XML_PATH_RICHSNIPPET_BRAND_CODE           = 'mageworx_seo/richsnippets/attribute_code_brand';
    const XML_PATH_RICHSNIPPET_MODEL_ENABLED        = 'mageworx_seo/richsnippets/enable_model';
    const XML_PATH_RICHSNIPPET_MODEL_CODE           = 'mageworx_seo/richsnippets/attribute_code_model';
    const XML_PATH_RICHSNIPPET_GTIN_ENABLED         = 'mageworx_seo/richsnippets/enable_gtin';
    const XML_PATH_RICHSNIPPET_GTIN_CODE            = 'mageworx_seo/richsnippets/attribute_code_gtin';
    const XML_PATH_RICHSNIPPET_DIMENSIONS_ENABLED   = 'mageworx_seo/richsnippets/enable_dimensions';
    const XML_PATH_RICHSNIPPET_DIMENSIONS_UNIT      = 'mageworx_seo/richsnippets/dimensions_unit';
    const XML_PATH_RICHSNIPPET_CONDITION_ENABLED    = 'mageworx_seo/richsnippets/enable_condition';
    const XML_PATH_RICHSNIPPET_CONDITION_CODE       = 'mageworx_seo/richsnippets/attribute_code_condition';
    const XML_PATH_RICHSNIPPET_CONDITION_NEW        = 'mageworx_seo/richsnippets/condition_value_new';
    const XML_PATH_RICHSNIPPET_CONDITION_REF        = 'mageworx_seo/richsnippets/condition_value_refurbished';
    const XML_PATH_RICHSNIPPET_CONDITION_USED       = 'mageworx_seo/richsnippets/condition_value_used';
    const XML_PATH_RICHSNIPPET_CONDITION_DAMAGED    = 'mageworx_seo/richsnippets/condition_value_damaged';
    const XML_PATH_RICHSNIPPET_CONDITION_DEFAULT    = 'mageworx_seo/richsnippets/condition_value_default';
    const XML_PATH_RICHSNIPPET_CATEGORY_ENABLED     = 'mageworx_seo/richsnippets/enable_category';
    const XML_PATH_RICHSNIPPET_CATEGORY_DEEPEST     = 'mageworx_seo/richsnippets/category_deepest';

    function isOpenGraphProtocolEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_PRODUCT_OG_ENABLED);
    }


    function isRichsnippetEnabled()
    {
        if ((int) Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_ENABLED) === 1) {
            return true;
        }
        return false;
    }

    function isRichSnippetOnlyBreadcrumbsEnabled()
    {
        if ($this->isRichsnippetEnabled()) {
            return true;
        }
        else {
            if ((int) Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_ENABLED) === 2) {
                return true;
            }
        }
        return false;
    }

    function isRichsnippetDisabled()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_ENABLED) == false) {
            return true;
        }
        return false;
    }

    function isRichsnippetCategoryEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_CATEGORY_ENABLED);
    }

    function isRichsnippetCategoryDeepest()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_CATEGORY_DEEPEST);
    }

    function isRichsnippetSellerEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_SELLER_ENABLED);
    }

    function isRichsnippetConditionEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_CONDITION_ENABLED);
    }

    function getSkuAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_SKU_CODE));
    }

    function getConditionAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_CONDITION_CODE));
    }

    function getConditionValueForNew()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_CONDITION_NEW));
    }

    function getConditionValueForRefurbished()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_CONDITION_REF));
    }

    function getConditionValueForDamaged()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_CONDITION_DAMAGED));
    }

    function getConditionValueForUsed()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_CONDITION_USED));
    }

    function getConditionDefaultValue()
    {
        return Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_CONDITION_DEFAULT);
    }

    function isRichsnippetSkuEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_SKU_ENABLED);
    }

    function isRichsnippetPaymentEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_PAYMENT_ENABLED);
    }

    function isRichsnippetDeliveryEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_DELIVERY_ENABLED);
    }

    function isRichsnippetColorEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_COLOR_ENABLED);
    }

    function getColorAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_COLOR_CODE));
    }

    function isRichsnippetManufacturerEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_MANUFACTURER_ENABLED);
    }

    function getManufacturerAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_MANUFACTURER_CODE));
    }

    function isRichsnippetBrandEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_BRAND_ENABLED);
    }

    function getBrandAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_BRAND_CODE));
    }

    function isRichsnippetModelEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_MODEL_ENABLED);
    }

    function getModelAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_MODEL_CODE));
    }

    function isRichsnippetGtinEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_GTIN_ENABLED);
    }

    function getGtinAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_GTIN_CODE));
    }

    function isRichsnippetDimensionsEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_DIMENSIONS_ENABLED);
    }

    function getRichsnippetDimensionsUnit()
    {
        $unit = trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_DIMENSIONS_UNIT));
        if (preg_match('/^[a-zA-Z]+$/', $unit)) {
            return $unit;
        }
        return false;
    }

    function isRichsnippetHeightEnabled()
    {
        if ($this->isRichsnippetDimensionsEnabled()) {
            return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_HEIGHT_ENABLED);
        }
        return false;
    }

    function getHeightAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_HEIGHT_CODE));
    }

    function isRichsnippetWidthEnabled()
    {
        if ($this->isRichsnippetDimensionsEnabled()) {
            return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_WIDTH_ENABLED);
        }
        return false;
    }

    function getWidthAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_WIDTH_CODE));
    }

    function isRichsnippetDepthEnabled()
    {
        if ($this->isRichsnippetDimensionsEnabled()) {
            return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_DEPTH_ENABLED);
        }
        return false;
    }

    function getDepthAttributeCode()
    {
        return trim(Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_DEPTH_CODE));
    }

    function isRichsnippetWeightEnabled()
    {
        return (bool) Mage::getStoreConfigFlag(self::XML_PATH_RICHSNIPPET_WEIGHT_ENABLED);
    }

    function getRichsnippetWeightUnit()
    {
        return (string) Mage::getStoreConfig(self::XML_PATH_RICHSNIPPET_WEIGHT_UNIT);
    }

    function isProductPage()
    {
        if (strpos(Mage::app()->getRequest()->getRequestUri(), 'catalog/product/view') === false) {
            return false;
        }
        return true;
    }

    function getDefaultPrices($_product = null)
    {
        if (!$_product) {
            $_product = Mage::registry('current_product');
        }

        $_weeeHelper = Mage::helper('weee');
        $_taxHelper  = Mage::helper('tax');
        /* @var $_coreHelper Mage_Core_Helper_Data */
        /* @var $_weeeHelper Mage_Weee_Helper_Data */
        /* @var $_taxHelper Mage_Tax_Helper_Data */

        $_storeId           = $_product->getStoreId();
        $_simplePricesTax   = ($_taxHelper->displayPriceIncludingTax() || $_taxHelper->displayBothPrices());
        $_minimalPriceValue = $_product->getMinimalPrice();
        $_minimalPrice      = $_taxHelper->getPrice($_product, $_minimalPriceValue, $_simplePricesTax);
        $prices             = array();


        if (!$_product->isGrouped()):
            $_weeeTaxAmount = $_weeeHelper->getAmountForDisplay($_product);
            if ($_weeeHelper->typeOfDisplay($_product,
                    array(Mage_Weee_Model_Tax::DISPLAY_INCL_DESCR, Mage_Weee_Model_Tax::DISPLAY_EXCL_DESCR_INCL,
                    4))):
                $_weeeTaxAmount = $_weeeHelper->getAmount($_product);
            endif;
            $_weeeTaxAmountInclTaxes = $_weeeTaxAmount;
            if ($_weeeHelper->isTaxable() && !$_taxHelper->priceIncludesTax($_storeId)):
                $_attributes             = $_weeeHelper->getProductWeeeAttributesForRenderer($_product, null, null,
                    null, true);
                $_weeeTaxAmountInclTaxes = $_weeeHelper->getAmountInclTaxes($_attributes);
            endif;

            $_price             = $_taxHelper->getPrice($_product, $_product->getPrice());
            $_regularPrice      = $_taxHelper->getPrice($_product, $_product->getPrice(), $_simplePricesTax);
            $_finalPrice        = $_taxHelper->getPrice($_product, $_product->getFinalPrice());
            $_finalPriceInclTax = $_taxHelper->getPrice($_product, $_product->getFinalPrice(), true);
            if ($_finalPrice >= $_price):
                if ($_taxHelper->displayBothPrices()):
                    if ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 0)): // including
                        $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                        $prices[] = $_price + $_weeeTaxAmount;
                    elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 1)): // incl. + weee
                        $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                        $prices[] = $_price + $_weeeTaxAmount;
                    elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 4)): // incl. + weee
                        $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                        $prices[] = $_price + $_weeeTaxAmount;
                    elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 2)): // excl. + weee + final
                        $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                        $prices[] = $_price;
                    else:
                        $prices[] = $_finalPriceInclTax;
                        if ($_finalPrice == $_price):
                            $prices[] = $_price;
                        else:
                            $prices[] = $_finalPrice;
                        endif;
                    endif;
                else:
                    if ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 0)): // including
                        $prices[] = $_price + $_weeeTaxAmount;
                    elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 1)): // incl. + weee
                        $prices[] = $_price + $_weeeTaxAmount;
                    elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 4)): // incl. + weee
                        $prices[] = $_price + $_weeeTaxAmount;
                    elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 2)): // excl. + weee + final
                        $prices[] = $_price;
                        $prices[] = $_price + $_weeeTaxAmount;
                    else:
                        if ($_finalPrice == $_price):
                            $prices[] = $_price;
                        else:
                            $prices[] = $_finalPrice;
                        endif;
                    endif;
                endif;
            else: /* if ($_finalPrice == $_price): */
                $_originalWeeeTaxAmount = $_weeeHelper->getOriginalAmount($_product);

                if ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 0)): // including
                    if ($_taxHelper->displayBothPrices()):
                        $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                        $prices[] = $_finalPrice + $_weeeTaxAmount;
                    else:
                        $prices[] = $_finalPrice + $_weeeTaxAmountInclTaxes;
                    endif;
                    $prices[] = $_regularPrice + $_originalWeeeTaxAmount;
                elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 1)): // incl. + weee
                    $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                    $prices[] = $_finalPrice + $_weeeTaxAmount;
                    $prices[] = $_regularPrice + $_originalWeeeTaxAmount;
                elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 4)): // incl. + weee
                    $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                    $prices[] = $_finalPrice + $_weeeTaxAmount;
                    $prices[] = $_regularPrice + $_originalWeeeTaxAmount;
                elseif ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, 2)): // excl. + weee + final
                    $prices[] = $_finalPriceInclTax + $_weeeTaxAmountInclTaxes;
                    $prices[] = $_finalPrice;
                    $prices[] = $_regularPrice;
                else: // excl.
                    if ($_taxHelper->displayBothPrices()):
                        $prices[] = $_finalPriceInclTax;
                    else:
                        $prices[] = $_finalPrice;
                    endif;
                    $prices[] = $_regularPrice;
                endif;

            endif; /* if ($_finalPrice == $_price): */

            if ($_minimalPriceValue && $_minimalPriceValue < $_product->getFinalPrice()):

                $_minimalPriceDisplayValue = $_minimalPrice;
                if ($_weeeTaxAmount && $_weeeHelper->typeOfDisplay($_product, array(0, 1, 4))):
                    $_minimalPriceDisplayValue = $_minimalPrice + $_weeeTaxAmount;
                endif;
                $prices[] = $_minimalPriceDisplayValue;
            endif; /* if ($block->getDisplayMinimalPrice() && $_minimalPrice && $_minimalPrice < $_finalPrice): */

        else: /* if (!$_product->isGrouped()): */

            $_exclTax = $_taxHelper->getPrice($_product, $_minimalPriceValue);
            $_inclTax = $_taxHelper->getPrice($_product, $_minimalPriceValue, true);

            if ($_minimalPriceValue):
                if ($_taxHelper->displayBothPrices()):
                    $prices[] = $_inclTax;
                    $prices[] = $_exclTax;
                else:
                    $_showPrice = $_inclTax;
                    if (!$_taxHelper->displayPriceIncludingTax()) {
                        $_showPrice = $_exclTax;
                    }

                    $prices[] = $_showPrice;
                endif;
            endif; /* if ($block->getDisplayMinimalPrice() && $_minimalPrice): */
        endif; /* if (!$_product->isGrouped()): */

        return $prices;
    }

    /**
     * @return array
     */
    function getBundlePrices($_product = null)
    {
        if (!$_product) {
            $_product = Mage::registry('current_product');
        }

//        Mage_Bundle_Block_Catalog_Product_Price

        $prices      = array();
        $_priceModel = $_product->getPriceModel();

        if(is_callable(array($_priceModel, 'getPricesDependingOnTax'))){
        	list($_minimalPriceTax, $_maximalPriceTax) = $_priceModel->getPricesDependingOnTax($_product, null, null, false);
        	list($_minimalPriceInclTax, $_maximalPriceInclTax) = $_priceModel->getPricesDependingOnTax($_product, null, true, false);
        }else{
            list($_minimalPrice, $_maximalPrice) = $_product->getPriceModel()->getPrices($_product);
			$_maximalPriceTax = $_minimalPriceTax = Mage::helper('tax')->getPrice($_product, $_minimalPrice);
			$_maximalPriceInclTax = $_minimalPriceInclTax = Mage::helper('tax')->getPrice($_product, $_minimalPrice, true);
        }

        $_weeeTaxAmount = 0;

        if ($_product->getPriceType() == 1) {
            $_weeeTaxAmount          = Mage::helper('weee')->getAmount($_product);
            $_weeeTaxAmountInclTaxes = $_weeeTaxAmount;
            if (Mage::helper('weee')->isTaxable()) {
                $_attributes             = Mage::helper('weee')->getProductWeeeAttributesForRenderer($_product, null,
                    null, null, true);
                $_weeeTaxAmountInclTaxes = Mage::helper('weee')->getAmountInclTaxes($_attributes);
            }
            if ($_weeeTaxAmount && Mage::helper('weee')->typeOfDisplay($_product, array(0, 1, 4))) {
                $_minimalPriceTax += $_weeeTaxAmount;
                $_minimalPriceInclTax += $_weeeTaxAmountInclTaxes;
            }
            if ($_weeeTaxAmount && Mage::helper('weee')->typeOfDisplay($_product, 2)) {
                $_minimalPriceInclTax += $_weeeTaxAmountInclTaxes;
            }
        }

        if ($_product->getPriceView()):
            if ($this->_displayBothPrices($_product)):
                $prices[] = $_minimalPriceInclTax;
                $prices[] = $_minimalPriceTax;
            else:
                $prices[] = $_minimalPriceTax;
                if (Mage::helper('weee')->typeOfDisplay($_product, 2) && $_weeeTaxAmount):
                    $prices[] = $_minimalPriceInclTax;
                endif;
            endif;
        else:
            if ($_minimalPriceTax <> $_maximalPriceTax):
                if ($this->_displayBothPrices($_product)):
                    $prices[] = $_minimalPriceInclTax;
                    $prices[] = $_minimalPriceTax;
                else:
                    $prices[] = $_minimalPriceTax;
                    if (Mage::helper('weee')->typeOfDisplay($_product, 2) && $_weeeTaxAmount):
                        $prices[] = $_minimalPriceInclTax;
                    endif;
                endif;

                if ($_product->getPriceType() == 1) {
                    if ($_weeeTaxAmount && Mage::helper('weee')->typeOfDisplay($_product, array(0, 1, 4))) {
                        $_maximalPriceTax += $_weeeTaxAmount;
                        $_maximalPriceInclTax += $_weeeTaxAmountInclTaxes;
                    }
                    if ($_weeeTaxAmount && Mage::helper('weee')->typeOfDisplay($_product, 2)) {
                        $_maximalPriceInclTax += $_weeeTaxAmountInclTaxes;
                    }
                }

                if ($this->_displayBothPrices($_product)):
                    $prices[] = $_maximalPriceInclTax;
                    $prices[] = $_maximalPriceTax;
                else:
                    $prices[] = $_maximalPriceTax;
                    if (Mage::helper('weee')->typeOfDisplay($_product, 2) && $_weeeTaxAmount):
                        $prices[] = $_maximalPriceInclTax;
                    endif;
                endif;
            else:
                if ($this->_displayBothPrices($_product)):
                    $prices[] = $_minimalPriceInclTax;
                    $prices[] = $_minimalPriceTax;
                else:
                    $prices[] = $_minimalPriceTax;
                    if (Mage::helper('weee')->typeOfDisplay($_product, 2) && $_weeeTaxAmount):
                        $prices[] = $_minimalPriceInclTax;
                    endif;
                endif;
            endif;
        endif;

        return $prices;
    }

    public function getGroupedPrices($product = null)
    {
        if (!$product) {
            $product = Mage::registry('current_product');
        }
        $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);

        if (count($associatedProducts)) {
            $allProductPrices = array();
            foreach ($associatedProducts as $product) {
                $productPrices                                = $this->getDefaultPrices($product);
                $allProductPrices[(string) $productPrices[0]] = $productPrices;
            }
            if (count($allProductPrices)) {
                ksort($allProductPrices);
                return array_shift($allProductPrices);
            }
        }
        return $this->getDefaultPrices();
    }

    protected function _displayBothPrices($_product)
    {
    	if(is_callable(array($_product->getPriceModel(), 'getIsPricesCalculatedByIndex'))){
    		if ($_product->getPriceType() == Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC
            	&& $_product->getPriceModel()->getIsPricesCalculatedByIndex() !== false) {
            	return false;
        	}
        	return Mage::helper('tax')->displayBothPrices();
    	}else{
    		return false;
    	}
    }

    public function getAttributeValueByCode($product, $attribute)
    {
        $tempValue = '';
        $value     = $product->getData($attribute);
        if ($_attr     = $product->getResource()->getAttribute($attribute)) {
            $_attr->setStoreId($product->getStoreId());
            $tempValue = $_attr->setStoreId($product->getStoreId())->getSource()->getOptionText($product->getData($attribute));
        }
        if ($tempValue) {
            $value = $tempValue;
        }
        if (!$value) {
            if ($product->getTypeId() == 'configurable') {
                $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
                $attributeOptions        = array();
                foreach ($productAttributeOptions as $productAttribute) {
                    if ($productAttribute['attribute_code'] == $attribute) {
                        foreach ($productAttribute['values'] as $attribute) {
                            $attributeOptions[] = $attribute['store_label'];
                        }
                    }
                }
                if (count($attributeOptions) == 1) {
                    $value = array_shift($attributeOptions);
                }
            }
            else {
                $value = $product->getData($attribute);
            }
        }
        return trim($value);
//        if (is_array($value)) $value = implode(' ', $value);
    }

}
