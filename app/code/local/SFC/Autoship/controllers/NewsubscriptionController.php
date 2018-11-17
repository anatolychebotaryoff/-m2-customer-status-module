<?php
/**
 * Subscribe Pro - Subscriptions Management Extension
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of SUBSCRIBE PRO INC.
 *
 * @category  SFC
 * @package   SFC_Autoship
 * @author    Garth Brantley <garth@subscribepro.com>
 * @author    Dennis Rogers <dennis@storefrontconsulting.com>
 * @copyright 2009-2016 SUBSCRIBE PRO INC. All Rights Reserved.
 * @license   http://www.subscribepro.com/terms-of-service/ Subscribe Pro Terms of Service
 * @link      http://www.subscribepro.com/
 *
 */

/**
 * Controller to handle the New Subscription page and subscription creation
 */
class SFC_Autoship_NewsubscriptionController extends Mage_Core_Controller_Front_Action
{
    /**
     * Authenticate customer for all pages and ajax routes supported by this controller
     */
    public function preDispatch()
    {
        parent::preDispatch();
        // Require logged in customer
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
        // Check if extension enabled
        if (Mage::getStoreConfig('autoship_general/general/enabled') != '1') {
            // Send customer to 404 page
            SFC_Autoship::log('SFC Autoship extension not enabled.');
            $this->_forward('defaultNoRoute');
        } elseif (Mage::getStoreConfig('autoship_subscription/new_subscription_page/enable_new_subscription_page') != '1') {
            SFC_Autoship::log('New subscription page is not enabled.');
            $this->_forward('defaultNoRoute');
        }
    }

    /**
     * Render the Create New Subscription page
     *
     * Accept query parameters for product id / sku, quantity and interval
     */
    public function indexAction()
    {
        try {
            $subscription = $this->createSubscriptionFromArray($this->processQueryParameters());
            // Load layout from XML and set page title, then render the page
            $this->loadLayout();
            $this->getLayout()->getBlock('newsubscription')->setSubscription($subscription);
            $this->getLayout()->getBlock('head')->setTitle($this->__('Create New Product Subscription'));
            $this->renderLayout();
        }
        catch (Exception $e) {
            // If we have an error, log it and show a 404 page
            SFC_Autoship::log($e->getMessage());
            $this->_forward('defaultNoRoute');
        }
    }

    /**
     * Create subscription action
     */
    public function createPostAction()
    {
        try {
            if (!$this->getRequest()->isPost()) {
                Mage::throwException('This page must be accessed via POST.');
            }

            // Set helper objects
            $platform = Mage::helper('autoship/platform');

            $subscription = $this->createSubscriptionFromArray($this->processQueryParameters());

            // Do basic data validation
            // nothing complex, just checking that a value is present
            if (0 >= (int) $subscription->getQty()) {
                Mage::throwException('Please set a quantity of one or more.');
            }

            if ($subscription->getIntervalText() == '') {
                Mage::throwException('Please select an interval.');
            }

            if ($subscription->getNextOrderDate() == '') {
                Mage::throwException('Please select a date for your first shipment.');
            }

            // Create subscription via API
            $platform->createSubscription($subscription);

            // Output URL to redirect customer on successful subscription creation
            echo Mage::getUrl('*/mysubscriptions/index', array('_secure' => true));
        }
        catch (Exception $e) {
            SFC_Autoship::log($e->getMessage());
            SFC_Autoship::logException($e);
            if (strpos($e->getMessage(), '1062 Duplicate entry')) {
                echo '<li class="error">' . $this->__("You already have a subscription to this product.") . '</li>';
            }
            else {
                echo '<li class="error">' . $this->__($e->getMessage()) . '</li>';
            }
        }
    }

    /**
     * Grab query parameters, escape and validate them
     *
     * Looks for the following parameters in the request.
     * Only one of product_id and product_sku is required
     * The other parameters will receive a default value if not given
     *
     *      product_id, product_sku, qty, interval, delivery_date,
     *
     * @return array Processed query parameters, ready for use
     * @throws \Exception
     */
    protected function processQueryParameters()
    {
        // Get params from request
        $params = $this->getRequest()->getParams();

        $id_type = $id_value = '';
        if (!empty($params['product_id'])) {
            $id_type = 'id';
            $id_value = !empty($params['product_id']) ? $params['product_id'] : '';
        } elseif (!empty($params['product_sku'])) {
            $id_type = 'sku';
            $id_value = !empty($params['product_sku']) ? $params['product_sku'] : '';
        }

        if(empty($id_value)) {
            Mage::throwException('No product_id or product_sku given.');
        }

        $product = $this->loadProduct($id_value, $id_type);

        if (!$product->getId()) {
            Mage::throwException('Product with ' . $id_type . ' "' . $id_value . '" does not exist.');
        }

        $subscriptionAvailable = Mage::helper('autoship/product')->isAvailableForSubscription($product);

        if (!$subscriptionAvailable) {
            Mage::throwException('Product with ' . $id_type . ' "' . $id_value . '" is not enabled for subscriptions.');
        }

        return array(
            'product'       => $product,
            'product_id'    => $product->getId(),
            'product_sku'   => $product->getSku(),
            'qty'           => !empty($params['qty']) && $params['qty'] > 0 ? $params['qty'] : 1,
            'interval'      => !empty($params['interval']) ? $params['interval'] : '',
            'delivery_date' => !empty($params['delivery_date']) ? strtotime($params['delivery_date']) : strtotime('+2 days'),
        );
    }

    /**
     * Load a product based on Magento Product ID or SKU.
     *
     * @param string $value Actual ID or SKU for product
     * @param string $type 'id' or 'sku'
     * @return Mage_Catalog_Model_Product
     */
    protected function loadProduct($value, $type = 'id')
    {
        $productModel = Mage::getModel('catalog/product');

        // If we were given the product SKU, use that to get the product ID
        $product_id = $type == 'sku' ? $productModel->getIdBySku($value) : $value;

        // Return the product
        return $productModel->load($product_id);
    }

    /**
     * Build a new subscription model object based on the (already processed) query parameters
     *
     * @param array $subscriptionData Array of already validated and processed query parameters
     * @return SFC_Autoship_Model_Subscription
     */
    protected function createSubscriptionFromArray(array $subscriptionData)
    {
        // Get current customer from session
        $customerSession = Mage::getSingleton('customer/session');
        $customer = $customerSession->getCustomer();

        $subscription = Mage::getModel('autoship/subscription');
        $subscription->setNextOrderDate(date('Y-m-d', $subscriptionData['delivery_date']))
            ->setProductId($subscriptionData['product_id'])
            ->setProduct($subscriptionData['product'])
            ->setCustomerId($customer->getId())
            ->setQty($subscriptionData['qty'])
            ->setInterval($subscriptionData['interval']);

        // Check min / max qty
        $product = Mage::getModel('catalog/product')->load($subscriptionData['product_id']);
        $platformProduct = Mage::helper('autoship/platform')->getPlatformProduct($product);
        if($subscription->getData('qty') < $platformProduct->getData('min_qty')) {
            $subscription->setData('qty', $platformProduct->getData('min_qty'));
            $customerSession->addError($this->__('Minimum quantity for subscription is %s', $platformProduct->getData('min_qty')));
        }
        if($subscription->getData('qty') > $platformProduct->getData('max_qty')) {
            $subscription->setData('qty', $platformProduct->getData('max_qty'));
            $customerSession->addError($this->__('Maximum quantity for subscription is %s', $platformProduct->getData('max_qty')));
        }

        // Return the new subscription model
        return $subscription;
    }
}
