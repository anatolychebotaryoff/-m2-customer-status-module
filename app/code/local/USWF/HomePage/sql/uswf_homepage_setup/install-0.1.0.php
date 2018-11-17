<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$whitelistBlock = Mage::getModel('admin/block')->load('lyonscg_filterfinder/filterFinder', 'block_name');
$whitelistBlock->setData('block_name', 'lyonscg_filterfinder/filterFinder');
$whitelistBlock->setData('is_allowed', 1);
$whitelistBlock->save();

//HP_Hero1=================start
$content = <<<HTML
<!-- HERO AREA -->
  <div id="homepage_oasis_standard">
    <a href="/tier1-filters.html">
    <!--  <img style="padding-bottom:2%;" src="{{media url="wysiwyg//DFS-home-page/hero-banner.jpg"}}" alt="Banner: The filters you need up to 70% off" /> -->
    </a>
  </div>
<!-- END HERO AREA -->
HTML;
$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_Hero1', 'identifier');
if (!$block->getId()) {
    $block->setTitle('DFS HP_Hero1');
    $block->setIdentifier('HP_Hero1');
    $block->setStores($store);
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();
}
//HP_Hero1=================end

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
        <input id="size_length_inches"/>
        <span class="filter-input-spacer">x</span>
        <input id="size_width_inches"/>
        <span class="filter-input-spacer">x</span>
        <label class="air-filter-finder-label">
            <select class="air-filter-finder-select" id="size_thickness_inches">
                <option value='1' selected>1</option>
                <option value='2'>2</option>
                <option value='4'>4</option>
            </select>
        </label>
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
if (!$block->getId()) {
    $block->setTitle('DFS HP_Finder');
    $block->setIdentifier('HP_Finder');
    $block->setStores($store);
    $block->setIsActive(1);
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

    <div class="col span_1_of_3">
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
  </div><!-- END 3X2 CATEGORY AREA -->

  <div id="category-area2" class="section group">
    <div class="col span_1_of_3">
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

    <div class="col span_1_of_3">
      <section class="placeholder">
        <a style="color: white;" href="#"><p class="text-body2">#3</a>
        <a class="view-link" href="#"> View </a></p>
      </section>
    </div>
  </div>
  <!-- END 3X2 CATEGORY AREA -->
HTML;
$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_Categories', 'identifier');
if (!$block->getId()) {
    $block->setTitle('DFS HP_Categories');
    $block->setIdentifier('HP_Categories');
    $block->setStores($store);
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();
}
//HP_Categories=================end

//HP_Hero2=================start
$content = <<<HTML
<!-- TIER1 CTA -->
  <section class="tier1-cta">
    <div class="text-left">
      <h2 style="font-size: 28px; font-weight: bolder;"> TIER1&reg; FILTERS</h2>
      <h2 style="color:#0165b6; line-height: 1.6em; padding-top: 5px;">The clean water & air you deserve <br> at a fraction of the price</h2>

      <ul id="tier1-list">
        <li> Largest Selection of Filters</li>
        <li> Best Quality & Best Value Guarantee</li>
        <li> Millions of Happy Customers</li>
      </ul>

      <a href="/tier1-filters.html" class="myButton">Shop Tier1 Products</a>
    </div>

    <div class="img-right">
      <a href="/tier1-filters.html"><img src="{{media url="wysiwyg/DFS-home-page/tier1_products.jpg"}}" alt="Tier1 Filter - Product Image" /></a>
    </div>
  </section><!-- END TIER1 CTA -->
HTML;
$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_Hero2', 'identifier');
if (!$block->getId()) {
    $block->setTitle('DFS HP_Hero2');
    $block->setIdentifier('HP_Hero2');
    $block->setStores($store);
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();
}
//HP_Hero2=================end

//HP_Top_Products=================start
$content = <<<HTML
<div></div>
HTML;
$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_Top_Products', 'identifier');
if (!$block->getId()) {
    $block->setTitle('DFS HP_Top_Products');
    $block->setIdentifier('HP_Top_Products');
    $block->setStores($store);
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();
}
//HP_Top_Products=================end

//HP_Resource_Center=================start
$content = <<<HTML
<!-- SOLUTIONS AREA -->
  <div class="titles">
    <h3> We'll help solve your problem and provide a solution </h3>
  </div>

    <div id="solutions" style="margin-bottom: 2%;" class="section group">

        <div class="col span_1_of_3">
          <section id="water-smell">
            <p class="text-body">Does your water <br> smell strange?
            <a class="learn-link" href="#">Learn More</a></p>
          </section>
        </div>

        <div class="col span_1_of_3">
          <section id="water-taste">
            <p class="text-body">Does your water <br> taste bad?
            <a class="learn-link" href="#">Learn More</a></p>
          </section>
        </div>

        <div  class="col span_1_of_3">
          <section id="water-color">
            <p class="text-body">Does your water <br> have an odd color?
            <a class="learn-link" href="#">Learn More</a></p>
          </section>
      </div>
    </div>  
<!-- END SOLUTIONS AREA -->
<!-- 3 ICON AREA -->
  <div class="titles">
    <h3 style="padding-top: 0; margin-top: 0;"> Get the right filter from those that know clean water & air </h3>
  </div>

  <div id="icons-3" style="margin-bottom: 4%;" class="section group">
    <div class="col span_1_of_3">
      <div class="img-left">
        <a href="/no-worries-air-water-filter-guarantee.html"><img style="width: 150px; height:auto;" src="{{media url="wysiwyg/DFS-home-page/guarantee-icon.png"}}" alt="Order Guarantee Icon" /></a>
      </div>

      <div class="text-right">
        <h3 style="text-align: left; font-size:16px;">Order Guarantee</h3>
          <p>When we promise to provide you the best price on air filters and water filters that are guaranteed to fit, we mean it!
            <br>
          <a href="/no-worries-air-water-filter-guarantee.html">Learn more.</a></p>
      </div>
    </div>

    <div class="col span_1_of_3">
      <div class="img-left">
        <a href="/shipping.html"><img style="width: 150px; height:auto;" src="{{media url="wysiwyg/DFS-home-page/shipping-icon.png"}}" alt="Same Day Shipping Icon" /></a>
      </div>

      <div class="text-right">
        <h3 style="text-align: left; font-size:16px;">Same Day Shipping</h3>
        <p>All orders of in-stock products placed by 4pm CST will ship the same business day. Better yet, most orders ship FREE!
          <br>
        <a href="/shipping.html">Learn more.</a></p>
      </div>
    </div>

    <div class="col span_1_of_3">
      <div class="img-left">
        <a href="http://blog.discountfilterstore.com/"><img style="width: 150px; height:auto;" src="{{media url="wysiwyg/DFS-home-page/customer-icon.png"}}" alt="Water News Blog Icon" /></a>
      </div>

      <div class="text-right">
        <h3 style="text-align: left; font-size:16px;">Water News Blog</h3>
          <p>See the latest healthy living news and filtration tips – plus the latest filter sales and discounts.
            <br>
          <a href="http://blog.discountfilterstore.com/">Learn more.</a></p>
      </div>
    </div>
  </div>
<!-- END 3 ICON AREA -->

<!-- RESOURCE CENTER AREA -->
  <div class="rc-title">
    <h3 class="resource-center-tag"><a href="/resource-center.html"> Resource Center </a> </h3>
  </div>

    <section class="resource-center">
      <div class="group resource-center-div">

        <div class="col span_1_of_3">
          <a href="/whole-home-water-filtration-systems.html"><img src="{{media url="wysiwyg/DFS-home-page/whole-guide-icon.png"}}" alt="Whole House Icon" />
          </a>
          <p>Learn how to set up your whole house filtration system</p>
          <a href="/whole-home-water-filtration-systems.html" class="guide-button">Read Guide</a>
        </div>

        <div class="col span_1_of_3">
          <a href="#"><img src="{{media url="wysiwyg/DFS-home-page/buying-guide-icon.png"}}" alt="Tag Icon" />
          </a>
          <p>Check out our free buying guide and shop with confidence</p>
          <a href="#" class="guide-button">Read Guide</a>
        </div>

        <div class="col span_1_of_3">
          <a href="#"><img src="{{media url="wysiwyg/DFS-home-page/water-taste-great-icon.png"}}" alt="Water Drop Icon" />
          </a>
          <p>Read our how-to guide on how to ensure your water tastes great!</p>
          <a href="#" class="guide-button">Read Guide</a>
        </div>
    
    </section><!-- END RESOURCE CENTER AREA -->

<script>
function maxHeightP(elem) {
jQuery(elem).css("height","");
if (jQuery(window).width() > 883) {
var heights = jQuery(elem).map(function ()
    {
        return jQuery(this).height();
    }).get();
var maxHeight = Math.max.apply(null, heights) + 5;
jQuery(elem).css("height",maxHeight  +  "px");
} 
}

maxHeightP('.resource-center-div .span_1_of_3 p');
jQuery(window).bind('resize',function(){
maxHeightP('.resource-center-div .span_1_of_3 p');
});

</script>
HTML;
$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_Resource_Center', 'identifier');
if (!$block->getId()) {
    $block->setTitle('DFS HP_Resource_Center');
    $block->setIdentifier('HP_Resource_Center');
    $block->setStores($store);
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();
}
//HP_Resource_Center=================end

//HP_css=================start
$content = <<<HTML
<style>
    /* FILTER FINDER */

.t002-filter-finder-inner-wrapper label {
   margin-right: 5px;
}
.t002-filter-finder-wrapper img {
    height: 15px;
}

.t002-filter-finder-wrapper {
    width: 100%;
    text-align: center;
    position: relative;
    top: -10px;
    opacity: 0;
    height: 15px;
    padding-top: 0px;
    border-bottom: 1px solid #aaa;
    box-shadow: 1px 1px 1px rgba(51, 51, 51, 0.3);
}

.t002-fridge-finder-anchor {
    cursor: pointer;
}

.t002-fridge-icon {
    height: 32px;
    margin-top: 0px;
}

.t002-fridge-text {
    margin: 5px 5px 0;
    height: 26px;
}

.t002-air-finder-anchor {
    cursor: pointer;
}

.t002-air-icon {
    height: 40px;
    margin-top: 0;
}

.t002-air-text {
    margin: 10px 19px 0;
    height: 26px;
}

.t002-find-button {
    cursor: pointer; /*background-color: #f57f17;*/
    background-color: #ff6633;
    border: none;
    border-radius: 3px; /*color: #454040;*/
    color: #ffffff;
    padding: 7px 18px 6px 18px;
    font-family: 'Arial Bold', Arial, Helvetica, sans-serif;
    font-weight: bold;
    font-size: 13px;
    margin-top: 6px;
}

.nav-container {
    z-index: inherit;
}

.t002-air-text {
    margin: 6px 10px 0;
}

@media (max-width: 810px) {
    .t002-filter-finder-wrapper {
        top: -10px;
    }
}

.t002-or-spacer {
    height: 20px;
    margin-top: 6px;
    margin-left: 10px;
    margin-right: 10px;
}

.t002-air-icon {
    height: 35px;
    margin-top: 0;
}

.t002-air-text {
    margin: 5px 13px 0;
    height: 26px;
}

.t002-find-button {
    padding: 6px 16px 7px 16px;
    font-size: 12px;
    margin-top: 6px;
}

@media (max-width: 768px) {
    .t002-filter-finder-wrapper {
        display: none;
    }
}

/* OVERIDE THE MAIN CSS */
.grid_24 {
    margin-left: 0;
    margin-right: 0;
}

.hp-container {
    margin-left: auto;
    margin-right: auto;
    width: 95%
}

.block-subscribe {
    display: none;
}

/* END MAIN CSS */
#homepage_oasis_standard {
    height: 230px;
    background-image: url("{{media url="wysiwyg/DFS-home-page/hero-banner.jpg"}}");
}

