<?php
/**
 * Category.php
 *
 * @category    USWF
 * @package     USWF_Widget
 * @copyright
 * @author
 */

class USWF_Widget_Block_Category extends Lyonscg_Widget_Block_Category implements Mage_Widget_Block_Interface
{
    /**
     * Build the html for the category landing page
     *
     * @param   object  $children - Parent category
     * @return  string  $html
     */
    protected function getCatListHtml($children)
    {
        $categoryList = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect(array('name', 'short_name', 'thumbnail'))
            ->addFieldToFilter('entity_id', array('in' => $children))
            ->addFieldToFilter('name', array('neq' => 'See All Brands'));
        if (get_class($categoryList) == 'Mage_Catalog_Model_Resource_Category_Collection') {
            $categoryList->addExpressionAttributeToSelect(
                'norm_name',
                'IF({{short_name}} IS NULL OR {{short_name}} = "", {{name}}, {{short_name}})',
                array(
                    'short_name' => 'short_name',
                    'name' => 'name'
                )
            );
        } else {
            $categoryList->addExpressionFieldToSelect(
                'norm_name',
                'IF({{short_name}} IS NULL OR {{short_name}} = "", {{name}}, {{short_name}})',
                array(
                    'short_name' => 'short_name',
                    'name' => 'name'
                )
            );
        }
       
        $categoryList->getSelect()->order('norm_name', 'ASC');
        
        return $this->getLayout()
            ->createBlock('core/template', '', array(
                'category_list' => $categoryList,
                'include_name' => $this->getTemplate() != 'catalog/category/sub_category.phtml'
            ))
            ->setTemplate('catalog/category/category_listing.phtml')
            ->toHtml();
    }
}
