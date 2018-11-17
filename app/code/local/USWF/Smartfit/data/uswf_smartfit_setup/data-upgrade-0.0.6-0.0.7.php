<?php

$installer = $this;
$installer->startSetup();
$cmsPageData = array(
    'title' => 'SmartFIT.com Dealer Login Page',
    'root_template' => 'one_column',
    'identifier' => 'dealer/account/login',
    'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
    'content' => '{{block type="customer/form_login" template="uswf/dealer_account_login.phtml"}}'
);

Mage::getModel('cms/page')->setData($cmsPageData)->save();

$installer->endSetup();