h3 {
    text-transform: uppercase;
    text-align: center;
    color: #696969;
    font-size: 2em;
}

/* H3 CLASS */
.titles {
    background-color: white;
    padding: 6px 1%;
}

.titles h3 {
    font-size: 1.8em;
}

section {
    display: block;
}

/* 3X2 CATEGORY AREA */
#fridge-filters {
    background-image: url("{{media url="wysiwyg/DFS-home-page/fridge-filters-category.png"}}");
}

#air-filters {
    background-image: url("{{media url="wysiwyg/DFS-home-page/air-filter-category.png"}}");
}

#house-filters {
    background-image: url("{{media url="wysiwyg/DFS-home-page/whole-house-category.png"}}");
}

.placeholder {
    background-image: url("{{media url="wysiwyg/DFS-home-page/placeholder.png"}}");
    padding-top: 47.2%;
    color: white;
    padding-left: 3%;
}

.placeholder .view-link {
    position: absolute;
    right: 45px;
    color: white;
}

.placeholder .view-link:hover {
    color: #ff8d00;
}

#house-filters, #air-filters, #fridge-filters, .placeholder {
    width: 97%;
    height: auto;
    background-repeat: no-repeat;
    background-size: 98.666%;
}

#house-filters, #air-filters, #fridge-filters {
    padding-top: 47%;
    color: white;
    padding-left: 3%;
}

