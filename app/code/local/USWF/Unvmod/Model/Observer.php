<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_Unvmod
 */

class USWF_Unvmod_Model_Observer
{

    /**
     * Set Origin Headers for Transaction Tracking
     *
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function controllerActionPredispatch(Varien_Event_Observer $observer){
        $action = $observer->getControllerAction();
        if($action instanceof Mage_Core_Controller_Varien_Action){
            $action->getResponse()->setHeader('Access-Control-Allow-Origin', 'https://www.googlecommerce.com');
            return $this;
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function catalogControllerProductInitAfter(Varien_Event_Observer $observer){
        $action = $observer->getControllerAction();
        $product = $observer->getProduct();
        $categoryId = null;

        $category = $this->getCategory();
        if (is_null($category)) {
            $currentCatId = current($product->getCategoryIds());
            if ($product->canBeShowInCategory($currentCatId)) {
                $categoryId = $currentCatId;
            }
        }
        if ($categoryId) {
            $category = Mage::getModel('catalog/category')
                ->load($categoryId);
            $product->setCategory($category);
            Mage::register('current_category', $category);
        }
    }

    /**
     * Return current category object
     *
     * @return Mage_Catalog_Model_Category|null
     */
    public function getCategory()
    {
        return Mage::registry('current_category');
    }

    /**
     * Fixed Issue creating order thru Admin on Customer Record
     *
     * @param Varien_Event_Observer $observer
     */
    public function controllerSalesOrderCreateStart(Varien_Event_Observer $observer){
        $action = $observer->getControllerAction();
        if ($customerId = $action->getRequest()->getParam('customer_id')) {
            $customer = Mage::getModel('customer/customer')->load($customerId);
            if($customer->getStoreId() == Mage_Core_Model_App::ADMIN_STORE_ID){
                $storeId = $customer->getWebsiteId();
            }else {
                $storeId = $customer->getStoreId();
            }
            Mage::getSingleton('adminhtml/session_quote')->setStoreId((int) $storeId);
        }
    }
}
