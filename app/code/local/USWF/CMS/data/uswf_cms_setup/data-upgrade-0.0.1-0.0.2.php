<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$service_unavailable_content = "<div class=\"page-title\"><h1>We're Offline...</h1></div>
<p>...but only for a few moments. We're working to make the site a better place for you!</p>

<script>
  /* Track 503 Errors */
  var url = \"/503/?url=\" + window.location.pathname + window.location.search + \"&from=\" + document.referrer;
  ga('send', 'pageview', url);
</script>";

$cmsPageCollection = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('identifier', 'service-unavailable');
foreach ($cmsPageCollection as $item) {
    $id = $item->getId();
    $data_array = array (
        'content' => $service_unavailable_content,
        'stores' => Mage::getModel('cms/page')->load($id)->getStoreId(), 
    );
    $page = Mage::getModel('cms/page')->load($id)->addData($data_array);
    $page->setId($id)->save();
}

$no_route_content = "<div class=\"page-head-alt\">
<h3>We are sorry, but the page you are looking for cannot be found.</h3>
</div>
<div>
<ul class=\"disc\">
<li>If you typed the URL directly, please make sure the spelling is correct.</li>
<li>If you clicked on a link to get here, we must have moved the content. Please try our store search box above to search for an item.</li>
<li>If you are not sure how you got here, <!--<a onclick=\"history.go(-1);\" href=\"#\">--><a href=\"#\" onclick=\"history.go(-1); return false;\">go back</a> to the previous page or return to our <a href=\"{{store url=\"\"}}\">store homepage</a>.</li>
</ul>
</div>

<script>
  /* Track 404 Errors */
  var url = \"/404/?url=\" + window.location.pathname + window.location.search + \"&from=\" + document.referrer;
  ga('send', 'pageview', url);
</script>";

$cmsPageCollection = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('identifier', 'no-route');


foreach ($cmsPageCollection as $item) {
    $id = $item->getId();
    $data_array = array (
        'content' => $no_route_content,
        'stores' => Mage::getModel('cms/page')->load($id)->getStoreId(), 
    );
    $page = Mage::getModel('cms/page')->load($id)->addData($data_array);

    $page->setId($id)->save();
}

$installer->endSetup();