.text-body2 {
    color: white;
    position: relative;
    top: -3px;
    padding-left: 3%;
    line-height: 1.8em;
    font-size: 2.1em;
}

#house-filters .view-link {
    color: white;
    position: absolute;
    right: 40px;
}

#air-filters .view-link {
    color: white;
    position: absolute;
    right: 45px;
}

#fridge-filters .view-link {
    color: white;
    position: absolute;
    right: 45px;
}

#house-filters .view-link:hover {
    color: #ff8d00;
}

#air-filters .view-link:hover {
    color: #ff8d00;
}

#fridge-filters .view-link:hover {
    color: #ff8d00;
}

/* END 3X2 CATEGORY AREA */ /* TIER CTA */
.tier1-cta {
}

ul {
    font-size: 16px;
    font-weight: 400;
    line-height: 30px;
    list-style-image: url('wysiwyg/DFS-home-page/check.png');
}

.img-right img {
    padding: 2%;
    margin-left: 1%;
    margin-bottom: 5%;
}

.text-left {
    float: left;
    padding: 2%;
    margin-top: 5%;
    margin-left: 3%;
}

.text-left h2 {
    color: #29a0d5;
    font-weight: bolder;
    text-transform: uppercase;
}

.myButton {
    background-color: #42ad49;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    display: inline-block;
    cursor: pointer;
    color: #ffffff;
    font-family: Arial;
    font-size: 18px;
    padding: 13px 40px;
    text-decoration: none;
}

