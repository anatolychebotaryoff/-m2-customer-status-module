<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_UniversalVariable
 * @copyright
 * @author
 */
class USWF_UniversalVariable_Model_Page_Observer extends Lyonscg_UniversalVariable_Model_Page_Observer
{
    const PAGE_TYPE_HOME = 'home';
    const PAGE_TYPE_ERROR = 'error';
    const PAGE_TYPE_CMS = 'content';
    const PAGE_TYPE_CATEGORY = 'category';
    const PAGE_TYPE_SEARCH = 'search';
    const PAGE_TYPE_PRODUCT = 'product';
    const PAGE_TYPE_CART= 'basket';
    const PAGE_TYPE_CHECKOUT = 'checkout';
    const PAGE_TYPE_CHECKOUT_SUCCESS = 'confirmation';
    const PAGE_TYPE_COMPARE_TO = 'snowflake';

    const SNOWFLAKE_MATCH_PATTERN = '/\{\{\s*widget[^\}]+(type=\"uswf_comparedto\/product_widget_link(_airfilter)?\"[^\}]+)/i';
    const SEARCH_REQUEST_URI = '/search';
    const SEARCH_SPRING_DIRORDER_PARAMS_DEFAULT = 'relevancy_desc';
    const SEARCH_SPRING_LISTING_MODE_DEFAULT = 'grid';
    const BLOCK_CATALOG_PRODUCT_LIST_NAME = 'product_list';
    const FILTER_FINDER_PARAM_MATCH_PATTERN = '/(filter_finder|size)/';
    const BLOCK_FILTER_FINDER_NAME = 'filterfinder';
    const BLOCK_AIRFILTER_FILTER_FINDER_NAME = 'airfilter';
    const BLOCK_AIRFILTER_FINDER_NAME = 'resultset';
    const CATALOG_PRODUCT_TYPE_SIMPLE = 'simple';
    const CATALOG_PRODUCT_TYPE_BUNDLE = 'bundle';

    protected $filterFinderModuleList = array('FridgeFilterFinder', 'AirFilterFinder');
    protected $otherPagesMap = array('customer' => 'account');

    protected $snowflakeWidgetProducts = null;
    protected $recommendation = null;
    protected $categories = array();

    protected function _getCategory($category_id) {
      // Modified to only load category if needed (for things like collections)
      if (!array_key_exists("category_".$category_id, $this->categories)) {
        $this->categories["category_".$category_id] = Mage::getModel('catalog/category')->load($category_id);
      }
      return $this->categories["category_".$category_id];
    }

    /**
     * Set the model attributes to be passed front end
     * @return string
     */
    public function _getPageType() {
        if ($this->_getModuleName() == 'cms') {
            if (Mage::getSingleton('cms/page')->getIdentifier() == 'no-route') {
                return self::PAGE_TYPE_ERROR;
            }
        }
        if ($this->_isHome()) {
            return self::PAGE_TYPE_HOME;
        } elseif ($this->_isContent()) {
            if ($this->_isSearch()) {
                return self::PAGE_TYPE_SEARCH;
            }
            return $this->isCompareTo() ? self::PAGE_TYPE_COMPARE_TO : self::PAGE_TYPE_CMS;
        } elseif ($this->_isCategory()) {
            return self::PAGE_TYPE_CATEGORY;
        } elseif ($this->_isProduct()) {
            return self::PAGE_TYPE_PRODUCT;
        } elseif ($this->_isBasket()) {
            return self::PAGE_TYPE_CART;
        } elseif ($this->_isCheckout()) {
            return self::PAGE_TYPE_CHECKOUT;
        } elseif ($this->_isConfirmation()) {
            return self::PAGE_TYPE_CHECKOUT_SUCCESS;
        } else {
            $pageType = $this->_getModuleName();
            return isset($this->otherPagesMap[$pageType]) ? $this->otherPagesMap[$pageType] : $pageType;
        }
    }

    /**
     * Returns parsed snowflake widget from cms page
     */
    protected function getSnowflakeWidgetProducts() {
        if (is_null($this->snowflakeWidgetProducts)) {
            preg_match(self::SNOWFLAKE_MATCH_PATTERN, Mage::getSingleton('cms/page')->getContent(), $matches);
            if (!empty($matches[1])) {
                $tokenizer = new Varien_Filter_Template_Tokenizer_Parameter();
                $tokenizer->setString($matches[1]);
                $params = $tokenizer->tokenize();
                $this->snowflakeWidgetProducts = Mage::helper('uswf_comparedto')->extractOemTier1Products($params);
            } else {
                $this->snowflakeWidgetProducts = false;
            }
        }
        return $this->snowflakeWidgetProducts;
    }

