<?php
/**
 * @copyright   Copyright (c) 2011 Amasty (http://www.amasty.com)
 */  
class Amasty_Relater_Model_Catalog_Mysql4_Product_Link extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Link
{
    /**
     * Save Product Links
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $data
     * @param int $typeId
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Link
     */
    public function saveProductLinks($product, $data, $typeId)
    {
        parent::saveProductLinks($product, $data, $typeId);
        
        // we do not un-relate in version 1.0.1      
        if (!is_array($data)) {
            return $this;
        }        
        
        $algorithms = array(
            Mage_Catalog_Model_Product_Link::LINK_TYPE_CROSSSELL => Mage::getStoreConfig('amrelater/general/type_cross'),
            Mage_Catalog_Model_Product_Link::LINK_TYPE_UPSELL    => Mage::getStoreConfig('amrelater/general/type_upsell'),
            Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED   => Mage::getStoreConfig('amrelater/general/type_related'),
        );        
        
        if (empty($algorithms[$typeId]))
            return $this;
         
        // two way    
        if (1 == $algorithms[$typeId]) 
        {
            $ids = array_keys($data);
            foreach ($ids as $id) {
                $this->_createNewLink($typeId, $id, $product->getId());
            }            
        }
        // multiway
        elseif (2 == $algorithms[$typeId]) 
        {
            $ids2 = $ids = array_keys($data);
            $ids2[] = $product->getId(); // we don't need it in the first array as the parent method has done it's job
            foreach ($ids as $id) {
                foreach ($ids2 as $id2) {
                    if ($id == $id2)
                        continue;
                    $this->_createNewLink($typeId, $id, $id2);
                }
            }
        } 
        
        return $this;    
    }
    
    // it can be optimized in the following way
    // select all links, make the check, create one big insert statement
    private function _createNewLink($typeId, $productId, $linkedProductId)
    {
        $db = $this->_getWriteAdapter();
        
        $select = $db->select()->from($this->getMainTable())
            ->where('link_type_id=?', $typeId)           
            ->where('product_id =?', $productId)           
            ->where('linked_product_id =?', $linkedProductId);
        $row = $db->fetchRow($select); 
                      
        if (!$row){
            $db->insert($this->getMainTable(), array(
                'product_id'        => $productId,
                'linked_product_id' => $linkedProductId,
                'link_type_id'      => $typeId
            ));                    
        }
        
        return $this;        
    }
}