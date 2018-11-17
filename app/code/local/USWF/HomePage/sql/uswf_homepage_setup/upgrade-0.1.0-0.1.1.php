<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$whitelistBlock = Mage::getModel('admin/block')->load('airfilter/airfilter', 'block_name');
$whitelistBlock->setData('block_name', 'airfilter/airfilter');
$whitelistBlock->setData('is_allowed', 1);
$whitelistBlock->save();

//HP_Finder=================start
$content = <<<HTML
<!-- FILTER FINDER WIDGET -->
<div class="t002-filter-finder-inner-wrapper" style="padding: 2%;">
<div class="finder-col1">
    <a class="t002-fridge-finder-anchor" href="/FridgeFilterFinder">
        <img class="t002-fridge-icon" src="{{media url="wysiwyg/DFS-home-page/70484c00-6383-11e5-8163-5f5a5dc743fd.png"}}"/>
        <img class="t002-fridge-text" src="{{media url="wysiwyg/DFS-home-page/7566dfd0-6383-11e5-8163-5f5a5dc743fd.png"}}"
        alt="Find your refrigerator filter"/>
    </a>
    {{block type="lyonscg_filterfinder/filterFinder" name="filterFinder.hp.widget" template="uswf/homepage/filterFinder/select.phtml"}}
    <a href="#" class="findButton fridge-filter-finder">FIND</a>
</div>
<div class="finder-col2">
    <img class="t002-or-spacer" src="{{media url="wysiwyg/DFS-home-page/76e62cd0-6383-11e5-8163-5f5a5dc743fd.png"}}"
    alt="or"/>
</div>
    <div class="finder-col3">
    <a class="t002-air-finder-anchor" href="/AirFilterFinder">
        <img class="t002-air-icon" src="{{media url="wysiwyg/DFS-home-page/6e4290f0-6383-11e5-8163-5f5a5dc743fd.png"}}"/>
        <img class="t002-air-text" src="{{media url="wysiwyg/DFS-home-page/72cb2650-6383-11e5-8163-5f5a5dc743fd.png"}}"
        alt="Find your refrigerator filter"/>
    </a>
        {{block type="airfilter/airfilter" name="airFilterFinder.hp.widget" template="uswf/homepage/airFilterFinder/select.phtml"}}
        <a href="#" class="findButton air-filter-finder">FIND</a>
    </div>
</div>

<script>
    jQuery(".fridge-filter-finder").click(function (event) {
        event.stopPropagation();
        event.preventDefault();
        var valBrand = jQuery('.finder-brand-select').val();
        if (valBrand != 0) {
            window.location = '/FridgeFilterFinder/?filter_finder_brand=' + valBrand;
        }
    });
    jQuery(".air-filter-finder").click(function (event) {
        event.stopPropagation();
        event.preventDefault();
        var sizeLengthInches = jQuery.trim(jQuery('#size_length_inches').val());
        var sizeWidthInches = jQuery.trim(jQuery('#size_width_inches').val());
        var sizeThicknessInches = jQuery('#size_thickness_inches').val();

        if (sizeLengthInches != "" && sizeWidthInches != "") {
            window.location = '/AirFilterFinder/result?size=' + sizeLengthInches + '+x+' + sizeWidthInches + '+x+' + sizeThicknessInches;
        }
    });
</script>
<!--  <div>
    <img src="{{media url="wysiwyg/DFS-home-page/filter-placeholder.png"}}" alt="" />
  </div>
  END FILTER FINDER WIDGET -->
HTML;
$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_Finder', 'identifier');
if ($block->getId()) {
    $block->setContent($content);
    $block->save();
}
//HP_Finder=================end

//HP_Categories=================start
$content = <<<HTML
<!-- 3X2 CATEGORY AREA -->
  <div id="category-area" class="section group">
    <div class="col span_1_of_3">
      <section id="fridge-filters">
          <a style="color: white;" href="/refrigerator-filters.html"><p class="text-body2">Fridge Filters</a>
          <a class="view-link" href="/refrigerator-filters.html"> View </a></p>
      </section>
    </div>

    <div class="col span_1_of_3" >
      <section id="air-filters">
          <a style="color: white;" href="/air-filters.html"><p class="text-body2">Air Filters </a>
          <a class="view-link" href="/air-filters.html"> View </a></p>
        </section>
    </div>

    <div class="col span_1_of_3">
      <section id="house-filters">
        <a style="color: white;" href="/whole-house-water-filtration.html"><p class="text-body2">Whole House Filters</a>
        <a class="view-link" href="/whole-house-water-filtration.html"> View </a></p>
      </section>
    </div>
  </div>

<!-- END 3X2 CATEGORY AREA -->
  <div id="category-area2" class="section group">
    <div class="col span_1_of_3" >
      <section class="placeholder">
          <a style="color: white;" href="#"><p class="text-body2">#1</a>
          <a class="view-link" href="#"> View </a></p>
      </section>
    </div>

    <div class="col span_1_of_3">
      <section class="placeholder">
          <a style="color: white;" href="#"><p class="text-body2">#2 </a>
          <a class="view-link" href="#"> View </a></p>
        </section>
    </div>

    <div class="col span_1_of_3" >
      <section class="placeholder">
        <a style="color: white;" href="#"><p class="text-body2">#3</a>
        <a class="view-link" href="#"> View </a></p>
      </section>
    </div>
  </div>
  <!-- END 3X2 CATEGORY AREA -->

<script type="text/javascript">
    jQuery("#category-area div").click(function (event) {
       window.location.href = jQuery(this).find('.view-link').attr('href');         
    });
    jQuery("#category-area2 div").click(function (event) {
       window.location.href =jQuery(this).find('.view-link').attr('href');         
    });
</script>
HTML;
$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_Categories', 'identifier');
if ($block->getId()) {
    $block->setContent($content);
    $block->save();
}
//HP_Categories=================end

//HP_css=================start
$content = <<<HTML
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<style>
.ui-menu {
    line-height: 0.8;
    font-style: italic;
}
</style> 

HTML;

$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_css', 'identifier');
if ($block->getId()) {
    $contentOld = $block->getContent();
    $block->setContent($content.$contentOld);
    $block->save();
}
//HP_css=================end

$installer->endSetup();