    /**
     * Returns if CMS page is Snowflake page
     * @return bool
     */
    public function isCompareTo() {
        return $this->getSnowflakeWidgetProducts() !== false;
    }

    /**
     * Returns if current is search page
     * @return bool
     */
    public function _isSearch() {
        return Mage::app()->getRequest()->getRequestString() == self::SEARCH_REQUEST_URI;
    }

    /**
     * Returns if current is category page
     * @return bool
     */
    public function _isCategory() {
        return $this->_getControllerName() == 'category' || $this->getFullActionName() == 'catalog_category_view'
            || $this->isFilterFinderPage();
    }

    /**
     * Returns if current is filter finder page
     * @return bool
     */
    public function isFilterFinderPage() {
        return in_array($this->_getModuleName(), $this->filterFinderModuleList);
    }

    /**
     * Set listing variable for Qubit (for current page)
     * @return void
     */
    public function _setListing() {
        //search listing will be processed in universal_variable.phtml
        if ($this->isFilterFinderPage()) {
            $this->_listing = array();
            /** @var Lyonscg_FilterFinder_Block_Filterfinder $list */
            $list = Mage::app()->getLayout()->getBlock(self::BLOCK_AIRFILTER_FILTER_FINDER_NAME);
            if ($list instanceof Lyonscg_AirFilter_Block_Airfilter) {
                $collection = $this->_getListingProducts();
                $this->_listing = array(
                    'result_count' => count($collection),
                    'items' => array()
                );
                foreach($collection as $product) {
                    $this->_listing['items'][] = $this->_getProductModel($product);
                }
                return;
            } else {
                $list = Mage::app()->getLayout()->getBlock(self::BLOCK_FILTER_FINDER_NAME);
            }
            if (!$list instanceof Lyonscg_FilterFinder_Block_Filterfinder) {
                $list = Mage::app()->getLayout()->getBlock(self::BLOCK_AIRFILTER_FINDER_NAME);
                if ($list instanceof Lyonscg_AirFilter_Block_Resultset) {
                    $collection = array();
                    $size = $list->getSize();
                    $rows = $list->getConfigList('category');
                    $mervs = $list->getConfigList('mpr');
                    foreach($mervs as $merv) {
                        foreach($rows as $row) {
                            if ($product = $list->prepareProduct($row, $merv, $size)) {
                                $collection[] = $product;
                            }
                        }
                    }
                    $this->_listing = array(
                        'result_count' => count($collection),
                        'items' => array()
                    );
                    foreach($collection as $product) {
                        $this->_listing['items'][] = $this->_getProductModel($product);
                    }
                }
            } else {
                $collection = $list->prepareProductCollection();
                $this->_listing = array(
                    'result_count' => $collection->getSize(),
                    'items' => array()
                );
                foreach($collection as $product) {
                    $this->_listing['items'][] = $this->_getProductModel($product);
                }
            }
        } elseif ($this->_isCategory()) {

            $cache = Mage::app()->getCache();
            $check = $cache->load("UV_CACHE_CATEGORY_".$this->_getCurrentCategory()->getId());
            if ($check != null && $check != "") {
                $this->_listing = json_decode($check);
                return;
            }

            /** @var Mage_Catalog_Block_Product_List $list */
            $list = Mage::app()->getLayout()->getBlock(self::BLOCK_CATALOG_PRODUCT_LIST_NAME);
            if (!$list instanceof Mage_Catalog_Block_Product_List) {
                return;
            }
            /** @var Mage_Catalog_Block_Product_List_Toolbar $toolbar */
            $toolbar = $list->getToolbarBlock();
            $collection = $toolbar->setCollection($list->getLoadedProductCollection())->getCollection();
            $this->_listing = array(
                'sort_by' => $toolbar->getCurrentOrder() . '_' . $toolbar->getCurrentDirection(),
                'layout' => $toolbar->getCurrentMode(),
                'items' => array(),
                'result_count' => $collection->getSize()
            );
            foreach($collection as $product) {
                $this->_listing['items'][] = $this->_getProductModel($product);
            }

            $cache->save( json_encode($this->_listing), "UV_CACHE_CATEGORY_".$this->_getCurrentCategory()->getId(), array(), 3600);
        }
        if ($query = $this->getSearchQuery()) {
            $this->_listing['query'] = $query;
        }
        if ($this->_isSnowflake()){
            $page = Mage::getSingleton('cms/page');
            $content = $this->_getIncludeParameters($page->getContent());
            if(array_key_exists('product1', $content) && array_key_exists('product2', $content)){
                $productId1 = $this->getCorrectId($content['product1'], 'product');
                $product1  = Mage::getModel('catalog/product')->load($productId1);
                $productId2 = $this->getCorrectId($content['product2'], 'product');
                $product2  = Mage::getModel('catalog/product')->load($productId2);

                $this->_listing = array(
                    'result_count' => 2,
                    'items' => array()
                );
                $this->_listing['items'][] = $this->_getProductModel($product1);
                $this->_listing['items'][] = $this->_getProductModel($product2);
            }
        }
    }