.myButton:hover {
    background-color: #5cbf2a;
}

.myButton:active {
    position: relative;
    top: 1px;
}

/* END TIER CTA */ /* SECTIONS */
.section {
    clear: both;
    padding: 0px;
    margin: 0px;
}

/* COLUMN SETUP */
.col {
    display: block;
    float: left;
    margin: 1% 0 1% 1.6%;
}

.col:first-child {
    margin-left: 0;
}

/* GROUPING */
.group:before, .group:after {
    content: "";
    display: table;
}

.group:after {
    clear: both;
}

.group {
    zoom: 1; /* For IE 6/7 */
}

/* GRID OF THREE */
.span_3_of_3 {
    width: 100%;
}

.span_2_of_3 {
    width: 66.13%;
}

.span_1_of_3 {
    width: 32.26%;
}

/* SOLUTION AREA */
#water-smell {
    background-image: url("{{media url="wysiwyg/DFS-home-page/water-smell.png"}}");
}

#water-taste {
    background-image: url("{{media url="wysiwyg/DFS-home-page/water-taste.png"}}");
}

#water-color {
    background-image: url("{{media url="wysiwyg/DFS-home-page/water-color.png"}}");
}

#water-color, #water-taste, #water-smell {
    background-repeat: no-repeat;
    background-size: 100%;
    /* width: 399px; */
    height: auto;
}

#water-color, #water-taste, #water-smell {
    color: white;
    font-size: 1.3em;
    padding-left: 3%;
    line-height: 1.5em;
}

.text-body {
    padding-bottom: 8px;
    position: relative;
    padding-top: 41%;
    color: white;
    font-size: 1.3em;
    padding-left: 3%;
    line-height: 1.5em;
}

#water-smell .learn-link {
    padding-left: 26%;
    color: white;
}

#water-taste .learn-link {
    padding-left: 36%;
    color: white;
}

#water-color .learn-link {
    padding-left: 15%;
    color: white;
}

#water-color .learn-link:hover {
    color: #ff8d00;
}

#water-taste .learn-link:hover {
    color: #ff8d00;
}

#water-smell .learn-link:hover {
    color: #ff8d00;
}

.solutions {
    width: 31%;
    height: 226px;
}

/* END SOLUTION AREA */ /* 3 ICON AREA */
.img-left {
    float: left;
    padding-right: 2%;
    margin: 0;
}

.text-right {
    font: 6em;
    padding-right: 10%;
    margin: 6% 0 0 0;
}

