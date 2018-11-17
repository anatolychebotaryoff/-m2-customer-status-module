<?php

$installer = $this;

$installer->startSetup();

$installData = array(
    array(
        'title' => 'Coupon code valid and applied',
        'identifier' => 'coupon_valid_applied',
        'content' => 'Congratulations, promo code "{{code}}" has been applied to your order: {{rulelabel}}.',
        'is_active' => 1
    ),
    array(
        'title' => 'Coupon code not valid (does not exist)',
        'identifier' => 'coupon_does_not_exist',
        'content' => 'Sorry, we could not find promo code "{{code}}". Please check that you entered it correctly.',
        'is_active' => 1
    ),
    array(
        'title' => 'Coupon code not valid (outside of date range)',
        'identifier' => 'coupon_outside_date_range',
        'content' => 'Sorry, promo code "{{code}}" expired on {{to_date}}.',
        'is_active' => 1
    ),
    array(
        'title' => 'Coupon code not valid (condition not met - i.e. subtotal greater than 25)',
        'identifier' => 'coupon_condition_not_met',
        'content' => 'Sorry, promo code "{{code}}" requires a condition that is not yet met in order to apply: {{rulelabel}}. Please check your shopping cart and try again.',
        'is_active' => 1
    ),
    array(
        'title' => 'Coupon code removed (because of condition not being met)',
        'identifier' => 'coupon_code_removed_condition_not_met',
        'content' => 'Sorry, promo code "{{code}}" has been removed from your cart because a condition of the promotion is no longer met: {{rulelabel}}. Please check your shopping cart and add the code again.',
        'is_active' => 1
    ),
    array(
        'title' => 'Coupon Code is not active',
        'identifier' => 'coupon_code_not_active',
        'content' => 'Sorry, promo code "{{code}}" is not active.',
        'is_active' => 1
    ),
    array(
        'title' => 'Customer Group is not valid',
        'identifier' => 'coupon_code_customer_group_not_met',
        'content' => 'Your customer group is not valid for promo code "{{code}}".',
        'is_active' => 1
    )
);
$stores = array(0);
foreach ($installData as $data) {
    /** @var Mage_Cms_Model_Block $cmsBlock */
    $cmsBlock = Mage::getModel('cms/block')->load($data['identifier']);
    if(!$cmsBlock->getBlockId()){
        $cmsBlock->setIdentifier($data['identifier']);
    }
    $cmsBlock
        ->setTitle($data['title'])
        ->setContent($data['content'])
        ->setIsActive($data['is_active'])
        ->setStores($stores)
        ->save();
}

$installer->endSetup();