    /**
     * Returns search query
     * @return string | null
     */
    protected function getSearchQuery() {
        if ($this->_isSearch() && isset($_GET['q'])) {
            return $_GET['q'];
        }
        return null;
    }

    /**
     * Set user variable for Qubit (for current page)
     * @return void
     */
    public function _setUser() {
        
        $customer = $this->_getCustomer();
        $customerId = $customer->getEntityId();
        $customerGroupId = null;

        //try to get customer group from session
        $customerSession = Mage::getSingleton('customer/session');
        if (isset($customerSession)) {
            $customerGroupId = $customerSession->getCustomerGroupId();
        }

        //try to get customer group from conversion
        if (($hdGroupId = Mage::getSingleton('core/cookie')->get('hd_groupid')) && !empty($hdGroupId)) {
            $customerGroupId = $hdGroupId;
        }
        
        //process data if order success page
        if ($this->_isConfirmation() && ($orderId = $this->_getCheckoutSession()->getLastOrderId())) {
            $order = $this->_getSalesOrder()->load($orderId);
            $customerGroupId = is_null($customerGroupId) ? $order->getCustomerGroupId() : $customerGroupId;
            $email = $order->getCustomerEmail();
        //process data if quote exists
        } elseif (($cart = $this->_getCheckoutSession()) && ($quoteId = $cart->getQuoteId())) {
            $quote = $cart->getQuote();
            $customerGroupId = is_null($customerGroupId) ? $quote->getCustomerGroupId() : $customerGroupId;
            $email = $quote->getCustomerEmail();
            $cartId = $quote->getId();
        //usual case
        } else {
            $customerGroupId = is_null($customerGroupId) ? $customer->getGroupId() : $customerGroupId;
            $email = $customer->getEmail();
        }
        //try to get email from conversion url if other ways were unsuccesfull
        $email = empty($email) ? Mage::helper('uswf_universalvariable')->getCampaignEmail() : $email;
        
        //fill in base data
        $this->_user = array(
            'customer_group' => Mage::getModel('customer/group')->load(intval($customerGroupId))->getCustomerGroupCode(),
            'customer_group_id' => intval($customerGroupId),
            'returning' => $customerId ? true : false,
            'language' => Mage::getStoreConfig('general/locale/code', Mage::app()->getStore()->getId())
        );
        //fill in add, data
        if (!empty($email)) {
            $this->_user['email'] = $email;    
        }
        if (!empty($customerId)) {
            $this->_user['user_id'] = (string)$customerId;
        }
        if (!empty($cartId)) {
            $this->_user['cart_id'] = (string)$cartId;
        }
    }

    /**
     * Set shopping cart variable for Qubit (for current page)
     * @return void
     */
    public function _setBasket() {
        $cart = $this->_getCheckoutSession();
        if (!isset($cart)) {
            return;
        }

        $quote = $cart->getQuote();
        $quoteId = $cart->getQuoteId();
        $basket = array(
            'currency' => $this->_getCurrency(),
            'subtotal' => (float)$quote->getSubtotal(),
            'tax' => ($tax = (float)$quote->getShippingAddress()->getTaxAmount()),
            'subtotal_include_tax' => (boolean)$this->_doesSubtotalIncludeTax($quote, $tax),
            'shipping_cost' => (float)$quote->getShippingAddress()->getShippingAmount(),
            'shipping_method' => (string)$quote->getShippingAddress()->getShippingMethod(),
            'total' => (float)$quote->getGrandTotal(),
        );
        if ($couponCode = $quote->getCouponCode()) {
            $basket['vouchers'] = (array)$couponCode;
            $basket['voucher_discount'] = abs($quote->getShippingAddress()->getDiscountAmount());
        }
        if ($quoteId) {
            $basket['id'] = (string)$quoteId;
        }
        // Line items
        $items = $quote->getAllItems();
        $basket['line_items'] = $this->_getLineItems($items, 'basket');

        $this->_basket = $basket;
    }

