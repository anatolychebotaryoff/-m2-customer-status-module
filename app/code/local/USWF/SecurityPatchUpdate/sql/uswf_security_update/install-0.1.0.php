<?php
/**
 * path magento_root/app/code/local/Atwix/Addallowed/sql/atwix_addallowed/install-1.0.0.php
 */
$installer = $this;
 
$installer->startSetup();
 
/**
 * Adding allowed blocks after SUPEE-6788 install
 */
$allowedBlocksArray = array(
    'featuredproducts/listing',
    'cms/block',
    'sharingtool/share',
    'uswf_smartfit/banners',
    'uswf_smartfit/featuredproducts',
    'customer/form_login',
    'uswf_replacementbrand/categories'
);
 
foreach ($allowedBlocksArray as $item) {
    try {
        Mage::getModel('admin/block')->setData('block_name', $item)
            ->setData('is_allowed', 1)
            ->save()
        ;
    } catch(Exception $e) {
        Mage::log($e->getMessage(), null, 'atwix_add_allowed.log', true);
    }
}
 
/**
 * Adding allowed blocks after SUPEE-6788 install
 */
$allowedConfigArray = array(
    'contacts/contacts/phone',
    'contacts/contacts/pure'
);
 
foreach ($allowedConfigArray as $item) {
    try {
        Mage::getModel('admin/variable')->setData('variable_name', $item)
            ->setData('is_allowed', 1)
            ->save()
        ;
    } catch(Exception $e) {
        Mage::log($e->getMessage(), null, 'atwix_add_allowed.log', true);
    }
}
 
$installer->endSetup();