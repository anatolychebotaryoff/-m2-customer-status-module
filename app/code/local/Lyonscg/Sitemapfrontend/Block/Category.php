<?php

/**
 * SEO tree Categories Sitemap block - override [Mage_Catalog]
 *
 * This module overrides the Sitemap Tree Category and adds a check for excluding categories
 * which excludes categories from sitemap on the frontend, if the "exclude_from_sitemap" field
 * is set to Yes [which is under catalog->categores->Manage Categories via admin panel]
 *
 * @category   Lyonscg
 * @package    Lyonscg_Sitemapfrontend
 * @author     Ashutosh Potdar <apotdar@lyonscg.com>
 * 
 */
class Lyonscg_Sitemapfrontend_Block_Category extends Mage_Catalog_Block_Seo_Sitemap_Tree_Category
{
    /**
     * Prepare array of categories separated into pages
     *
     * @return Mage_Catalog_Block_Seo_Sitemap_Tree_Category
     */
    public function prepareCategoriesToPages()
    {
        $linesPerPage = Mage::getStoreConfig(self::XML_PATH_LINES_PER_PAGE);
        $tmpCollection = Mage::getModel('catalog/category')->getCollection()
            ->addIsActiveFilter()
            ->addPathsFilter($this->_storeRootCategoryPath . '/')
            ->addLevelFilter($this->_storeRootCategoryLevel + 1)
            ->addOrderField('path');
        $count = 0;
        $page = 1;
        $categories = array();
        // LYONS ADDITION: BEGIN CODE CHANGE
        $tmpCollection->addAttributeToFilter('main_table.exclude_from_sitemap', 0);
        // END CODE CHANGE
        foreach ($tmpCollection as $item) {
            $children = $item->getChildrenCount()+1;
            $this->_total += $children;
            if (($children+$count) >= $linesPerPage) {
                $categories[$page][$item->getId()] = array(
                    'path' => $item->getPath(),
                    'children_count' => $this->_total
                );
                $page++;
                $count = 0;
                continue;
            }
            $categories[$page][$item->getId()] = array(
                'path' => $item->getPath(),
                'children_count' => $this->_total
            );
            $count += $children;
        }
        $this->_categoriesToPages = $categories;
        return $this;
    }

}