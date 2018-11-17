<?php
/**
* Block for Category Widget
*
* @category   Lyons
* @package    Lyonscg_Widget
* @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
* @author     Mark Hodge (mhodge@lyonscg.com)
*/

class Lyonscg_Widget_Block_Category extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    protected function _toHtml()
    {
       $widgetType = $this->getWidgetType();

        switch ($widgetType) {
            case 'sub_category':
                $this->setTemplate('catalog/category/sub_category.phtml');
                break;
            case 'brand':
                $this->setTemplate('catalog/category/brand.phtml');
                break;
            }

        return parent::_toHtml();
    }

    /**
     * Load category by ID and then return the object.
     *
     * @param   int     $id
     * @return  object  $category_object
     */
    public function loadCategory($id)
    {
        $categoryObject = Mage::getModel('catalog/category')
                            ->setStoreId($this->storeId)
                            ->load($id);
        return $categoryObject;
    }

    /**
     * Determine if the current category has children.
     * If it does, get the html to display the children by level
     *
     * @param   object  $category
     * @param   int     $levels
     * @return  string  $html
     */
    public function getCatListing()
    {
        $id = Mage::getModel('catalog/layer')->getCurrentCategory()->getId();
        $category = $this->loadCategory($id);

        $children = $this->getChildArray($category);

        if (empty($children[0]))
        {
            $html = 'No sub-categories to list.';
        } else
        {
            $html = $this->getCatListHtml($children);
        }

        return $html;
    }

    /**
     * Turn a string of category ids into an array
     *
     * @param     object     $category
     * @return     array    $children
     */
    protected function getChildArray($category)
    {
        $children = explode(",", $category->getChildren());
        return $children;
    }

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
                            ->addFieldToFilter('name', array('neq' => 'See All Brands'))
                            ->addAttributeToSort('short_name');

        $html = '<ul>';
        $i = 0;
        foreach ($categoryList as $childListing)
        {
            if ($i == 4) {
                $i = 0;
                $html .= '</ul><ul>';
            }
            $childThumb = Mage::getBaseUrl('media').'catalog/category/'.$childListing->getThumbnail();

            if ($this->getTemplate() == 'catalog/category/sub_category.phtml') {
                $includeName = false;
            } else {
                $includeName = true;
            }

            if ($shortName = $childListing->getShortName()) {
                $name = $shortName;
            } else {
                $name = $childListing->getName();
            }

            $html .= '
                        <li class="subCat'.($i == 0 ? ' first' : ($i == 3 ? ' last' : '')).'">
                            <a href="'.$childListing->getUrl().'">
                                <div class="cat-image">
                                    <img src="'.$childThumb.'" alt="'. $name .'">
                                    '. ($includeName ? '<div class="name">'. $name .'</div>' : '') .'
                                </div>
                            </a>
                        </li>';
            $i++;
        }

        $html .= '</ul>';

        return $html;
    }
}