.text-right h3 {
    color: black;
    padding: 0;
    margin-bottom: 8px;
}

/* END 3 ICON AREA */ /* RESOURCE CENTER AREA */
.resource-center {
    background-image: url("{{media url="wysiwyg/DFS-home-page/resource-center-background.png"}}");
    background-repeat: round;
}

.resource-center p {
    display: block;
    color: white;
    font-size: 1.2em;
    width: 53%;
    text-align: center;
    padding: 4% 0 1% 0;
}

.resource-center .guide-button {
    margin-top: 1%;
}

.resource-center-tag a {
    color: white;
}

.resource-center-tag a:hover {
    color: #ff8d00;
}

.rc-title {
    background-color: #1c6497;
    padding: 2% 0 2% 0;
}

/* RC BUTTON */
.guide-button {
    background-color: #ffffff;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    border: 1px solid #dcdcdc;
    display: inline-block;
    cursor: pointer;
    color: #666666;
    font-family: Arial;
    font-size: 16px;
    padding: 8px 30px;
    text-decoration: none;
}

.guide-button:hover {
    background-color: #f6f6f6;
}

.guide-button:active {
    position: relative;
    top: 1px;
}

.findButton {
    -moz-box-shadow: inset 0px 1px 0px 0px #54a3f7;
    -webkit-box-shadow: inset 0px 1px 0px 0px #54a3f7;
    box-shadow: inset 0px 1px 0px 0px #54a3f7;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #007dc1), color-stop(1, #0061a7));
    background: -moz-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background: -webkit-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background: -o-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background: -ms-linear-gradient(top, #007dc1 5%, #0061a7 100%);
    background: linear-gradient(to bottom, #007dc1 5%, #0061a7 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#007dc1', endColorstr='#0061a7', GradientType=0);
    background-color: #007dc1;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid #124d77;
    display: inline-block;
    cursor: pointer;
    color: #ffffff;
    font-family: Arial;
    font-size: 13px;
    padding: 5px 10px;
    text-decoration: none;
    text-shadow: 0px 1px 0px #154682;
}

.findButton:hover {
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #0061a7), color-stop(1, #007dc1));
    background: -moz-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background: -webkit-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background: -o-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background: -ms-linear-gradient(top, #0061a7 5%, #007dc1 100%);
    background: linear-gradient(to bottom, #0061a7 5%, #007dc1 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0061a7', endColorstr='#007dc1', GradientType=0);
    background-color: #0061a7;
}

.findButton:active {
    position: relative;
    top: 1px;
}

/* END RESOURCE CENTER AREA */
@media only screen and (min-width: 901px) and (max-width: 1024px) {
    #homepage_oasis_standard {
        background-image: url("{{media url="wysiwyg/DFS-home-page/hero-banner-900.png"}}");
        background-repeat: no-repeat;
        margin-left: auto;
        margin-right: auto;
        background-size: 100%;
    }
}

@media only screen and (max-width: 900px) {
    #homepage_oasis_standard {
        background-image: url("{{media url="wysiwyg/DFS-home-page/hero-banner-750.png"}}");
        background-repeat: no-repeat;
        margin-left: auto;
        margin-right: auto;
        background-size: 100%;
        height: 205px;
    }

    .col {
        margin: 1% 0 1% 0%;
    }

    .span_3_of_3, .span_2_of_3, .span_1_of_3 {
        width: 100%;
    }

    .img-right img {
        width: 270px;
        margin-top: 5%;
    }

    .text-left {
        float: none;
        padding: 0;
        margin-left: 0;
    }

    #fridge-filters, #house-filters, #air-filters, #water-color, #water-taste, #water-smell, .placeholder {
        background-size: 500px;
        width: 486px;
    }

    #water-color, #water-taste, #water-smel {
        font-size: 1.3em;
    }

    .placeholder .view-link {
        font-size: 1em;
        padding-left: 10%;
    }

    #fridge-filters .view-link {
        font-size: 1em;
        padding-left: 255px;
    }

    #air-filters .view-link {
        font-size: 1em;
        padding-left: 290px;
    }

    #house-filters .view-link {
        font-size: 1em;
        padding-left: 193px;
    }

    .resource-center {
        background-image: none;
        background-color: #0d87e6;
        height: auto;
    }

    .t002-fridge-text, .t002-air-text {
        margin-top: 3px;
    }

    .t002-air-finder-anchor {
        margin-left: 0 !important;
    }

    .t002-filter-finder-inner-wrapper {
        width: auto !important;
    }
}

