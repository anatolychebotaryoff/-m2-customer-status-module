<?php

$installer = $this;
$installer->startSetup();
$cmsPageData = array(
    'title' => 'ReplacementBrand.com',
    'root_template' => 'one_column',
    'identifier' => 'home',
    'stores' => array(Mage::getModel('core/store')->load('rb_en')->getId()),
    'content' => '{{block type="uswf_replacementbrand/categories" template="catalog/categories.phtml"}}{{block type="catalog/product_new" name="home.catalog.product.new" alias="product_new" template="catalog/product/new.phtml"}}'
);

Mage::getModel('cms/page')->setData($cmsPageData)->save();

$installer->endSetup();
