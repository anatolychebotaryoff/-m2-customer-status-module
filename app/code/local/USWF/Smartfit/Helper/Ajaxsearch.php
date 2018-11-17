<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Helper_Ajaxsearch extends Cmsmart_Ajaxsearch_Helper_Data
{
    /**
     * Fix for Cmsmart_Ajaxsearch
     * @return array
     */
    public function getCategoriesDropdown() {
        $catItems = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSort('path','asc')
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->load()
            ->getItems();
        $categories = array();
        if (!empty($catItems)) {
            foreach ($catItems as $categoryId => $category) {
                if ($category->getName() && $categoryId > 3) {
                    $categories[] = array(
                        'label' => $category->getName(),
                        'level'  => $category->getLevel(),
                        'value' => $categoryId
                    );
                }
            }
        }
        return $categories;
    }
}