@media only screen and (min-width: 481px) and (max-width: 640px) {
    #homepage_oasis_standard {
        background-image: url("{{media url="wysiwyg/DFS-home-page/hero-banner-640.png"}}");
        background-repeat: no-repeat;
        margin-top: 8%;
    }

    .findButton {
        margin-top: 7px;
        margin-bottom: 7px; 
    }

    .t002-fridge-text, .t002-air-text {
        height: 22px !important;
        margin-top: 13px;
    }

    .t002-air-finder-anchor {
        margin-left: 0 !important;
    }

    .t002-air-icon {
        display: block;
    }

    .col {
        margin: 1% 0 1% 0%;
    }

    .span_3_of_3, .span_2_of_3, .span_1_of_3 {
        width: 100%;
    }

    .section {
        width: 100%;
    }

    .img-right img {
        width: 270px;
        margin-top: 5%;
    }

    .text-left {
        padding: 0;
        margin-left: 0;
    }

    #fridge-filters, #house-filters, #air-filters {
        line-height: 2.8em;
    }

    .placeholder .view-link {
        font-size: 1em;
        padding-left: 60%;
    }

    #fridge-filters .view-link {
        font-size: 1em;
        padding-left: 255px;
    }

    #air-filters .view-link {
        font-size: 1em;
        padding-left: 49%;
    }

    #house-filters .view-link {
        font-size: 1em;
        padding-left: 32%;
    }

    .resource-center {
        background-image: none;
        background-color: #0d87e6;
        height: auto;
    }

    .resource-center .guide-button {
        margin-bottom: 3%;
    }

    .resource-center p {
        padding: 2% 0 1% 0;
    }
}

@media only screen and (max-width: 480px) {
    #homepage_oasis_standard {
        background-image: url("{{media url="wysiwyg/DFS-home-page/hero-banner-480.png"}}");
        background-repeat: no-repeat;
        width: 470px;
    }

    .col {
        margin: 1% 0 1% 0%;
    }

    .span_3_of_3, .span_2_of_3, .span_1_of_3 {
        width: 100%;
    }

    .section {
        width: 100%;
    }

    .resource-center {
        background-color: #0d87e6;
        background-image: none;
        height: auto;
    }

    .resource-center img {
        padding-top: 3%;
    }

    .resource-center p {
        text-align: center;
    }

    .resource-center .guide-button {
        margin-top: 1%;
    }

    .titles {
        width: 87%;
        margin-left: auto;
        margin-right: auto;
    }

    .titles h3 {
        font-size: 1.3em;
    }

    .img-right img {
        margin-top: 6%;
    }

    #solutions img {
        width: 100%;
        height: auto;
    }

    .t002-or-spacer {
        display: none;
    }

    .t002-fridge-text, .t002-air-text {
        height: 20px !important;
    }

    .t002-air-finder-anchor {
        width: 100%;
        float: left;
    }
}

@media only screen and (max-width: 531px) {
.text-body2 {
      top: -23px;
      font-size: 1.3em;
}
#house-filters .view-link, #air-filters .view-link, #fridge-filters .view-link, .placeholder .view-link {
    right: 35px;
}
    #homepage_oasis_standard {
        background-image: url("{{media url="wysiwyg/DFS-home-page/hero-banner-320.png"}}");
        background-repeat: no-repeat;
        width: 315px;
    }

    #fridge-filters, #house-filters, #air-filters, .placeholder {
        width: 283px;    
        background-size: 295px;
    }

    #fridge-filters .view-link {
        padding-left: 30%;
    }

    #fridge-filters .text-body2 {
        line-height: 2.2;
        font-size: 1.3em;
    }

    #house-filters .view-link {
        padding-left: 8%;
    }

    #house-filters .text-body2 {
        line-height: 2.2;
        font-size: 1.3em;
    }

    #air-filters .view-link {
        padding-left: 42%;
    }

    #air-filters .text-body2 {
        line-height: 2.2;
        font-size: 1.3em;
    }

    #water-color, #water-taste, #water-smell {
        width: 320px;
        background-size: 300px;
    }

    #water-color, #water-taste, #water-smell {
        line-height: 1.5;
        font-size: 1.3em;
    }

    #water-smell .learn-link {
        padding-left: 18%;
    }

    #water-color .learn-link {
        padding-left: 8%;
    }

    #water-taste .learn-link {
        padding-left: 29%;
    }

    .text-right {
        float: none;
        margin-left: 15%;
    }

    ul {
        padding-left: 0.5em;
    }

    h2 {
        font-size: 12px;
    }

    .t002-or-spacer {
        display: none;
    }

    .t002-fridge-text, .t002-air-text {
        height: 20px !important;
    }

    .t002-air-finder-anchor {
        width: 100%;
        float: left;
    }
}
@media only screen and (max-width: 481px) {
    .t002-fridge-finder-anchor {
        width: 100%;
        float: left;
    }
}

