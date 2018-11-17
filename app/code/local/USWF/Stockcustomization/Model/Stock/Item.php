<?php
class USWF_Stockcustomization_Model_Stock_Item extends Mage_CatalogInventory_Model_Stock_Item {
    public function checkQuoteItemQty($qty, $summaryQty, $origQty = 0) {
        /*
	Review the message and if matching string, display a custom message showing when an item will ship
	If the message does not match, just return
       */
        $result = parent::checkQuoteItemQty($qty, $summaryQty, $origQty);
        //This message is returned at the cart page
        if (strpos($result->getMessage(), Mage::helper('core')->__('is not available in the requested quantity')) !== false){
            $expected_interval = $this->getData('expected_ship_interval');
            if ($expected_interval) {
                $message = Mage::helper('core')->__('Out of Stock - Ships in %s business days', $expected_interval );
            }
            else {
               $message = Mage::helper('core')->__('Product will ship when it becomes available');
            }

            $result->setMessage($message);
        }

        return $result;
    }
}
