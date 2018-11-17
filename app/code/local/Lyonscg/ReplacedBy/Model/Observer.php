<?php
/**
 * Replaced By Observer for setting replaced by products from grid
 *
 * @category   Lyons
 * @package    Lyonscg_ReplacedBy
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_ReplacedBy_Model_Observer extends Mage_Core_Model_Abstract
{
    /**
     * Get value from links variable with array key replaced and set replaced link data
     *
     * @param $observer
     */
    public function catalogProductPrepareSave($observer)
    {
        if ($product = $observer->getProduct()) {
            $links = Mage::app()->getRequest()->getPost('links');

            if (isset($links['replaced'])) {
                $data = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['replaced']);
                $product->setReplacedLinkData($data);
            }
        }
    }

}
