<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD LEFT NAVIGATION*/
    $content = <<<EOD
<div class="block block-account cmssidebar">
	<div class="block-title"><strong> <span> Water University </span> </strong></div>
	<div class="block-content">
		<ul>
			<li><a class="cmsurl" href="{{store url=''}}why-filtered-water.html">Why Filtered Water?</a></li>
			<li><a class="cmsurl" href="{{store url=''}}why-waterfiltersnet.html">Why WaterFilters.NET?</a></li>
			<li><a class="cmsurl" href="{{store url=''}}evaluate-your-water.html">Evaluate Your Water</a></li>
			<li><a class="cmsurl" href="{{store url=''}}choose-your-filter.html">Choose Your Filter</a></li>
			<li><a class="cmsurl" href="{{store url=''}}find-your-filter.html">Find Your Filter</a></li>
			</ul>
			<div class="title underline">MORE RESOURCES</div>
			<ul>
			<li><a class="cmsurl" href="{{store url=''}}filter-facts.html">Filter Facts</a></li>
			<li><a class="cmsurl" href="{{store url=''}}water-contaminants.html">Water Contaminants</a></li>
			<li><a class="cmsurl" href="{{store url=''}}water-filtration-glossary.html">Water Glossary</a></li>
			<li><a class="cmsurl" href="{{store url=''}}water-news.html">Water News</a></li>
			<li><a title="Blog" href="/blog">Blog</a></li>
			<li><a class="cmsurl" href="{{store url=''}}water-filter-videos.html">Water FIlter Videos</a></li>
			<li><a class="cmsurl" href="#">Customer Q&amp;A</a></li>
		</ul>
	</div>
</div>
EOD;

	$title = 'Water University - Navigation';

	$identifier = 'water-university-navigation';

    $staticBlock = array(
        'title' => $title,
        'identifier' => $identifier,
        'content' => $content,
        'is_active' => 1,
        'stores' => array(0)
    );
	if (Mage::getModel('cms/block')->load($identifier)->getBlockId())
	{
		Mage::getModel('cms/block')->load($identifier)->delete();
	}
	Mage::getModel('cms/block')->setData($staticBlock)->save();

	/*ADD WATER BASIC PAGE*/

    $content = <<<EOD
