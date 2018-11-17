<?php
/**
 * File Description here....
 *
 * @category   Lyons
 * @package    ${PROJECT_NAME}
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class Lyonscg_Hotdeal_Model_Quote_Address_Total_Subtotal extends Mage_Sales_Model_Quote_Address_Total_Subtotal
{
    /**
     * Collect address subtotal
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_Sales_Model_Quote_Address_Total_Subtotal
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        
        $items = $this->_getAddressItems($address);
        foreach ($items as $item) {
            // We need to set hot deal in quote item so that we do not allow subscription product as well
            if ($item->getProduct()->getHotDeal() == 1) {
                if (!$additionalData = unserialize($item->getAdditionalData())) {
                    $additionalData = array();
                }
                $additionalData[$item->getId()] = 'hotdeal';
                $item->setAdditionalData(serialize($additionalData));
                $item->setHotdeal(1);
            }
        }
        
        return $this;
    }
}
