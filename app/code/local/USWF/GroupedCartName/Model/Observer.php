<?php


class USWF_GroupedCartName_Model_Observer {
    
    protected $_checkedQuoteItems = array();

    public function changeGroupedCartName($observer) {
		$item = $observer->getDataObject();
		$infoBuyRequest = $item->getOptionByCode('info_buyRequest');
		$buyRequest = new Varien_Object(unserialize($infoBuyRequest->getValue()));
        $item->setData('grouped_product_id', $buyRequest->getData('grouped-product-id'));		
		$nfsProduct = $buyRequest->getData('nfs-product');
		if ($nfsProduct) {
		    $item->setData('name', $buyRequest->getData('grouped-product-name'));
		    $item->setData('nfs_item', true);
		}

		return $this;
    }
    
    /*
     * Check quote for Maximum Qty Allowed in Shopping Cart 
     */
    public function checkQuoteItemQty(Varien_Event_Observer $observer) {
        $quote = $observer->getEvent()->getQuote();
        $this->checkMaxItemQty($quote);
    }
    
    /*
     * Check quote for Maximum Qty Allowed in Shopping Cart 
     */
    public function checkQuoteItemQtyAdmin(Varien_Event_Observer $observer) {
        $quote = $quoteItem = $observer->getEvent()->getItem()->getQuote();
        $this->checkMaxItemQty($quote);
    }
    
    /**
     * Get product qty includes information from all quote items
     * Need be used only in sungleton mode
     *
     * @param int   $productId
     * @param int   $quoteItemId
     * @param float $itemQty
     * @return int
     */
    protected function _getQuoteItemQtyForCheck($productId, $quoteItemId, $itemQty)
    {
        $qty = $itemQty;
        if (isset($this->_checkedQuoteItems[$productId]['qty']) &&
            !in_array($quoteItemId, $this->_checkedQuoteItems[$productId]['items'])) {
                $qty += $this->_checkedQuoteItems[$productId]['qty'];
        }

        $this->_checkedQuoteItems[$productId]['qty'] = $qty;
        $this->_checkedQuoteItems[$productId]['items'][] = $quoteItemId;

        return $qty;
    }
    
    /**
     * Removes error statuses from quote and item, set by this observer
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @param int $code
     * @return Mage_CatalogInventory_Model_Observer
     */
    protected function _removeErrorsFromQuoteAndItem($item, $code)
    {
        if ($item->getHasError()) {
            $params = array(
                'origin' => 'cataloginventory',
                'code' => $code
            );
            $item->removeErrorInfosByParams($params);
        }

        $quote = $item->getQuote();
        $quoteItems = $quote->getItemsCollection();
        $canRemoveErrorFromQuote = true;

        foreach ($quoteItems as $quoteItem) {
            if ($quoteItem->getItemId() == $item->getItemId()) {
                continue;
            }

            $errorInfos = $quoteItem->getErrorInfos();
            foreach ($errorInfos as $errorInfo) {
                if ($errorInfo['code'] == $code) {
                    $canRemoveErrorFromQuote = false;
                    break;
                }
            }

            if (!$canRemoveErrorFromQuote) {
                break;
            }
        }

        if ($quote->getHasError() && $canRemoveErrorFromQuote) {
            $params = array(
                'origin' => 'cataloginventory',
                'code' => $code
            );
            $quote->removeErrorInfosByParams(null, $params);
        }

        return $this;
    }
    
