<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$content = <<<HTML
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad unit 1 -->
<ins class="adsbygoogle"
style="display:inline-block;width:728px;height:90px"
data-ad-client="ca-pub-6026713501728126"
data-ad-slot="8331748695"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
HTML;


$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block');
$block->setTitle('Block Adsense');
$block->setIdentifier('block_adsense');
$block->setStores($store);
$block->setIsActive(1);
$block->setContent($content);
$block->save();

$installer->endSetup();