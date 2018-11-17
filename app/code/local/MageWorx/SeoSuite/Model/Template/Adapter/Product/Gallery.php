<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */
class MageWorx_SeoSuite_Model_Template_Adapter_Product_Gallery extends MageWorx_SeoSuite_Model_Template_Adapter_Product_Abstract
{

    public function apply($from, $limit, $template = null, $list = array())
    {
        $template = Mage::getModel('seosuite/catalog_product_template_gallery');
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'media_gallery');
        $attributeId = $attribute->getAttributeId();

        $connection  = Mage::getSingleton('core/resource')->getConnection('core_write');
        $tablePrefix = (string) Mage::getConfig()->getTablePrefix();

        $select = $connection->select()
                ->from($tablePrefix . 'catalog_product_entity')
                ->limit($limit, $from);
        $products = $connection->fetchAll($select);

        $select = $connection->select()
                ->from(array('main_table' => $tablePrefix . 'core_store'))
                ->joinLeft(array('seo_store_template' => $tablePrefix . 'seosuite_template_store'),
                        'main_table.store_id=seo_store_template.store_id', 'seo_store_template.template_key')
                ->where('seo_store_template.template_id =' . Mage::registry('seosuite_template_current_model')->getId() . ' OR seo_store_template.template_id IS NULL');
        $stores = $connection->fetchAll($select);

        foreach ($stores as $key => $storeArray) {
            $store = Mage::app()->getStore($storeArray['store_id']);
            if ($store->isAdmin()) {
                $store->setData('template_key', $storeArray['template_key']);
                $this->_defaultStore = $store;
                //       unset($stores[$key]);
            }
        }

        foreach ($products as $_product) {

            $defaultGalleries = null;

            foreach ($stores as $store) {
                $storeId        = $store['store_id'];
                $templateString = ($store['template_key']) ? $store['template_key'] : $this->_defaultStore->getTemplateKey();
                $product        = Mage::getModel('catalog/product')->setStoreId($storeId)->load($_product['entity_id']);
                $template->setTemplate($templateString)->setProduct($product);
                $attributeName  = $template->process();

                $select = $connection
                            ->select()
                            ->from(array('main_table' => $tablePrefix . 'catalog_product_entity_media_gallery'))
                            ->joinLeft(
                                array('label_table' => $tablePrefix . 'catalog_product_entity_media_gallery_value'),
                                'main_table.value_id = label_table.value_id',
                                array('*'))
                            ->where("attribute_id = $attributeId AND entity_id = {$product->getId()} AND store_id = {$storeId}");

                $galleries = $connection->fetchAll($select);

                //Mage::log($attributeName, null, 'insert.log');
                //Mage::log($galleries, null, 'insert.log');

                if(is_array($galleries) && count($galleries) != 0){

                    if($storeId == $this->_defaultStore->getId()){
                        $defaultGalleries = $galleries;
                    }

                    foreach($galleries as $gallery){

                        if($gallery['label'] == ''){
                           //continue;
                        }else{
                           //continue;
                        }

                        $connection->update(
                            $tablePrefix . 'catalog_product_entity_media_gallery_value',
                            array('label' => $attributeName),
                            "value_id = {$gallery['value_id']} AND store_id = {$gallery['store_id']}"
                        );

                    }
                }elseif(is_array($galleries) && count($galleries) == 0 && is_array($defaultGalleries)){

                    //If the product was saved for a store level, it already will have a record - usually there is no sense to insert.
                    /*
                    foreach($defaultGalleries as $gallery){
                        $data['value_id'] = $gallery['value_id'];
                        $data['store_id'] = $storeId;
                        $data['label']    = $attributeName;
                        $data['position'] = $gallery['position'];
                        $data['disabled'] = $gallery['disabled'];
                        $connection->insert($tablePrefix . 'catalog_product_entity_media_gallery_value', $data);
                    }
                     */
                }
            }
        }
    }

}