.resource-center-div .span_1_of_3 {
    position: relative;
}

.resource-center-div {
    padding: 2%;
    text-align: center;
}

.resource-center p {
    margin-left: auto;
    margin-right: auto;
}

@media only screen and (min-width: 1161px) and (max-width: 1279px) {
    .text-body {
        padding-top: 40.6%;
        font-size: 1.2em;
    }
#water-taste .learn-link, #water-smell .learn-link, #water-color .learn-link  {
    position: absolute;
    right: 35px;
    bottom: 8px;
}
}
@media only screen and (min-width: 1081px) and (max-width: 1160px) {
    .text-body {
        padding-top: 39.6%;
        font-size: 1.2em;
    }
#water-taste .learn-link, #water-smell .learn-link, #water-color .learn-link  {
    position: absolute;
    right: 30px;
}
}
@media only screen and (min-width: 1001px) and (max-width: 1080px) {
    .text-body {
        padding-top: 41%;
        font-size: 1em;
    }
#water-taste .learn-link, #water-smell .learn-link, #water-color .learn-link  {
    position: absolute;
    right: 30px;
}
}
@media only screen and (min-width: 901px) and (max-width: 1000px) {
    .text-body {
        padding-top: 40%;
        font-size: 1em;
    }
#water-taste .learn-link, #water-smell .learn-link, #water-color .learn-link  {
    position: absolute;
    right: 25px;
}
}

@media only screen and (min-width: 1080px) and (max-width: 1279px) {
    .text-body2 {
        top: -10px; 
        font-size: 1.8em;
    }
}

@media only screen and (min-width: 901px) and (max-width: 1079px) {
    .text-body2 {
        top: -7px; 
        font-size: 1.5em;
    }
}

@media only screen and (min-width: 901px) and (max-width: 1279px) {
    .section {
        width: 100%;
        margin-left: 1.333%;
    }

    .span_1_of_3 {
        width: 31.6%;
    }

    .col {
         /* margin: 1% 2% 1% 0; */
    }

#house-filters .view-link, #air-filters .view-link, #fridge-filters .view-link, .placeholder .view-link {
    right: 35px;
}

    .resource-center-div .span_1_of_3 {
        width: 32.26%;
    }
}

@media only screen and (min-width: 532px) and (max-width: 900px) {
    .text-body2 {
        top: -35px;
    }
#house-filters .view-link, #air-filters .view-link, #fridge-filters .view-link, .placeholder .view-link {
    right: 60px;
}
}

@media only screen and (min-width: 728px) and (max-width: 900px) {
    .text-right {
        padding-right: 20%;
    }
}

@media only screen and (max-width: 640px) {
    .img-left {
        margin-left: 0%;
    }
}
@media only screen and (max-width: 373px) {
    .img-left {
       height: 190px; */
    }
}

@media only screen and (min-width: 530px) and (max-width: 900px) {
    .img-left {
        padding-left: 10%;
    }

    #water-color, #water-taste, #water-smell {
        margin-left: auto;
        margin-right: auto;
    }

    #category-area .span_1_of_3, #category-area2 .span_1_of_3 {
        height: 280px;
    }

    #fridge-filters, #house-filters, #air-filters {
        margin-left: auto;
        margin-right: auto;
        padding-top: 265px;
        line-height: 2.8em;
    }

    .placeholder {
        margin-left: auto;
        margin-right: auto;
        padding-top: 265px;
        line-height: 0.8em;
    }

    .tier1-cta {
        text-align: center;
    }

    .text-body {
        padding-top: 43.2%;
    }

    #water-smell .learn-link {
        padding-left: 37%;
        color: white;
    }

    #water-taste .learn-link {
        padding-left: 46%;
        color: white;
    }

    #water-color .learn-link {
        padding-left: 29%;
        color: white;
    }
}

