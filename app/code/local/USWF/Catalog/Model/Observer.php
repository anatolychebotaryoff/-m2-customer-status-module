<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_Catalog
 * @copyright
 * @author
 */
class USWF_Catalog_Model_Observer extends Mage_Catalog_Model_Observer
{
    /**
     * Adds catalog categories to top menu
     *
     * @param Varien_Event_Observer $observer
     */
    public function addCatalogToTopmenuItems(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        $block->addCacheTag(Mage_Catalog_Model_Category::CACHE_TAG);
        $this->_addCategoriesToMenu(
            Mage::helper('uswf_catalog/category')->getStoreCategories(), $observer->getMenu(), $block, true
        );
    }
    
    /**
     * Recursively adds categories to top menu
     *
     * @param Varien_Data_Tree_Node_Collection|array $categories
     * @param Varien_Data_Tree_Node $parentCategoryNode
     * @param Mage_Page_Block_Html_Topmenu $menuBlock
     * @param bool $addTags
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $menuBlock, $addTags = false)
    {
        $categoryModel = Mage::getModel('catalog/category');
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }

            $nodeId = 'category-node-' . $category->getId();

            $categoryModel->setId($category->getId());
            if ($addTags) {
                $menuBlock->addModelTags($categoryModel);
            }

            $tree = $parentCategoryNode->getTree();
            $categoryData = array(
                'name' => $category->getName(),
                'short_name' => $category->getShortName(),
                'id' => $nodeId,
                'url' => Mage::helper('catalog/category')->getCategoryUrl($category),
                'is_active' => $this->_isActiveMenuCategory($category)
            );
            $categoryNode = new Varien_Data_Tree_Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            $flatHelper = Mage::helper('catalog/category_flat');
            if ($flatHelper->isEnabled() && $flatHelper->isBuilt(true)) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }

            $this->_addCategoriesToMenu($subcategories, $categoryNode, $menuBlock, $addTags);
        }
    }

    /**
     * if group products that don't have associated items
     *
     * @param Varien_Event_Observer $observer
     * @throws Exception
     */
    public function catalogProductSaveAfter(Varien_Event_Observer $observer){
        $product = $observer->getProduct();
        if (Mage::app()->getStore()->isAdmin()) {
            if ($product->getTypeId() == Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE) {
                $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
                if (!$associatedProducts) {
                    $this->_getAdminSession()->addWarning('No Associated Products');
                }
            }
        }
    }

