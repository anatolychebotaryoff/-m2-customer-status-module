<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD EVALUATE YOUR WATER PAGE*/

    $content = <<<EOD
<!--add Evaluate your Water -->
<div class="title">Evaluate your Water</div>
<div class="content">
    <div class="para intro">
		Evaluating your water includes <strong><span style="color: #b54646;">3
		steps</span></strong>:
    </div>
    <br>
    <div class="para">
		<p>
			<strong>1. Determine the general quality of water in your local
			area</strong>. Find out if there are common water contaminants in your
			community. A 1996 Amendment to the Safe drinking Water Act states that
			public water suppliers must provide a Consumer Confidence which includes
			basic information about the condition of their drinking water. To date,
			more than 55,000 public water suppliers have been required to issue their
			quality of water findings. See the <a href=
			"http://www.epa.gov/safewater/dwinfo.htm" target="_blank">EPA Office of
			Ground &amp; Drinking Water-Local Water Report</a> for information on water
			in your area. If your supplier is not listed in the EPA directory, call
			your water supplier directly and request a copy of their Consumer
			Confidence Report.
		</p>
		<p>
			<strong>2. Observe</strong> the feel, odor, taste, and appearance of your
			water to help diagnose exactly what is in your water. Use our <a href=
			"Water-Problems.html">Chart of Water Problems</a> to determine the
			contaminants in your water based on the feel, odor, taste and appearance of
			your water.
		</p>
		<p>
			<strong>3. Test your water</strong> to confirm your findings. You can
			contact a <a href="http://www.epa.gov/safewater/privatewells/labs.html"
			target="_blank">state-certified lab</a> for testing, or you can test the
			water yourself with a <a href="Water-Test-Kits.html">water test
			kit</a>.
		</p>
		<p>
			Now that you have evaluated your water, you can learn more about the
			contaminants in your water and find a filter that will work to reduce the
			contaminants.
		</p>
    </div>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
    <a class="nextpage" href="{{store url='choose-your-filter.html'}}">Next Lesson: Choose your Filter</a>
</div>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Evaluate your Water';

	$identifier = 'evaluate-your-water.html';

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



