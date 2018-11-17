<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD EVALUATE YOUR WATER PAGE*/

    $content = <<<EOD
<!--add filter facts -->
<div class="title">Filter Facts</div>
<div class="content">
	<ul class="overview">
		<li>
		<a> Humans can live without food for about a month. How long can a human live without water?  </a>
		<p class="description"> - About a week </p>
		</li>

		<li>
		<a> Where is the largest fresh surface water system in the world?  </a>
		<p class="description"> - The Great Lakes </p>
		</li>

		<li>
		<a>
			If all the water in the Great Lakes were spread evenly across the continental US, how many feet of water would cover the ground?
		</a>
		<p class="description">- Almost 10 feet of water </p>       
		</li>

		<li>
		<a> True/False: Most of the earth's surface water is permanently frozen or salty.</a>
		<p class="description">- True </p>       
		</li>

		<li>
		<a> How many gallons of water are required to grow a day's food for a family of four?  </a>
		<p class="description">- 6,800 gallons</p>
		</li>

		<li>
		<a> What percent of the fresh water we use in the US is for irrigating crops and generating thermoelectric-power?  </a>
		<p class="description">- 80%</p>
		</li>

		<li>
		<a> What percentage of the earth's surface is covered by water?  </a>
		<p class="description"> - 75% </p>
		</li>

		<li>
		<a> What percentage of the human brain is composed of water?  </a>
		<p class="description"> - 95% </p>
		</li>

		<li>
		<a> What percentage of your lungs are composed of water?  </a>
		<p class="description"> - 90% </p>
		</li>

		<li>
		<a> What percentage of your blood is composed of water?  </a>
		<p class="description"> - 82% </p>
		</li>

		<li>
		<a> How many gallons of water does it take to grow a single serving of lettuce?  </a>
		<p class="description">- 6 gallons</p>
		</li>

		<li>
		<a> How many gallons of water are required to produce a single serving of steak?  </a>
		<p class="description">- 2,600 gallons</p>
		</li>

		<li>
		<a> How many glasses of tap water can your drink for the price of a six-pack of soda?  </a>
		<p class="description">- more than 4,000 glasses</p>
		</li>

		<li>
		<a> What percentage of Americans are chronically dehydrated?  </a>
		<p class="description"> - 75% </p>
		</li>

		<li>
		<a> In 37% of Americans, the thirst mechanism is so weak that it is often mistaken for what?  </a>
		<p class="description">- hunger</p>
		</li>

		<li>
		<a> Even a MILD case of this condition will slow down one's metabolism as much as 3%. What is this condition?  </a>
		<p class="description">- dehydration</p>
		</li>

		<li>
		<a> Lack of what substance is the number one trigger of daytime fatigue?  </a>
		<p class="description">- water</p>
		</li>

		<li>
		<a> One glass of water did what for almost 100% of dieters studied in a University of Washington study?  </a>
		<p class="description">- shut down midnight hunger pangs</p>
		</li>

		<li>
		<a> What were the first water pipes in the US made out of?  </a>
		<p class="description"> - hollowed-out logs </p>
		</li>

		<li>
		<a> What percentage of the world's fresh water supply is located in Antarctica?  </a>
		<p class="description">- Over 90%</p>
		</li>

		<li>
		<a> Where is the world's rainiest place?  </a>
		<p class="description"> - Mt. Wai'ale'ale, Kauai, Hawaii. During an average year, there are only 15 dry days.  </p>
		</li>

		<li>
		<a> Where is the world's highest waterfall?  </a>
		<p class="description">- Angel Falls in Venezuela. The falls drops 3,212 feet. The drop is
		taller than 2.5 Empire State Buildings stacked one on top of the
		other.</p>
		</li>

		<li>
		<a> How many organic chemicals have been identified in drinking water?  </a>
		<p class="description">- 700. Some of them are suspected cancer causing agents</p>
		</li>

		<li>
		<a> Do municipal water treatment systems take out all harmful substances from your water?  </a>
		<p class="description">
		- No. There are 35,000 pesticides containing 600 chemical compounds.
		Yet, at the time of this writing, municipal water systems are only
		required to test for six. Many of these chemicals are known to cause
		birth defects, nerve damage, sterility and cancer. A recent government
		study found that more than 25% of all large U.S. public water systems
		contain traces of one or more toxic substances. Public water systems do
		not test for the carcinogens and other dangerous chemicals that are
		being found. Water treatment plants are not always effective at
		removing harmful substances from your water supply. To ensure the
		protection of you, your family, and your children, it is recommended
		that you get a R.O.  System to rid your water supply of all contaminants. However, if
		you cannot afford a R.O. System, look into Whole House Water Filters or other
		water filter types to rid your water of contaminants.
		</p>
		</li>

		<li>
		<a> What percentage of the nation's 65,000 community systems are unable to meet minimum standards set by the Safe Drinking Water Act?  </a>
		<p class="description">- 20% (Reported by the General Accounting Office)</p>
		</li>

		<li>
		<a> Drinking five glasses of water daily decreases the risk of colon cancer by what percent?  </a>
		<p class="description">- 45%</p>
		</li>

		<li>
		<a> Drinking five glasses of water daily decreases the risk of breast cancer by what percent?  </a>
		<p class="description">- 79%</p>
		</li>

		<li>
		<a> Drinking five glasses of water daily decreases the risk of bladder cancer by what percent?  </a>
		<p class="description">- 50%</p>
		</li>
		<li>
		<a> Preliminary research indicates that 8-10 glasses of water a could significantly ease what symptom for up to 80% of sufferers? </a>
		<p class="description">- back and joint pain</p>
		</li>
		<li>
		<a> What percentage drop in body water can trigger fuzzy short- memory, trouble with basic math, and difficulty focusing on a computer screen or printed page? </a>
		<p class="description">- 2%</p>
		</li>
	</ul>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
</div>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Filter Facts';

	$identifier = 'filter-facts.html';

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