    /**
     * Retrieve adminhtml session model object
     *
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getAdminSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    /**
     * Redirect if group products that don't have associated items
     *
     * @param Varien_Event_Observer $observer
     * @throws Exception
     */
    public function catalogControllerProductView(Varien_Event_Observer $observer){
        $product = $observer->getProduct();
        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE &&
            !count($product->getTypeInstance(true)->getAssociatedProducts($product))) {
            $sku = $product->getSku();
            throw new Exception(Mage::helper('seosuite/richsnippet')->__("Error for group product(sku:$sku) that don't have associated items"));
        }
    }

    /**
     * Init weekend
     *
     * @param Varien_Event_Observer $observer
     * @throws Exception
     */
    public function weekendsSave(Varien_Event_Observer $observer){
        $configState = Mage::app()->getRequest()->getPost('config_state', '');
        if (array_key_exists(USWF_Catalog_Helper_Data::SECTIONS_CONFIG_PATH, $configState) &&
            $configState[USWF_Catalog_Helper_Data::SECTIONS_CONFIG_PATH] == 1) {
            $website = $observer->getWebsite();
            $store = $observer->getStore();

            $mageDate = Mage::getModel('core/date');
            $weekDay = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            $configWeekendsStart = unserialize(Mage::getStoreConfig(USWF_Catalog_Helper_Data::SET_WEEKENDS_START_CONFIG_PATH, $store));
            $configWeekendsEnd = unserialize(Mage::getStoreConfig(USWF_Catalog_Helper_Data::SET_WEEKENDS_END_CONFIG_PATH, $store));

            $curTime = $mageDate->gmtTimestamp();

            $valueStart = array_shift($configWeekendsStart);
            $weekDayStart = $valueStart['day'];
            $weekTimeStart = $valueStart['time'][0] . ':' . $valueStart['time'][1] . ':' . $valueStart['time'][2];

            $nextStartDay = $mageDate->date('Y-m-d ', strtotime("next $weekDay[$weekDayStart]", $curTime));
            $nextStartDay = $mageDate->date('Y-m-d H:i:s', strtotime($nextStartDay . $weekTimeStart));

            $valueEnd = array_shift($configWeekendsEnd);
            $weekDayEnd = $valueEnd['day'];
            $weekTimeEnd = $valueEnd['time'][0] . ':' . $valueEnd['time'][1] . ':' . $valueEnd['time'][2];

            for ($i = 0; $i < 7; $i++) {
                $day = $mageDate->date('l', strtotime($nextStartDay . " +{$i} day"));
                if ($weekDay[$weekDayEnd] === $day) {
                    $nextEndDay = $mageDate->date('Y-m-d ',  strtotime($nextStartDay . " +{$i} day"));
                    $nextEndDay = strtotime($nextEndDay . $weekTimeEnd);
                    $diff = $nextEndDay - $mageDate->gmtTimestamp($nextStartDay);
                    Mage::getModel( 'core/config_data' )
                        ->setWebsite($website)
                        ->setStore($store)
                        ->load(USWF_Catalog_Helper_Data::DIFF_TIME_CONFIG_PATH, 'path')
                        ->setValue($diff)
                        ->setPath(USWF_Catalog_Helper_Data::DIFF_TIME_CONFIG_PATH)
                        ->save();
                    //Mage::getConfig()->cleanCache();
                }
            }
        }
    }

    /**
     *  If a simple item is marked as "Not For Sale = yes" then all associated bundles or groups also update to "Not For Sale = yes"
     *
     * @param Varien_Event_Observer $observer
     * @throws Exception
     */
    public function catalogProductSaveAfterNotForSale(Varien_Event_Observer $observer){
        $product = $observer->getProduct();
        if ($product->getTypeId() == 'simple'){
            $notForSale = $product->getNotForSale();
            if(!is_null($notForSale) && $notForSale){
                $storeId = $product->getStoreId();
                $parentBundleIds = Mage::getResourceSingleton('bundle/selection')->getParentIdsByChild($product->getId());
                $parentGroupedIds = Mage::getModel('catalog/product_type_grouped')->getParentIdsByChild($product->getId());
                $ids = array_merge($parentBundleIds, $parentGroupedIds);

                $action = Mage::getSingleton('catalog/product_action')->getResource();

                try{
                    $action->updateAttributes( $ids, array("not_for_sale" => 1), 0);
                }catch (Exception $ex){
                    if (Mage::app()->getStore()->isAdmin()) {
                        $this->_getAdminSession()->addException($ex);
                    }
                    Mage::logException($ex);
                }
            }
        }
    }

    /**
     * Check "Not For Sale" attribute after is_salable checking
     * Checking children of the group product
     *
     * @param $observer
     */
    public function checkIsSalable($observer) {
        $product = $observer->getProduct();

        switch($product->getTypeId()){
            case Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE:
                $result = 0;
                if ($product->isAvailable() && !$product->getNotForSale()) {
                    $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
                    foreach ($associatedProducts as $item) {
                        if ($item->isAvailable() && !$product->getNotForSale()) {
                            $result++;
                        }
                    }
                }
                $observer->getSalable()->setIsSalable((boolean)$result);
                break;
            default:
                if(!$product->getParentProductId() && $product->getNotForSale()) {
                    $observer->getSalable()->setIsSalable(false);
                }
                break;
        }
    }

    /**
     * Check "Not For Sale"
     * Upsell Banner should not display if item is NFS
     *
     * @param $observer
     */
    public function filterUpsellNFS(Varien_Event_Observer $observer) {
        $collection = $observer->getCollection();
        if (!is_null($collection)) {
            $collection->addAttributeToFilter('not_for_sale', 0);
        }
    }

}
