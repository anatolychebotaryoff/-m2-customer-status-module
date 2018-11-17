<?php
/**
 * SEO tree Categories Sitemap block - override [Mage_Catalog]
 *
 * This module overrides the Sitemap Category and adds a check for excluding products
 * which excludes products from sitemap on the frontend, if the "exclude_from_sitemap" field
 * is set to Yes [which is found in the "Meta information" tab when you edit the product]
 *
 * @category   Lyonscg
 * @package    Lyonscg_Sitemapfrontend
 * @author     Ashutosh Potdar <apotdar@lyonscg.com>
 */
class Lyonscg_Sitemapfrontend_Block_Product extends Mage_Catalog_Block_Seo_Sitemap_Product
{
    /**
     * Initialize products collection
     *
     * @return Mage_Catalog_Block_Seo_Sitemap_Category
     */
    protected function _prepareLayout()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */

        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('url_key');
        $collection->addStoreFilter();

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
        // LYONS ADDITION: BEGIN CODE CHANGE
        // Filter by Attribute ID: 249 which is exclude_from_sitemap
        $collection->getSelect()
                 ->join(array('prd_ent_int' => 'catalog_product_entity_int'), '`e`.`entity_id` = `prd_ent_int`.`entity_id` AND `prd_ent_int`.`attribute_id`=249 AND `prd_ent_int`.`value`=0 AND `cat_index`.`store_id`=`prd_ent_int`.`store_id`');
        //END CODE CHANGE
        $this->setCollection($collection);

        return $this;
    }
}
