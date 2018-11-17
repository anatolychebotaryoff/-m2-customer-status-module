<?php
/**
 * Rewrite for Mage_Catalog_Model_Resource_Category_Flat for breacrumbs using short names
 *
 * @category   Lyons
 * @package    Lyonscg_Catalog
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_Catalog_Model_Resource_Category_Flat extends Mage_Catalog_Model_Resource_Category_Flat
{
    /**
     * Return parent categories of category
     *
     * @param Mage_Catalog_Model_Category $category
     * @param bool $isActive
     * @return array
     */
    public function getParentCategories($category, $isActive = true)
    {
        $categories = array();
        $read = $this->_getReadAdapter();
        $select = $read->select()
            ->from(
                array('main_table' => $this->getMainStoreTable($category->getStoreId())),
                array('main_table.entity_id', 'name' => 'IF(main_table.short_name IS NULL, main_table.name, main_table.short_name)')
            )
            ->joinLeft(
                array('url_rewrite'=>$this->getTable('core/url_rewrite')),
                'url_rewrite.category_id=main_table.entity_id AND url_rewrite.is_system=1 AND '.
                $read->quoteInto('url_rewrite.product_id IS NULL AND url_rewrite.store_id=? AND ',
                    $category->getStoreId() ).
                $read->prepareSqlCondition('url_rewrite.id_path', array('like' => 'category/%')),
                array('request_path' => 'url_rewrite.request_path'))
            ->where('main_table.entity_id IN (?)', array_reverse(explode(',', $category->getPathInStore())));
        if ($isActive) {
            $select->where('main_table.is_active = ?', '1');
        }
        $select->order('main_table.path ASC');
        $result = $this->_getReadAdapter()->fetchAll($select);
        foreach ($result as $row) {
            $row['id'] = $row['entity_id'];
            $categories[$row['entity_id']] = Mage::getModel('catalog/category')->setData($row);
        }
        return $categories;
    }
}
