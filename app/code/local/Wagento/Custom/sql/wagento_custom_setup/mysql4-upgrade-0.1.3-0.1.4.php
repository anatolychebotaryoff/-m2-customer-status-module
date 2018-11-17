<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD WHY WATERFILTERS.NET PAGE*/

    $content = <<<EOD
<!--why waterfilters.net-->
<div class="title">Why WaterFilters.NET ?</div>
<div class="content">
    <div class="para intro">
		In lessons 1 and 2, we learned why water is so important, and why filtered
		water is the best option. But where should we go to get our water
		filters?
    <br>
    <div class="para">
		<p>
			<a href="http://www.waterfilters.net/">WaterFilters.NET</a> has achieved
			<strong><span style="color: #b54646;">excellence</span></strong> in three
			areas that will directly benefit consumers.
		</p>
		<p>
			<strong><span style="color: #b54646;">Excellent Prices</span></strong> -
			Because WaterFilters.NET sells such a high quantity of water filters, we
			are able to get excellent deals. We pass these <span style=
			"color: #b54646;">savings</span> directly to you, our customers. Because
			you are buying directly from a wholesale distributor, there is no middle
			man asking for a piece of the pie.
		</p>
		<p>
			<strong><span style="color: #b54646;">Excellent Products</span></strong> -
			There are a lot of filters in today's market that are not even of average
			quality. This is not the case with the selection available at <a href=
			"http://www.waterfilters.net">WaterFilters.NET</a>. Our customers do not
			have to wade through our inventory to find filters of high quality. To
			ensure the highest quality water filters for our customers, we have chosen
			only to offer the best filtration products by the most reputable filtration
			manufacturers in the industry. This means you can rest assured that your
			filter will be of the highest quality. For more information on <a href=
			"http://www.waterfilters.net/Certified-Filter-Quality.html">NSF</a>
			standards and the gold seal of the <a href=
			"http://www.waterfilters.net/Certified-Filter-Quality.html">WQA</a>, we
			welcome you to our <a href=
			"http://www.waterfilters.net/Certified-Filter-Quality.html">Certified
			Quality</a> page.
		</p>
		<p>
			<strong><span style="color: #b54646;">Excellent Service</span></strong> -
			WaterFilters.NET is available online <span style=
			"color: #b54646;">24/7</span>, which means you can conveniently shop at any
			time from your own home. WaterFilters.NET offers a <span style=
			"color: #b54646;">simple and intuitive interface</span> by which consumers
			can find the filters they need. We "filter" out the technical babble so you
			don't have to. We present a well-organized and thorough selection for all
			of your water filtration needs. Our Technical Support staff, led by
			Aquaman, a WQA (Water Quality Association) C.W.S. (Certified Water
			Specialist), is always ready to help with even the most complex water
			problems. If you need <a href=
			"http://www.waterfilters.net/Water-University-Find-Your-Filter.html">help
			finding your filter</a>, we can help! We can also help you with <a href=
			"http://www.waterfilters.net/Water-Filter-Installation-Services.html"
			title="">water filter system installation services</a>.
		</p>
    </div>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator.png'}}" alt=""/>
	</div>
    <div class="para">
		Moreover, water filters from <strong><a href=
		"http://www.waterfilters.net">WaterFilters.NET</a></strong>can give you
		water that is:
	
		<ul class="overview2">
			<li><a href=
			"http://www.waterfilters.net/Water-University-Why-Filtered-Water.html">Healthy</a>;</li>
	
			<li><a href=
			"http://www.waterfilters.net/Water-University-Why-Filtered-Water.html">Priced
			economically</a>;</li>
	
			<li>Conveniently available from a faucet or <a href=
			"http://www.waterfilters.net/Water-Filter-Water-Bottle.html">portable
			bottle</a>;</li>
	
			<li><a href=
			"http://www.waterfilters.net/Certified-Filter-Quality.html">High
			quality</a>;</li>
	
			<li>Filtered for your needs (<a href=
			"http://www.waterfilters.net/Whole-House-Water-Filters.html">whole
			house systems</a>, <a href=
			"http://www.waterfilters.net/Under-Sink-Filters.html">under sink
			systems</a>, <a href=
			"http://www.waterfilters.net/Faucet-Water-Filter-Systems.html">faucet
			mount systems</a>, <a href=
			"http://www.waterfilters.net/Countertop-Water-Filtration-System.html">counter
			top filters</a>, <a href=
			"http://www.waterfilters.net/Water-Filtration-Pitcher.html">pitchers</a>,
			<a href=
			"http://www.waterfilters.net/Water-Filter-Water-Bottle.html">water
			bottles</a>, <a href=
			"http://www.waterfilters.net/Refrigerator-Water-Filters.html">fridge
			filters</a>, <a href=
			"http://www.waterfilters.net/Shower-Filter-Systems.html">shower
			filters</a>, <a href=
			"http://www.waterfilters.net/RV-Water-Filter-Systems.html">RV
			filters</a>, <a href=
			"http://www.waterfilters.net/Camping-Water-Filter.html">camping
			filters</a>, and <a href="http://www.waterfilters.net">more</a>);
			and</li>
	
			<li>Filtered by filters that are <a href=
			"http://www.waterfilters.net/Certified-Filter-Quality.html">NSF
			(National Sanitation Foundation) certified</a></li>
		</ul>
    </div>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
    <a class="nextpage" href="{{store url='evaluate-your-water.html'}}" title="Evaluate Your Water">Next Lesson: Evaluate your Water.</a>
</div>

<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Why WaterFilters.NET ?';

	$identifier = 'why-waterfiltersnet.html';

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