    /*
     * Check max quantity in quote
     */
    protected function checkMaxItemQty($quote) {
        $quoteItems = $quote->getAllVisibleItems();
        foreach ($quoteItems as $quoteItem) {
            $quoteItem_id = $quoteItem->getId();
            $additing_qty = 0;
            
           /**
            * Get Qty
            */
           $qty = $quoteItem->getQty();
           /**
            * Check item for options
            */
            $stockItem = $quoteItem->getProduct()->getStockItem();

           if (($options = $quoteItem->getQtyOptions()) && $qty > 0) {
               $qty = $quoteItem->getProduct()->getTypeInstance(true)->prepareQuoteItemQty($qty, $quoteItem->getProduct());
               $quoteItem->setData('qty', $qty);

               foreach ($options as $option) {
                   $optionId = $option->getProduct()->getId();
                    foreach ($quoteItems as $item) {
                        $suboptions = $item->getQtyOptions();
                        $item_qty = $item->getQty();
                        if (!empty($suboptions) && ($item_qty > 0) && ($quoteItem_id != $item->getId())) {
                            foreach ($suboptions as $suboption) {
                                $suboptionId = $suboption->getProduct()->getId();
                                if ($suboptionId==$optionId) {
                                    $suboption_value = $suboption->getValue();
                                    $suboption_qty = $item_qty * $suboption_value;
                                    $additing_qty+=$suboption_qty;
                                } 
                            }
                        } else if($quoteItem_id != $item->getId()) {
                            $product_id = $item->getProduct()->getId();
                            if ($product_id==$optionId) {
                                $additing_qty+=$item_qty;
                            }
                        }
                    }

                   $optionValue = $option->getValue();
                   /* @var $option Mage_Sales_Model_Quote_Item_Option */
                   $optionQty = $qty * $optionValue + $additing_qty;
                   $increaseOptionQty = ($quoteItem->getQtyToAdd() ? $quoteItem->getQtyToAdd() : $qty) * $optionValue;

                   $stockItem = $option->getProduct()->getStockItem();

                   if ($quoteItem->getProductType() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
                       $stockItem->setProductName($quoteItem->getName());
                   }

                   /* @var $stockItem Mage_CatalogInventory_Model_Stock_Item */
                   if (!$stockItem instanceof Mage_CatalogInventory_Model_Stock_Item) {
                       Mage::throwException(
                           Mage::helper('cataloginventory')->__('The stock item for Product in option is not valid.')
                       );
                   }

                   /**
                    * define that stock item is child for composite product
                    */
                   $stockItem->setIsChildItem(true);
                   /**
                    * don't check qty increments value for option product
                    */
                   $stockItem->setSuppressCheckQtyIncrements(true);

                   $qtyForCheck = $this->_getQuoteItemQtyForCheck(
                       $optionId,
                       $quoteItem->getId(),
                       $increaseOptionQty
                   );
                   
                   $result = $stockItem->checkQuoteItemQty($optionQty, $qtyForCheck, $optionValue);

                   if (!is_null($result->getItemIsQtyDecimal())) {
                       $option->setIsQtyDecimal($result->getItemIsQtyDecimal());
                   }

                   if ($result->getHasQtyOptionUpdate()) {
                       $option->setHasQtyOptionUpdate(true);
                       $quoteItem->updateQtyOption($option, $result->getOrigQty());
                       $option->setValue($result->getOrigQty());
                       /**
                        * if option's qty was updates we also need to update quote item qty
                        */
                       $quoteItem->setData('qty', intval($qty));
                   }
                   if (!is_null($result->getMessage())) {
                       $option->setMessage($result->getMessage());
                       $quoteItem->setMessage($result->getMessage());
                   }
                   if (!is_null($result->getItemBackorders())) {
                       $option->setBackorders($result->getItemBackorders());
                   }

                   if ($result->getHasError()) {
                       $option->setHasError(true);

                       $quoteItem->addErrorInfo(
                           'cataloginventory',
                           Mage_CatalogInventory_Helper_Data::ERROR_QTY,
                           $result->getMessage()
                       );

                       $quoteItem->getQuote()->addErrorInfo(
                           $result->getQuoteMessageIndex(),
                           'cataloginventory',
                           Mage_CatalogInventory_Helper_Data::ERROR_QTY,
                           $result->getQuoteMessage()
                       );
                   } else {
                       // Delete error from item and its quote, if it was set due to qty lack
                       $this->_removeErrorsFromQuoteAndItem($quoteItem, Mage_CatalogInventory_Helper_Data::ERROR_QTY);
                   }

                   $stockItem->unsIsChildItem();
               }
           } else {
                /* @var $stockItem Mage_CatalogInventory_Model_Stock_Item */
                if (!$stockItem instanceof Mage_CatalogInventory_Model_Stock_Item) {
                    Mage::throwException(Mage::helper('cataloginventory')->__('The stock item for Product is not valid.'));
                }

                /**
                 * When we work with subitem (as subproduct of bundle or configurable product)
                 */
                $productId = $quoteItem->getProduct()->getId();
                if ($quoteItem->getParentItem()) {
                    $rowQty = $quoteItem->getParentItem()->getQty() * $qty;
                    /**
                     * we are using 0 because original qty was processed
                     */
                    $qtyForCheck = $this->_getQuoteItemQtyForCheck(
                        $productId,
                        $quoteItem->getId(),
                        0
                    );
                } else {
                    $increaseQty = $quoteItem->getQtyToAdd() ? $quoteItem->getQtyToAdd() : $qty;
                    $rowQty = $qty;
                    $qtyForCheck = $this->_getQuoteItemQtyForCheck(
                        $productId,
                        $quoteItem->getId(),
                        $increaseQty
                    );
                }
                
                foreach ($quoteItems as $item) {
                    $suboptions = $item->getQtyOptions();
                    $item_qty = $item->getQty();
                    if (!empty($suboptions) && ($item_qty > 0) && ($quoteItem_id != $item->getId())) {
                        foreach ($suboptions as $suboption) {
                            $suboptionId = $suboption->getProduct()->getId();
                            if ($suboptionId==$productId) {
                                $suboption_value = $suboption->getValue();
                                $suboption_qty = $item_qty * $suboption_value;
                                $additing_qty+=$suboption_qty;
                            } 
                        }
                    } else if($quoteItem_id != $item->getId()) {
                        $product_id = $item->getProduct()->getId();
                        if ($product_id==$productId) {
                            $additing_qty+=$item_qty;
                        }
                    }
                }
                
                $productTypeCustomOption = $quoteItem->getProduct()->getCustomOption('product_type');
                if (!is_null($productTypeCustomOption)) {
                    // Check if product related to current item is a part of grouped product
                    if ($productTypeCustomOption->getValue() == Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE) {
                        $stockItem->setProductName($quoteItem->getProduct()->getName());
                        $stockItem->setIsChildItem(true);
                    }
                }
                $rowQty+=$additing_qty;

                $result = $stockItem->checkQuoteItemQty($rowQty, $qtyForCheck, $qty);

                if ($stockItem->hasIsChildItem()) {
                    $stockItem->unsIsChildItem();
                }

                if (!is_null($result->getItemIsQtyDecimal())) {
                    $quoteItem->setIsQtyDecimal($result->getItemIsQtyDecimal());
                    if ($quoteItem->getParentItem()) {
                        $quoteItem->getParentItem()->setIsQtyDecimal($result->getItemIsQtyDecimal());
                    }
                }

                /**
                 * Just base (parent) item qty can be changed
                 * qty of child products are declared just during add process
                 * exception for updating also managed by product type
                 */
                if ($result->getHasQtyOptionUpdate()
                    && (!$quoteItem->getParentItem()
                        || $quoteItem->getParentItem()->getProduct()->getTypeInstance(true)
                            ->getForceChildItemQtyChanges($quoteItem->getParentItem()->getProduct())
                    )
                ) {
                    $quoteItem->setData('qty', $result->getOrigQty());
                }

                if (!is_null($result->getItemUseOldQty())) {
                    $quoteItem->setUseOldQty($result->getItemUseOldQty());
                }
                if (!is_null($result->getMessage())) {
                    $quoteItem->setMessage($result->getMessage());
                }

                if (!is_null($result->getItemBackorders())) {
                    $quoteItem->setBackorders($result->getItemBackorders());
                }

                if ($result->getHasError()) {
                    $quoteItem->addErrorInfo(
                        'cataloginventory',
                        Mage_CatalogInventory_Helper_Data::ERROR_QTY,
                        $result->getMessage()
                    );

                    $quoteItem->getQuote()->addErrorInfo(
                        $result->getQuoteMessageIndex(),
                        'cataloginventory',
                        Mage_CatalogInventory_Helper_Data::ERROR_QTY,
                        $result->getQuoteMessage()
                    );
                } else {
                    // Delete error from item and its quote, if it was set due to qty lack
                    $this->_removeErrorsFromQuoteAndItem($quoteItem, Mage_CatalogInventory_Helper_Data::ERROR_QTY);
                }
            }
        }

    }

    /**
     * Remove price from Not For Sale
     *
     * @param Varien_Event_Observer $observer
     */
    public function catalogProductGetFinalPrice(Varien_Event_Observer $observer){
        $product = $observer->getProduct();
        if ($product->getNotForSale() == 1){
            $product->setFinalPrice(0);
        }
    }

}
