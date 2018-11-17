<?php
/**
 * Enter description here ...
 *
 * @category   Lyons
 * @package    Lyonscg_ReplacedBy
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_ReplacedBy_Model_Product_Link extends Mage_Catalog_Model_Product_Link
{
    const LINK_TYPE_REPLACED = 6;

    public function useReplacedLinks()
    {
        $this->setLinkTypeId(self::LINK_TYPE_REPLACED);
        return $this;
    }

    public function saveProductRelations($product)
    {
        $data = $product->getReplacedLinkData();
        if (!is_null($data)) {
            $this->_getResource()->saveProductLinks($product, $data, self::LINK_TYPE_REPLACED);
        }
        return(parent::saveProductRelations($product));
    }

}