@media only screen and (max-width: 531px) {
    #category-area .span_1_of_3, #category-area2 .span_1_of_3 {
        height: 170px;
    }

    #fridge-filters, #house-filters, #air-filters {
        padding-top: 155px;
        margin-left: auto;
        margin-right: auto;
    }

    .placeholder {
        padding-top: 159px;
        margin-left: auto;
        margin-right: auto;
    }

    .tier1-cta {
        text-align: center;
    }

    .text-body {
        padding-top: 40.2%;
        padding-left: 0%;
        font-size: 18px;
    }

    #water-color, #water-taste, #water-smell {
        height: 173px;
        width: 287px;
        margin-left: auto;
        margin-right: auto;
    }

    #water-smell .learn-link {
        padding-left: 19%;
        font-size: 17px;
        top: -4px;
        position: relative;
    }

    #water-taste .learn-link {
        padding-left: 31%;
        font-size: 17px;
        top: -4px;
        position: relative;
    }

    #water-color .learn-link {
        padding-left: 8%;
        font-size: 16px;
        top: -4px;
        position: relative;
    }
}
    /* The CSS */
    .finder-brand-select, .air-filter-finder-select {
        font-style: italic;
        padding: 5px;
        padding-right: 25px;
        margin: 0;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        outline: none;
        display: inline-block;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        cursor: pointer;
    }

    @media screen and (-webkit-min-device-pixel-ratio: 0) {
        .finder-brand-select .air-filter-finder-select {
            padding-right: 30px
        }
    }

    .finder-brand-label, .air-filter-finder-label {
        position: relative
    }

    .finder-brand-label:after, .air-filter-finder-label:after {
        content: '<>';
        font: 11px "Consolas", monospace;
        color: #aaa;
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        transform: rotate(90deg);
        right: 8px;
        top: 0px;
        padding: 0 0 2px;
        border-bottom: 1px solid #ddd;
        position: absolute;
        pointer-events: none;
    }

    #size_length_inches, #size_width_inches {
        width: 20px;
        padding: 5px;
        border: 1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        font-style: italic;
    }

    .air-filter-finder-select {
        width: 40px;
    }

    .filter-input-spacer {
        margin-left: 3px;
        margin-right: 3px;
        font-size: 15px;
    }

.finder-col1, .finder-col2, .finder-col3 {
    float: left;
}
@media (max-width: 1183px) {
.finder-col1, .finder-col2, .finder-col3 {
    margin-bottom: 0px;
    margin-left: auto;
    margin-right: auto;
    float: none;
}
.t002-filter-finder-inner-wrapper {
    text-align: center;
}
}

@media (min-width: 762px) and (max-width: 900px) {
.finder-col2 {
    margin-bottom: 5px;
}
.t002-fridge-icon {
    margin-top: -3px;
}
.t002-fridge-text {
    margin: 0px 5px 0;
}
}

@media (max-width: 761px) {
.t002-fridge-icon, .t002-air-icon {
     display: none;
}
}
@media only screen and (max-width: 640px) {
.findButton {
    margin-top: 7px;
    margin-bottom: 7px;
}
}
@media (min-width: 1280px) {
.tier1-cta {
    margin-left: auto;
    margin-right: auto;
    width: 72%;
}
#homepage_oasis_standard {
    margin-left: auto;
    margin-right: auto;
    max-width: 1254px;
}
.hp-container {
width: 1260px;
}
.text-body2 {
   top: 179px;
}
#house-filters, #air-filters, #fridge-filters, .placeholder {
    height: 224px;
    padding-top: 0;
}
}

@media (min-width: 901px) and (max-width: 1179px) {
    .img-left {
          width: 100%;
          margin-left: -10%;
          text-align: center;
     }
}

</style>
HTML;

$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();
$block = Mage::getModel('cms/block')->load('HP_css', 'identifier');
if (!$block->getId()) {
    $block->setTitle('DFS HP_css');
    $block->setIdentifier('HP_css');
    $block->setStores($store);
    $block->setIsActive(1);
    $block->setContent($content);
    $block->save();
}
//HP_css=================end

$installer->endSetup();