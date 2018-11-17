<?php

$installer = $this;
$installer->startSetup();
$cmsPageData = array(
    'title' => 'SmartFIT.com',
    'root_template' => 'one_column',
    'identifier' => 'home',
    'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
    'content' => '{{block type="uswf_smartfit/banners"}}{{block type="uswf_smartfit/featuredproducts"}}'
);

Mage::getModel('cms/page')->setData($cmsPageData)->save();

$installer->endSetup();
