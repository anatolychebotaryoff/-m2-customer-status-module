<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Helper_Data extends Mage_Catalog_Helper_Data
{

    const CONFIG_PATH_TIER1_TITLE_BAR_TEXT = 'uswf_comparedto/config/tier1_title_bar_text';
    const CONFIG_PATH_TOP_HOR_BANNER_IMAGE = 'uswf_comparedto/images/top_hor_banner';
    const CONFIG_PATH_TIER1_RIBBON_IMAGE_TMPL = 'uswf_comparedto/images/tier1_ribbon_';
    const CONFIG_PATH_OEM_RIBBON_IMAGE_TMPL = 'uswf_comparedto/images/oem_ribbon_';
    const CONFIG_PATH_FAQ_TAB_HEADER_TEXT = 'uswf_comparedto/tabs/faq_header';
    const CONFIG_PATH_FAQ_TAB_HEADER_IMAGE = 'uswf_comparedto/tabs/faq_header_image';
    const CONFIG_PATH_FAQ_TAB_QUESTION_TMPL = 'uswf_comparedto/tabs/faq_line_question_';
    const CONFIG_PATH_FAQ_TAB_ANSWER_TMPL = 'uswf_comparedto/tabs/faq_line_answer_';
    const CONFIG_COMPAREDTO_MEDIA_POSTFIX = 'comparedto/';
    const CONFIG_PATH_BOTTOM_BANNER_IMAGE = 'uswf_comparedto/images/bottom_banner';
    const CONFIG_BOTTOM_BANNER_ENABLED = 'uswf_comparedto/images/bottom_banner_enabled';

    protected $tier1ProductParamNames = array('product1', 'product1_merv1', 'product1_merv2', 'product1_merv3');
    protected $oemProductParamNames = array('product2', 'product2_merv1', 'product2_merv2', 'product2_merv3');

    /**
     * Returns prices for simple/grouped product
     *
     * @param Mage_Catalog_Model_Product
     * @return array($lowestPrice, $pkgQty, $prices)
     */
    public function getPriceInfo($product) {
        $lowestPrice = 0;
        $pkgQty = 0;
        $prices = array();
        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
            $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);

            if (count($associatedProducts) > 0) {
                foreach($associatedProducts as $_item) {
                    $prices[$_item->getPackageQty()] = $_item->getFinalPrice();
                    if ($lowestPrice == 0) {
                        if ($_item->getPackageQty() > 1) {
                            $lowestPrice = $_item->getFinalPrice() / $_item->getPackageQty();
                            $pkgQty = $_item->getPackageQty();
                        } else {
                            $lowestPrice = $_item->getFinalPrice();
                            $pkgQty = $_item->getPackageQty();
                        }
                    } elseif ($_item->getPackageQty() > 1) {
                        $_itemPrice = $_item->getFinalPrice() / $_item->getPackageQty();
                        $pkgQty = ($_itemPrice < $lowestPrice ? $_item->getPackageQty() : $pkgQty);
                        $lowestPrice = ($_itemPrice < $lowestPrice ? $_itemPrice : $lowestPrice);
                    } else {
                        $pkgQty = ($_item->getFinalPrice() < $lowestPrice ? $_item->getPackageQty() : $pkgQty);
                        $lowestPrice = ($_item->getFinalPrice() < $lowestPrice ? $_item->getFinalPrice() : $lowestPrice);
                    }
                }
            }
        } elseif ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE) {
            list($lowestPrice) = Mage::getModel('uswf_comparedto/product_type_price')->getMinPrice($product);
            $associatedProducts = $product->getTypeInstance(true)->getSelectionsCollection($product->getTypeInstance(true)->getOptionsIds($product), $product);
            $pkgQty = 0;
            foreach ($associatedProducts as $option) {
                $optionPackageQty = $option->getPackageQty();
                $pkgQty += $optionPackageQty ? $optionPackageQty * $option->getSelectionQty() : $option->getSelectionQty();
            }
            $prices = Mage::getModel('uswf_comparedto/product_type_price')->getPriceList($product);
        }
        else {
            list($lowestPrice, $pkgQty) = Mage::getModel('uswf_comparedto/product_type_price')->getMinPrice($product);
            $prices = Mage::getModel('uswf_comparedto/product_type_price')->getPriceList($product);
        }
        return array($lowestPrice, $pkgQty, $prices);
    }

    /**
     * Returns associated products
     *
     * @param Mage_Catalog_Model_Product
     * @return array
     */
    public function getAssociatedProducts($product) {
        return $product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED ?
            $product->getTypeInstance(true)->getAssociatedProducts($product) : array();
    }

    /**
     * Returns product description style for tier 1 product
     *
     * @param USWF_ComparedTo_Block_Product_Widget_Link
     * @return string
     */
    public function getProductDescStyle($widget) {
        return 'style="font-size:' . $widget->getData('desc_font_size1') . 'px;font-weight:' .
        $widget->getData('desc_bold1') . ';"';
    }

    /**
     * Returns top hor. banner image
     *
     * @return string
     */
    public function getTopHorBannerImg() {
        return Mage::getStoreConfig(self::CONFIG_PATH_TOP_HOR_BANNER_IMAGE) ?
            '<img src="' . Mage::getBaseUrl('media') . self::CONFIG_COMPAREDTO_MEDIA_POSTFIX .
            Mage::getStoreConfig(self::CONFIG_PATH_TOP_HOR_BANNER_IMAGE) . '" alt="">' : '';
    }

    /**
     * Returns bottom banner image
     *
     * @return string
     */
    public function getBottomBannerImg() {


        return (Mage::getStoreConfig(self::CONFIG_PATH_BOTTOM_BANNER_IMAGE) && Mage::getStoreConfig(self::CONFIG_BOTTOM_BANNER_ENABLED)) ?
            '<img class="compare-bottom-banner" src="' . Mage::getBaseUrl('media') . self::CONFIG_COMPAREDTO_MEDIA_POSTFIX .
            Mage::getStoreConfig(self::CONFIG_PATH_BOTTOM_BANNER_IMAGE) . '" alt="">' : '';
    }

    /**
     * Returns tier1 ribbon image
     *
     * @param USWF_ComparedTo_Block_Product_Widget_Link $widget
     * @param integer $index
     * @return string
     */
    public function getTier1RibbonImg($widget, $index) {
        $position = $widget->getData('ribbon_pos1');
        return Mage::getStoreConfig(self::CONFIG_PATH_TIER1_RIBBON_IMAGE_TMPL . $position) ?
            '<img class="ribbon-fix-index-' . $index . '-pos-' . $position . '" src="' . Mage::getBaseUrl('media') .
            self::CONFIG_COMPAREDTO_MEDIA_POSTFIX .
            Mage::getStoreConfig(self::CONFIG_PATH_TIER1_RIBBON_IMAGE_TMPL . $position) . '" alt="ribbon">' : '';
    }

    /**
     * Returns oem ribbon image
     *
     * @param USWF_ComparedTo_Block_Product_Widget_Link $widget
     * @param integer $index
     * @return string
     */
    public function getOemRibbonImg($widget, $index) {
        $position = $widget->getData('ribbon_pos2');
        return Mage::getStoreConfig(self::CONFIG_PATH_OEM_RIBBON_IMAGE_TMPL . $position) ?
            '<img class="ribbon-fix-index-' . $index . '-pos-' . $position . '" src="' . Mage::getBaseUrl('media') .
            self::CONFIG_COMPAREDTO_MEDIA_POSTFIX .
            Mage::getStoreConfig(self::CONFIG_PATH_OEM_RIBBON_IMAGE_TMPL . $position) . '" alt="ribbon">' : '';
    }

    /**
     * Returns enabled tabs list
     *
     * @param USWF_ComparedTo_Block_Product_Widget_Link
     * @return array
     */
    public function getEnabledTabs($widget) {
        //$tabs = $widget->getData('active_tabs');
        $tabs = Mage::getStoreConfig('uswf_comparedto/labels/enabled_tabs');

        return !empty($tabs) ? explode(',', $tabs) : array();
    }

    /**
     * Returns faq tab header text
     *
     * @return string
     */
    public function getFaqTabHeaderText() {
        return Mage::getStoreConfig(self::CONFIG_PATH_FAQ_TAB_HEADER_TEXT);
    }

    /**
     * Returns faq tab header image
     *
     * @return string
     */
    public function getFaqTabHeaderImage() {
        return Mage::getStoreConfig(self::CONFIG_PATH_FAQ_TAB_HEADER_IMAGE) ?
            '<img class="faq-tier-1-image" src="' . Mage::getBaseUrl('media') . self::CONFIG_COMPAREDTO_MEDIA_POSTFIX .
            Mage::getStoreConfig(self::CONFIG_PATH_FAQ_TAB_HEADER_IMAGE) . '" alt="tier 1">' : '';
    }

    /**
     * Returns faq tab quiz
     *
     * @return array
     */
    public function getFaqTabQuiz() {
        $result = array();
        for ($i = 1; $i <= 10; $i++) {
            $question = Mage::getStoreConfig(self::CONFIG_PATH_FAQ_TAB_QUESTION_TMPL . $i);
            $answer = Mage::getStoreConfig(self::CONFIG_PATH_FAQ_TAB_ANSWER_TMPL . $i);
            if (!empty($question) && !empty($answer)) {
                $result[] = array('question' => $question, 'answer' => $answer);
            }
        }
        return $result;
    }

    /**
     * Map products array using merv value
     *
     * @param int $qty
     * @param array $products
     * @return array
     */
    public function mapProductsMerv($products, $qty) {
        $result = array();
        foreach($products as $product) {
            if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED) {
                $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
                if (count($associatedProducts) > 0) {
                    $candidateItem = null;
                    foreach ($associatedProducts as $item) {
                        if ($item->getPackageQty() == $qty) {
                            $result[$item->getMerv()] = $item;
                            $candidateItem = null;
                            break;
                        } elseif (!$candidateItem ||
                            ($candidateItem->getPackageQty() > $qty &&
                                ($item->getPackageQty() % $qty == 0) &&
                                (abs($candidateItem->getPackageQty() - $qty) < abs($item->getPackageQty() - $qty))
                            )) {
                            $candidateItem = $item;
                        }
                    }
                    if ($candidateItem) {
                        //try to pick one with closest package qty
                        $result[$candidateItem->getMerv()] = $candidateItem;
                    }
                }
            } else {
                if ($product->getMerv()) {
                    $result[$product->getMerv()] = $product;
                }
            }
        }
        return $result;
    }

    /**
     * Get min price and prices list for mapped products array
     *
     * @param array $productsMerv
     * @return array($minPrice, $prices)
     */
    public function getProductsMervPriceInfo($productsMerv, $quantity) {
        $prices = array();
        foreach ($productsMerv as $product) {
            if ($product->getMerv()) {
                if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
                    $prices[$product->getMerv()] =
                        $product->getPriceModel()->getFinalPrice($quantity, $product) * $quantity;
                } else {
                    $ratio = $quantity / $product->getPackageQty();
                    $prices[$product->getMerv()] = $product->getFinalPrice() * $ratio;
                }
            }
        }
        return array(count($prices) ? min($prices) / $quantity : 0, $prices);
    }

    /**
     * Get the ID from a passed in string
     *
     * String examples are:
     * product/1234
     * product/1234/4567
     * review/1234
     *
     * @param $value
     * @param $type
     *
     * @return bool|string
     */
    public function getCorrectId($value, $type) {
        $value = explode('/', $value);
        $id = false;
        if (isset($value[0]) && isset($value[1]) && $value[0] == $type) {
            $id = $value[1];
        }
        return $id;
    }

    /**
     * Extracts tier1 and oem products ids from snowflake widget params
     *
     * @param array $params
     * @return array
     */
    public function extractOemTier1Products($params) {
        $tier1ProductIds = array();
        $oemProductIds = array();
        if (!empty($params)) {
            foreach($params as $key => $value) {
                if (in_array($key, $this->tier1ProductParamNames)) {
                    $tier1ProductIds[] = $this->getCorrectId($value, 'product');
                } elseif (in_array($key, $this->oemProductParamNames)) {
                    $oemProductIds[] = $this->getCorrectId($value, 'product');
                }
            }
        }
        return array('tier1' => $tier1ProductIds, 'oem' => $oemProductIds);
    }

    /**
     * Retrieve is product available for sale
     *
     * @return array
     */
    public function getSaleableAssociatedProducts($product)
    {
        $associatedProducts = array();
        if ($product->isGrouped()) {
            $associatedProducts = $product->getTypeInstance(true)
                ->getAssociatedProducts($product);
        }elseif($product->getTypeId() == 'bundle'){
            $associatedProducts = $product->getTypeInstance(true)->getSelectionsCollection(
                $product->getTypeInstance(true)->getOptionsIds($product), $product
            );
        }
        foreach ($associatedProducts as $key => $item) {
            if (!$item->isSaleable()) {
                unset($associatedProducts[$key]);
            }
        }
        return $associatedProducts;
    }
}
