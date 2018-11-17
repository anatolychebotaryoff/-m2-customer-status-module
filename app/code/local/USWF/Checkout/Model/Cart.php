<?php
/**
 * Cart.php
 *
 * @category    USWF
 * @package     USWF_Checkout
 * @copyright
 * @author
 */
class USWF_Checkout_Model_Cart extends Enterprise_Checkout_Model_Cart implements Mage_Checkout_Model_Cart_Interface
{
    /**
     * Retrieve info message
     *
     * @return array
     */
    public function getMessages()
    {
        $affectedItems = $this->getAffectedItems();
        $failedItemsCount = 0;
        $addedItemsCount = 0;
        $failedSkuItemsCount = 0;

        foreach ($this->_currentlyAffectedItems as $sku) {
            if (isset($affectedItems[$sku]['code'])) {
                switch ($affectedItems[$sku]['code']) {
                    case Enterprise_Checkout_Helper_Data::ADD_ITEM_STATUS_SUCCESS:
                        $addedItemsCount++;
                        break;
                    case Enterprise_Checkout_Helper_Data::ADD_ITEM_STATUS_FAILED_SKU:
                        $failedSkuItemsCount++;
                        break;
                    //all other error messages
                    default:
                        $failedItemsCount++;
                        break;
                }
            }
        }
        
        $messages = array();
        if ($failedSkuItemsCount) {
            $warning = ($failedSkuItemsCount == 1)
                ? Mage::helper('enterprise_checkout')->__('The SKU you entered was not found in our catalog. Please enter a valid SKU or use our search feature to find your item')
                : Mage::helper('enterprise_checkout')->__('%s SKUs you entered was not found in our catalog. Please enter a valid SKUs or use our search feature to find your items', $failedSkuItemsCount);
            $messages[] = Mage::getSingleton('core/message')->error($warning);
        }
        if ($addedItemsCount) {
            $message = ($addedItemsCount == 1)
                ? Mage::helper('enterprise_checkout')->__('%s product was added to your shopping cart.', $addedItemsCount)
                : Mage::helper('enterprise_checkout')->__('%s products were added to your shopping cart.', $addedItemsCount);
            $messages[] = Mage::getSingleton('core/message')->success($message);
        }
        if ($failedItemsCount) {
            $warning = ($failedItemsCount == 1)
                ? Mage::helper('enterprise_checkout')->__('%s product can not be added to your shopping cart.', $failedItemsCount)
                : Mage::helper('enterprise_checkout')->__('%s products can not be added to your shopping cart.', $failedItemsCount);
            $messages[] = Mage::getSingleton('core/message')->error($warning);
        }
        return $messages;
    }

    /**
     * Returns successed products count
     *
     * @return int
     */
    public function getSuccessedProductsCount()
    {
        $affectedItems = $this->getAffectedItems();
        $successedItems = 0;
        foreach ($affectedItems as $item) {
            if ($item['code'] == Enterprise_Checkout_Helper_Data::ADD_ITEM_STATUS_SUCCESS) {
                $successedItems++;
            }
        }
        return $successedItems;
    }
}