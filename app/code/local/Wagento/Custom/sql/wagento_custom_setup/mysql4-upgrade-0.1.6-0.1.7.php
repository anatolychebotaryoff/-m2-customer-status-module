<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD EVALUATE YOUR WATER PAGE*/

    $content = <<<EOD
<!--add find you filter -->
<div class="title">Find your Filter</div>
<div class="content">
	<div class="para intro">Follow these 3 easy steps to find what you need:</div>
	<div class="para">
		<ul class="overview2">
			<li><strong>Search by type:</strong> Use the blue drop-down menu at the
			top of every page to navigate to your filter. The drop-down menu
			divides the filters into different categories.</li>

			<li><a href="Water-Filter-Brands.html"><strong>Search by
					brand:</strong></a> If you know the brand name of your filter, click on
			the brand logo to see if we have your filter.</li>

			<li><a href="Search-By-Picture.html"><strong>Search by
					picture:</strong></a> Scan the gallery of pictures, to find the one
			that looks like yours.</li>
		</ul>
	</div>
	<div class="para intro">
		"I Still Can't Find My Water Filter."
	</div>
	<div class="para">
		<ul class="overview2">
			<li>Email us at <a href=
				"mailto:findmyfilter@waterfilters.net?subject=Find%20my%20filter!">findmyfilter@waterfilters.net</a></li>

			<li>We'll look up which water filter fits your needs and e-mail you a
			link to the page where you can buy it.</li>

			<li>If we do not have a filter product that will fit your needs, we
			will make every effort to locate one.</li>

			<li>Our product line is growing quickly, and we want to add your filter
			to our product offering!</li>
		</ul>
	</div>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
</div>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Find your Filter';

	$identifier = 'find-your-filter.html';

	$layout_update = <<<EOD
<reference name="left">
<block type="cms/block" name="water.university.navigation">
    <action method="setBlockId"><block_id>water-university-navigation </block_id></action>
</block> 
</reference>
<reference name="head">
	<action method="addCss"><stylesheet>css/cmspage.css</stylesheet></action>
</reference>
EOD;

	$meta_keywords = <<<EOD
	Water Filters for Charity, Improving Water and the World, water charity,
    charity: water, corporate philanthropy, social entrepeneur, safe water,
    clean water, water education, servant leadership, water quality
EOD;

	$meta_description = <<<EOD
	Water Filters for Charity Improves Water and the World with a Ripple Effect
    of WaterFilters.NET serving customers and coworkers as well as people in
    need
EOD;

    $cmspage = array(
        'title' => $title,
        'identifier' => $identifier,
        'content' => $content,
        'sort_order' => 0,
		'stores' => array(0),
		'root_template' => $root_template,
		'layout_update_xml' => $layout_update,
		'meta_keywords' => $meta_keywords,
		'meta_description' => $meta_description
    );
	if (Mage::getModel('cms/page')->load($identifier)->getPageId())
	{
		Mage::getModel('cms/page')->load($identifier)->delete();
	}

	Mage::getModel('cms/page')->setData($cmspage)->save();
    $installer->endSetup();

}catch(Excpetion $e){
    Mage::logException($e);
    Mage::log("ERROR IN SETUP ".$e->getMessage());
}




