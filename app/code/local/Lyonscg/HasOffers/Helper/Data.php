<?php
/**
 * Add support for HasOffers integration
 *
 * @category  Lyons
 * @package   Lyonscg_HasOffers
 * @author    Logan Montgomery <lmontgomery@lyonscg.com>
 * @copyright Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_HasOffers_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function encryptCookie(array $data)
    {
        return Mage::helper('core')->encrypt(base64_encode(serialize($data)));
    }

    public function decryptCookie($encryptedData)
    {
        try {
            return unserialize(base64_decode(Mage::helper('core')->decrypt(urldecode($encryptedData))));
        }
        catch (Exception $e) {
            return false;
        }
    }
}