    /**
     * Returns prepared UV product array based on given product
     * @param Mage_Catalog_Model_Product $product
     * @param boolean $extended
     * @param boolean $forceUrl
     * @return array
     */
    public function _getProductModel($product, $extended = true, $forceUrl = false) {
        $product_model = array(
            'id' => $product->getId(),
            'sku_code' => $product->getSku(),
            'url' => $forceUrl ? $forceUrl : $product->getProductUrl(),
            'name' => $product->getName(),
            'currency' => $this->_getCurrency(),
            'description' => strip_tags($product->getShortDescription()),
            'stock' => (int) $this->_getProductStock($product),
            'image_url' => $this->getProductImageUrl($product)
        );

        $product_model = array_merge($product_model, $this->getProductPrices($product));

        $categories = $this->_getProductCategories($product);
        if (isset($categories[0])) {
            $product_model['category'] = $categories[0];
        }
        if (isset($categories[1])) {
            $product_model['subcategory'] = $categories[1];
        }

        if ($extended) {
            Varien_Profiler::start("uv::product_model_extended");
            $product_model['manufacturer_type'] = $product->getAttributeText('oem_aftermarket_private');
            $product_model['product_type'] = $product->getTypeId();
            $product_model['product_item_type'] = $product->getAttributeText('item_type');
            $product_model['product_servicability'] = $product->getAttributeText('system_replacement_other');
            $product_model['google_pla_id'] = $product->getData('google_pla_id');
            if (!isset($product_model['google_pla_id'])) {
                $product_model['google_pla_id'] = $product->getResource()->getAttributeRawValue($product->getId(), 'google_pla_id', Mage::app()->getStore());
            }
            $product_model['family'] = $product->getData('family');
            $product_model['family_extended'] = $product->getData('family_extended');
            $product_model['family_id'] = $product->getData('family_id');
            $product_model['skeleton_product'] = $product->getResource()->getAttributeRawValue($product->getId(), 'skeleton_product', Mage::app()->getStore());
            Varien_Profiler::stop("uv::product_model_extended");
        }

        return $product_model;
    }

