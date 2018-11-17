<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Widget
 * @copyright
 * @author
 */
class USWF_UniversalVariable_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PATH_EMAIL_LINK_PARAM = 'qubit_universalvariable/QuBit_UniversalVariable_Settings/uv_email_link_param';
    const PATH_EMAIL_COOKIE_TIME = 'qubit_universalvariable/QuBit_UniversalVariable_Settings/uv_email_cookie_lifetime';
    const EMAIL_COOKIE_NAME = 'campaign_email';
    const SALT = 'z4325f42sewwcvfg';
    
    protected static $campaingEmail = false;

    /**
     * Returns campaign email if one is presented
     * 
     * @return mixed
     */
    public function getCampaignEmail() {
        if (!empty(static::$campaingEmail)) {
            return static::$campaingEmail;
        }
        $email = Mage::getSingleton('core/cookie')->get(self::EMAIL_COOKIE_NAME);
        return empty($email) ? false : $this->decryptText($email);
    }

    /**
     * Returns campaign email if one is presented
     * @param string
     * @return void
     */
    public function setCampaignEmail($email) {
        static::$campaingEmail = $email;
        Mage::getSingleton('core/cookie')->set(
            self::EMAIL_COOKIE_NAME,
            $this->encryptText($email),
            Mage::getStoreConfig(self::PATH_EMAIL_COOKIE_TIME)
        );
    }
    
    public function getCampaignEmailParamName() {
        return Mage::getStoreConfig(self::PATH_EMAIL_LINK_PARAM);
    }

    /**
     * Encrypt some text
     * @param $text
     * @return string
     */
    protected function encryptText($text)
    {
        return trim(base64_encode(mcrypt_encrypt(
            MCRYPT_RIJNDAEL_256, self::SALT, 
            $text, 
            MCRYPT_MODE_ECB, 
            mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)
        )));
    }

    /**
     * Decrypt some text
     * @param $text
     * @return string
     */
    protected function decryptText($text)
    {
        return trim(mcrypt_decrypt(
            MCRYPT_RIJNDAEL_256, 
            self::SALT, base64_decode($text), 
            MCRYPT_MODE_ECB, 
            mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)
        ));
    }

    /**
     *  Get attribute for product
     *
     * @param int $entityId
     * @param string $attributeCode
     * @return string|null
     */
    public function getAttributeValue($entityId, $attributeCode){
        $resourceModel = Mage::getResourceModel('catalog/product');
        $attributeRawValue = $resourceModel->getAttributeRawValue($entityId, $attributeCode, Mage::app()->getStore());
        $attribute = $resourceModel->getAttribute($attributeCode)->getSource()->getOptionText($attributeRawValue);

        if ($attribute) {
            return $attribute;
        } else if ($attributeRawValue){
            return $attributeRawValue;
        }
        return null;
    }
}