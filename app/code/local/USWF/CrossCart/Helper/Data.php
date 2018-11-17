<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_CrossCart
 * @copyright
 * @author
 */
class USWF_CrossCart_Helper_Data extends Mage_Catalog_Helper_Data
{
    const PERSISTENT_CART_COOKIE_NAME = 'persistent_cart';
    const PERSISTENT_CART_COOKIE_LIFETIME = 15552000;    // 180 days in seconds: 30days * 24hours * 60mins * 60sec
    
    /**
     * Encrypt data
     * @param mixed $data
     * @return string
     */
    public function encryptCookie($data)
    {
        return Mage::helper('core')->encrypt(base64_encode(serialize($data)));
    }

    /**
     * Decrypt data
     * @param string $encryptedData
     * @return bool|mixed
     */
    public function decryptCookie($encryptedData)
    {
        try {
            return unserialize(base64_decode(Mage::helper('core')->decrypt($encryptedData)));
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Set persistent quote id cookie
     * @param $quoteId
     * @return void
     */
    public function setPersistentQuoteId($quoteId) {
        Mage::getSingleton('core/cookie')->set(
            self::PERSISTENT_CART_COOKIE_NAME,
            $this->encryptCookie($quoteId),
            self::PERSISTENT_CART_COOKIE_LIFETIME
        );
    }

    /**
     * Get persistent quote id cookie value
     * @return int
     */
    public function getPersistentQuoteId() {
        $value = Mage::getSingleton('core/cookie')->get(self::PERSISTENT_CART_COOKIE_NAME);
        if (
            $value && ($value = $this->decryptCookie($value)) && 
            ($quote = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore()->getId())->load($value)) && 
            $quote->getId()
        ) {
            return $value;
        } else {
            return false;
        }
    }

    /**
     * Delete persistent quote id cookie
     * @return void
     */
    public function unsPersistentQuoteId() {
        Mage::getSingleton('core/cookie')->delete(self::PERSISTENT_CART_COOKIE_NAME);
    }

    /**
     * Renew persistent quote id cookie
     * @return void
     */
    public function renewPersistentQuoteId() {
        Mage::getSingleton('core/cookie')->renew(
            self::PERSISTENT_CART_COOKIE_NAME,
            self::PERSISTENT_CART_COOKIE_LIFETIME
        );
    }
}