    /**
     * Map current product to variable ready to use for UV
     * @param null $id
     * @return void
     */
    public function _setProduct($id = null) {
        $product  = $this->_getCurrentProduct($id);
        if (!$product) return false;
        $this->_product = $this->_getProductModel($product, true);
        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE) {
            $groupedChildren = $product->getTypeInstance(true)
                ->setStoreFilter($product->getStore(), $product)
                ->getAssociatedProducts($product);
            if (sizeof($groupedChildren) > 0 ) {
                $groupedChild = array_shift($groupedChildren);
                $this->_product['linked_products'] = array($this->_getProductModel($groupedChild));
            }
        } elseif ($product->getTypeId() == self::CATALOG_PRODUCT_TYPE_BUNDLE) {
            $bundleOptions = $product->getTypeInstance(true)->getChildrenIds($product->getId(), false);
            $ids = array();
            foreach ($bundleOptions as $bundleOption) {
                foreach ($bundleOption as $id) {
                    $ids[] = $id;       
                }
            }
            $productCollection = Mage::getModel('catalog/product')->getCollection()
                ->addStoreFilter(Mage::app()->getStore())
                ->addAttributeToSelect(array('name', 'short_description', 'sku'))
                ->addFinalPrice()
                ->addIdFilter($ids);
            $this->_product['linked_products'] = array();
            foreach ($productCollection->getItems() as $product) {
                $this->_product['linked_products'][] = $this->_getProductModel($product);
            }
        }
    }

    /**
     * Returns quote/order items, mapped for UV usage
     * @param $items
     * @param $page_type
     * @return array
     */
    public function _getLineItems($items, $page_type) {
        $line_items = array();
        foreach($items as $item) {
            if ($item-> getParentItem()) {
                continue;
            }
            $litem_model = array();
            $litem_model['product'] = $this->_getProductModel($item->getProduct());
            $litem_model['subtotal'] = (float) $item->getRowTotalInclTax();
            $litem_model['total_discount'] = (float) $item->getDiscountAmount();
            if ($page_type == 'basket') {
                $litem_model['quantity'] = (float) $item->getQty();
            } else {
                $litem_model['quantity'] = (float) $item->getQtyOrdered();
            }
            $litem_model['product']['unit_sale_price'] = $item->getPrice();
            $litem_model['product']['linked_products'] = array();
            if(is_array($item->getChildren())) {
                foreach ($item->getChildren() as $child) {
                    $litem_model['product']['linked_products'][] = $this->_getProductModel(
                        Mage::getModel('catalog/product')->load($child->getProductId())
                    );
                }
            }
            array_push($line_items, $litem_model);
        }
        return $line_items;
    }

    /**
     * Returns product's base image url
     * @param Mage_Catalog_Model_Product $product
     * @return string
     */
    protected function getProductImageUrl($product) {
        if (!$product->getImage()) {
            $product->setImage(
                Mage::getResourceSingleton('catalog/product')
                    ->getAttributeRawValue($product->getId(), 'image', Mage::app()->getStore())
            );
        }
        return (string)Mage::helper('catalog/image')->init($product, 'image');
    }

    /**
     * Fill in universal variable for further usage in phtml template
     *
     * @param $observer
     * @return $this
     */
    public function setUniversalVariable($observer) {
        if (!$this->getUser()) {
            $this->_setUser();            
        }

        if ($this->_isCategory()) {
            $this->_setCategory($observer->getEvent()->getCurrentCategoryId());
        }

        $this->_setPage();

        if ($this->_isProduct() || $this->isCompareTo()) {
            $this->_setProduct($observer->getEvent()->getCurrentProductId());
        }

        if ($this->isCompareTo()) {
            $this->setRecommendation();
        }

        if ($this->_isCategory() || $this->_isSearch() || $this->_isSnowflake()) {
            $this->_setListing();
        }

        if (!$this->_isConfirmation()) {
            $this->_setBasket();
        }

        if ($this->_isConfirmation()) {
            $this->_setTranscation();
        }

        $this->_setOfferId();
        $this->_setAffiliateId();
        $this->_setTransactionId();


        return $this;
    }

    /**
     * Returns current product for page
     *
     * @param $id
     * @return Mage_Core_Model_Abstract|mixed
     */
    protected function _getCurrentProduct($id = null) {
        if (($products = $this->getSnowflakeWidgetProducts()) !== false && count($products['oem']) > 0) {
            $id = reset($products['oem']);
            return Mage::getSingleton('catalog/product')->load($id);
        }

        if ($currentProduct = Mage::registry('current_product')) {
            return $currentProduct;
        }

        if (!empty($id)) {
            return Mage::getSingleton('catalog/product')->load($id);
        }

        return false;
    }

    /**
     * Set Tier1 recommendation for OEM product
     *
     * @return void
     */
    public function setRecommendation() {
        if (($products = $this->getSnowflakeWidgetProducts()) !== false && count($products['tier1']) > 0) {
            $items = array();
            foreach($products['tier1'] as $id) {
                $product = Mage::getModel('catalog/product')->load($id);
                $items[] = array(
                    'url' => $product->getProductUrl(),
                    'name' => $product->getName()
                );
            }
            $this->recommendation = array('items' => $items);
        }
    }

    public function getRecommendation() {
        return $this->recommendation;
    }

    /**
     * Set page UV variable
     *
     * @return void
     */
    public function _setPage() {
        $this->_page = array();
        $this->_page['type'] = $this->_getPageType();
        if ($this->_page['type'] == self::PAGE_TYPE_CATEGORY || $this->_page['type'] == self::PAGE_TYPE_PRODUCT) {
            $this->_page['breadcrumb'] = $this->_getPageBreadcrumb();
        }
    }

    /**
     * Returns breadcrumb array for UV
     *
     * @return array
     */
    public function _getPageBreadcrumb() {
        $breadcrumb = array();
        if ($this->isFilterFinderPage()) {
            array_push($breadcrumb, $this->_getModuleName());
            foreach (Mage::app()->getRequest()->getParams() as $key => $value) {
                if (preg_match(self::FILTER_FINDER_PARAM_MATCH_PATTERN, $key)) {
                    array_push($breadcrumb, $value);
                }
            }
        } else {
            $arr = $this->_getBreadcrumb();
            foreach ($arr as $category) {
                $breadcrumb[] = $category['label'];
            }
        }
        return $breadcrumb;
    }

    /**
     * Returns prepared price values for UV
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    /*
     public function getProductPrices($product) {
        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE) {
            $childProducts = $product->getTypeInstance(true)
                ->setStoreFilter($product->getStore(), $product)
                ->getAssociatedProducts($product);
            if (!empty($childProducts)) {
                $product = reset($childProducts);       
            }
        }
        return array(
            'unit_price' => !$product ? 0 : (float) $product->getPrice(),
            'unit_sale_price' => !$product ? 0 : (float) $product->getFinalPrice()
        );
    }
     */
    public function getProductPrices($product) {
        //For grouped product we try to use price and final price from grouped product instance for speed up
        //these prices are setted in grouped product indexer with 1st child's  values (order by position)
        return array(
            'unit_price' => !$product ? 0 : (float) $product->getPrice(),
            'unit_sale_price' => !$product ? 0 : (float) $product->getFinalPrice()
        );
    }

    /**
     * Returns listing products for page for airfilter
     *
     * @return array
     */
    protected function _getListingProducts() {
        $airfilter = Mage::app()->getLayout()->createBlock('airfilter/airfilter');
        $block = Mage::app()->getLayout()->createBlock('airfilter/resultset');
        $labels = $airfilter->prepareSizesForFilter();
        $rows = $block->getConfigList('category');
        $mervs = $block->getConfigList('mpr');
        $_sizeAttrCode = Mage::getStoreConfig('lyonscg_airfilter/air_filter_details/dfs_size_attr_code');
        $collection = array();
        foreach($rows as $row) {
            $_category = Mage::getModel('catalog/category')->load($row);
            $_productCollection = $_category->getProductCollection();
            $_productCollection->addAttributeToSelect('*');
            $_productCollection->addAttributeToSelect('google_pla_id');
            $eqOr = array();
            foreach($labels as $label) {
                foreach ($label as $size) {
                    $eqOr[] = array('eq' => Mage::getResourceModel('catalog/product')->getAttribute($_sizeAttrCode)->getSource()->getOptionId($size));
                }
            }
            $_productCollection->addAttributeToFilter($_sizeAttrCode,
                array($eqOr));

            $eqOr2 = array();
            foreach ($mervs as $merv) {
                $eqOr2[] = array('eq' => Mage::getResourceModel('catalog/product')->getAttribute('mpr')->getSource()->getOptionId("MPR:".$merv));
            }
            $_productCollection->addAttributeToFilter('mpr',
                array($eqOr2));

            $_productCollection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds())
                ->addAttributeToSelect('merv_value');
            $_productCollection->getSelect()->group('size_advertised');
            $_productCollection->setPageSize(10)->load();
            $collection = array_merge ($collection, $_productCollection->getItems());
        }
        return $collection;
    }

    /**
     * Returns if current is snowflake page
     * @return bool
     */
    public function _isSnowflake() {
        if ($this->getFullActionName() == 'cms_page_view'){
            $page = Mage::getSingleton('cms/page');
            if (!$page->getId()) {
                return false;
            }else{
                $identifier = $page->getIdentifier();
                if (preg_match('/^(compare\/)/i', $identifier)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * Return associative array of include construction.
     *
     * @param string $value raw parameters
     * @return array
     */
    protected function _getIncludeParameters($value)
    {
        $tokenizer = new Varien_Filter_Template_Tokenizer_Parameter();
        $tokenizer->setString($value);
        $params = $tokenizer->tokenize();
        foreach ($params as $key => $value) {
            if (substr($value, 0, 1) === '$') {
                $params[$key] = $this->_getVariable(substr($value, 1), null);
            }
        }
        return $params;
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
    protected function getCorrectId($value, $type)
    {
        $value = explode('/', $value);
        $id = false;
        if (isset($value[0]) && isset($value[1]) && $value[0] == $type) {
            $id = $value[1];
        }
        return $id;
    }
}
