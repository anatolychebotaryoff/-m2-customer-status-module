<?php
try{
    $installer = $this;
    $installer->startSetup();

	/*ADD WHY FILTERED WATER PAGE*/

    $content = <<<EOD
<!--why filtered Water -->
<div class="title">Why Filtered Water ?</div>
<div class="content">
	<div class="para intro">
		By now, we all understand how important water is to our daily health.
		So, what kind of water is the most appropriate for our consumption? The
		options are generally: <strong><span style="color: #0080b2;">tap
				water</span></strong>, <strong><span style="color: #0080b2;">bottled
				water</span></strong>, or <strong><span style=
				"color: #0080b2;">filtered water</span></strong>.
	</div>

	<div class="title">Tap Water</div>
	<div class="para">
		The quality of <span style="color: #0080b2;">tap water</span> is on a
		downward trend. Experts say that tap water has consistently worsened
		due to environmental damage and industrial pollution. Some communities
		have it worse than others (see an <a href=
			"http://www.waterfilters.net/Tap-Water-Contaminants_df_60.html">LA
			Times article</a> regarding the contaminants in tap water). Although
		some of the contaminants do not cause immediate disease, it is proven
		that consistent consumption over time can cause serious illness, such
		as cancer. It is interesting to note that most municipal water supplies
		use chemicals, such as chlorine and fluoride, which are toxic and
		proven to negatively affect humans.
	</div>

	<div class="linebreak">
		<img src="{{skin url='images/media/separator.png'}}" alt=""/>
	</div>
	<div class="slideshow">
		<div class="para">
			<div class="title">Bottled Water</div>
			<div class="para">
				Although bottled water is generally much safer than tap water, the
				quality of bottled water should also be questioned. See the <a href=
					"http://www.waterfilters.net/pdf/2011-EWG-bottledwater-scorecard-report.pdf"
					target="_blank">2011 Bottled Water Scorecard</a> from EWG
				(Environmental Working Group). Experts believe <span style=
					"color: #0080b2;">20-40% of bottled water is not filtered
					appropriately</span>, if at all. According to an <a href=
					"http://www.waterfilters.net/Bottled-Water-Contaminants_df_61.html">article</a>
				written by Bureau Chief Greg Lucas of Sacramento, one-third of bottled
				water contains contaminants. Even when it is filtered well, the
				packaging may not be safe.
			</div>
		</div>
		<div style="padding: 5px 0;"> &nbsp; </div>
		<div class="p-left">
			<div id="__ss_1563441" style="width: 425px;">
				<object data=
					"http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=dowereallyneedbottledwater-090610134014-phpapp01&amp;stripped_title=do-we-really-need-bottled-water&amp;userName=waterfilters"
					height="355" id="__sse1563441" type="application/x-shockwave-flash"
					width="425">
					<param name="allowFullScreen" value="true">
					<param name="allowScriptAccess" value="always">
					<param name="src" value=
					"http://static.slidesharecdn.com/swf/ssplayer2.swf?doc=dowereallyneedbottledwater-090610134014-phpapp01&amp;stripped_title=do-we-really-need-bottled-water&amp;userName=waterfilters">
					<param name="allowscriptaccess" value="always">
					<param name="allowfullscreen" value="true">
				</object>

				<div style="padding: 5px 0;"> &nbsp; </div>
			</div>
		</div>
	</div>
	<div style="padding: 5px 0;"> &nbsp; </div>
	<div class="linebreak"></div>
	<div class="para">
		<p>
			"Of greater concern in the WWFN study is bottled water's negative
			impact on the environment. Packaging materials are often
			environmentally unfriendly in and of themselves."
		</p>
		<p>
			(Envirnomental &amp; Climate News, July 2001 previously posted at
			http://www.heartland.org/environment/jul01/bottled.htm)
		</p>
		<p>
			It is true that some bottled water has been purified properly, but at
			what cost to the consumer? Bottled water consumers spend up to ten
			times more on bottled water than they would for water that is filtered
			as good or better than the bottled water. On average, a home filtration
			system is approximately <span style="color: #0080b2;">80% less money
				per gallon</span> than bottled. At that rate, it doesn't take very long
			for savings to add up.
		</p>
		<p>
			Bottled water consumers also miss out on the simple <span style=
				"color: #0080b2;">convenience</span> of drawing drinking water from
			their faucet. Instead they have to transport large quantities of heavy
			bottled water. Some consumers prefer bottled water because of the
			portability of small bottles. However, for pennies per gallon, they
			could instead use a <a href=
				"http://www.waterfilters.net/Water-Filter-Water-Bottle.html" title=
				"Filtered Water Bottle">water bottle filter</a>.
		</p>
		<p>
			As you consider the benefits of a safer, more economical, and more
			convenient alternative to bottled water, it is clear that a home
			filtration system is the most sensible choice.
		</p>
	</div>
	<div class="linebreak">
		<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
	</div>
	<a class="nextpage" href="{{store url='why-waterfiltersnet.html'}}" title="Why WaterFilters.NET">Why WaterFilters.NET?</a>
</div>
<!--end of page-->
EOD;

	$root_template = 'two_columns_left';

	$title = 'Why Filtered Water';

	$identifier = 'why-filtered-water.html';

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