<!--Water university basic-->
<div class="title">Water Basics</div>
<div class="content">
	<p class="para intro">To gain a better understanding of water and it's importance, see this highly informative Document on Water Basics, or watch this slide show, then add to your understanding by reading more below.</p>
	<div class="slideshow">
		<div class="p-left">
			<div id="__ss_6763410" style="width: 425px;">
				<object id="__sse6763410" width="425" height="355" data="http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=waterbasicsmodified-110131100029-phpapp02&amp;stripped_title=water-basics&amp;userName=waterfilters" type="application/x-shockwave-flash">
					<param name="allowFullScreen" value="true" />
					<param name="allowScriptAccess" value="always" />
					<param name="src" value="http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=waterbasicsmodified-110131100029-phpapp02&amp;stripped_title=water-basics&amp;userName=waterfilters" />
					<param name="allowscriptaccess" value="always" />
					<param name="allowfullscreen" value="true" />
				</object>
			</div>
		</div>
		<div class="p-right">
			<ul class="overview">
				<li>
				<a>Importance of water:</a>
				<p class="description">The Human Body</p>
				</li>
				<li>
				<a>Basic Water Chemistry:</a>
				<p class="description">Measurable Properties</p>
				</li>
				<li>
				<a>Fundamentals of Water Technology:</a>
				<p class="description">Hydrologic Cycle</p>
				</li>
				<li>
				<a>Nature of Water:</a>
				<p class="description">Environmental Factors</p>
				</li>
				<li>
				<a>Contamination:</a>
				<p class="description">Origin &amp; Potential Problems</p>
				</li>
			</ul>
			<a class="more">view more presentations &gt;</a>
		</div>
	</div>
	<div style="padding: 5px 0;"> &nbsp; </div>
	<div class="linebreak style1">
		<img src="{{skin url='images/media/separator.png'}}" alt=""/>
	</div>
	<div class="para">
		<div class="p-left">
			<p class="title">Are you drinking enough water?</p>
			<p>Water, which makes up 55-75 percent of the human body, is depended upon by every system in the body. Most of us have heard the recommendation to drink six 8-ounce servings of water every day. According to the American Dietetic Association, it may be necessary to drink more than this if you weigh more than 125 pounds or participate in physical activity. Doctors at Mayo Clinic recommend dividing your weight in half and using this number as the number of ounces of water consumption per day.</p>
		</div>
		<div class="p-right">
			<img src="{{skin url='images/media/pouringwater.png'}}" style="width: 100%;" alt=""/>
		</div>
	</div>
	<div class="linebreak"></div>
	<div class="para">
		<p class="title reason">
			<span class="emphasis">15 reasons</span>
			why it is critical that we maintain the proper water intake:
		</p>
		<p class="title reason">1. Reduce the risk of heart disease.</p>
		<p class="para">Researchers at Loma Linda University in California studied more than 20,000 healthy men and women and found that people who drink more than five glasses of water a day were less likely to die from a heart attack or heart disease than those who drank fewer than two glasses a day.</p>
		<p class="title reason">2. Become more energetic and alert.</p>
		<p class="para">Water plays a vital role in nearly every bodily function. Lack of water is the #0 trigger of daytime fatigue. A mere 2% drop in body water can trigger fuzzy short-term memory, trouble with basic math, and difficulty focusing on the computer screen or on a printed page.</p>
		<p class="title reason">3. Cushion and lube your joints and muscles.</p>
		<p class="para">Water makes up a large part of the fluid that lubricates and cushions your joints and muscles. Drinking water before, during, and after exercise can also help reduce muscle cramping and premature fatigue.</p>
		<p class="title reason">4. Lose weight.</p>
		<p class="para">Increased water consumption can help you control weight by preventing you from confusing hunger with thirst. Water will also keep your body systems working properly, including metabolism and digestion, and give you the energy (and hydration) necessary for exercise.</p>
		<p class="title reason">5. Flush toxins.</p>
		<p class="para">By helping to flush toxins, appropriate water intake lessens the burden on your kidneys and liver.</p>
		<p class="title reason">6. Improve skin health.</p>
		<p class="para">Drinking water moisturizes your skin from the inside out. Water is essential to maintaining elasticity and suppleness and helps prevent dryness.</p>
		<p class="title reason">7. Improve digestion.</p>
		<p class="para">Water is essential for proper digestion, nutrient absorption, and chemical reactions. Water is a metabolical and transport tool for carbohydrates and proteins that our body uses as food. Moreover, water is helpful for preventing constipation by adding fluid to the colon and bulk to stools, making bowel movements softer and easier to pass.</p>
		<p class="title reason">8. Maintain healthy immune system.</p>
		<p class="para"></p>A healthy immune system is necessary to fight off disease. Low fluid intake is correlated with bladder, colon, breast, prostate, kidney, and testicular cancers.</p>
		<p class="title reason">9. Maintain ideal body temperature.</p>
		<p class="para">Water regulates the body's cooling system. Perspiration is a body function that controls the body temperature. An adequate supply of water is necessary for the body to produce sweat.</p>
		<p class="title reason">10. Avoid dehydration.</p>
		<p class="para">Chronic Cellular Dehydration can result from consistent failure to drink enough water. This condition leaves the body weak and vulnerable to disease. It also leads to chemical nutritional, and pH imbalances that can cause a host of diseases. Dehydration can occur in any time of the year. Winter dryness can sometimes dehydrate the body even quicker than summer weather.</p>
		<p class="title reason">11. Reduce your risk of disease and infection.</p>
		<p class="para">The traditional prescription to "drink plenty of fluids" when you're sick still holds strong. Water can help control a fever, replace lost fluids, and thin out mucus.</p>
		<p class="title reason">12. Get well.</p>
		<p class="para">The traditional prescription to "drink plenty of fluids" when you're sick still holds strong. Water can help control a fever, replace lost fluids, and thin out mucus.</p>
		<p class="title reason">13. Better Circulation.</p>
		<p class="para">The levels of oxygen in the bloodstream are greater when the body is well hydrated. The more oxygen the body has readily available the more fat it will burn for energy without the presence of oxygen the body cannot utilize stored fat for energy efficiently. Not only will the body burn more fat when well hydrated but because there are increased oxygen levels you will also have more energy.</p>
		<p class="title reason">14. There is no substitute.</p>
		<p class="para">It is difficult for the body to get water from any other source than water itself. Soft drinks and alcohol steal tremendous amounts of water from the body. Other beverages such as coffee and tea are diuretics therefore stealing precious water from the body.</p>
		<p class="title reason">15. Water is the substance of life.</p>
		<p class="para">Life can not exist without water. We must constantly be adding fresh water to our body in order to keep it properly hydrated. Water can be a miracle cure for many common ailments such as headaches, fatigue, joint pain, and much more. We can go for weeks without food, but only 2 days without water!</p>
	</div>
	<div class="right-nav"><strong>Sources</strong>: <a href="http://www.WebMD.com" target="_blank">www.WebMD.com</a>, <a href="http://www.mayoclinic.com" target="_blank">www.mayoclinic.com</a>, <a href="http://www.brita.com/" target="_blank">www.brita.com</a>, <a href="http://www.culligan.com/" target="_blank">www.culligan.com</a></div>
	<div class="linebreak style2">
		<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
	<a class="nextpage" href="{{store url='why-filtered-water.html'}}">next lession &gt;</a>
</div>
<!--end of homepage-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Water Basic';

	$identifier = 'water-basic.html';

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
