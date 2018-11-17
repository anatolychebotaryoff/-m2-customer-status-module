<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_OneStepCheckout
 * @copyright
 * @author
 */
class USWF_OneStepCheckout_Helper_Data extends Mage_Catalog_Helper_Data
{
    const CREATE_ACCOUNT_DEFAULT_STATE_CONFIG_PATH = 'onestepcheckout/registration/create_account_behavior';
    /**
     * Returns if default state for "create account" on checkout page is checked
     */
    public function getCreateAccountChecked() {
        return Mage::getStoreConfig(self::CREATE_ACCOUNT_DEFAULT_STATE_CONFIG_PATH);
    }

    /**
     * Check items in cart can be shipped to current state based on attribute ship_no_<location>
     *
     * @param null $regionId
     * @param null $product
     * @param boolean $extendedMessage
     * 
     * @return array
     */
    public function checkItems($regionId = null, $product = null, $extendedMessage = true)
    {
        if (empty($regionId)) {
            return array('error' => -1, 'message' => Mage::helper('checkout')->__('State needs to be entered.'));
        }

        $region = Mage::getModel('directory/region')->load($regionId)->getName();

        // Check if doing just one product or all
        $items = array();
        if (!empty($product)) {
            $noShip = $product->getResource()->getAttribute('ship_no_by_location')
                ->getFrontend()->getValue($product);

            if (!empty($noShip)) {
                if (in_array($region, explode(', ', $noShip))) {
                    $items[] = Mage::helper('checkout')->__('Item %s cannot be shipped to your state.' .
                        ($extendedMessage ? '  Please remove the item and process again.' : ''), $product->getName());
                }
            }
        } else {
            foreach (Mage::getSingleton('checkout/type_onepage')->getQuote()->getAllItems() as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $noShip = $product->getResource()->getAttribute('ship_no_by_location')
                    ->getFrontend()->getValue($product);
                if (!empty($noShip)) {
                    if (in_array($region, explode(', ', $noShip))) {
                        $items[] = Mage::helper('checkout')->__('Item %s cannot be shipped to your state.' . 
                            ($extendedMessage ? '  Please remove the item and process again.' : ''), $product->getName());
                    }
                }
            }
        }

        if (empty($items)) {
            return array();
        } else {
            return array('error' => -1, 'message' => $items);
        }
    }
}