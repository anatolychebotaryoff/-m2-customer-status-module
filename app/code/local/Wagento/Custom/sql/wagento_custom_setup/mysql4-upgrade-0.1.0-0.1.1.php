<?php
try{
    $installer = $this;
    $installer->startSetup();

    $content = <<<EOD
<!--Landing page-->
<div class="landing-banner">
	<img src="{{skin url='images/media/banner.png'}}" alt="" style="width: 100%;"/>
</div>
<div class="landing-social">
	{{block type="sharingtool/share" name="addthis_sharetool"}}
</div>
<div class="left-a">
	<img src="{{skin url='images/media/cleanwater.png'}}" alt="" style=""/>
</div>
<div class="right-a pa1">
	<p class="landing-title">Safe, Clean Water<br>
	<p class="para">
		From our company's outset in 2001. we have been dedicated to the conviction
		that the technology represented by water filtration was a healthier
		alternative. both for individual consumers and for the global community.
		Reducing contaminants in drinking water at home. for instance. has great
		potential health benefits for customer households.
	</p>
	<p class="para">
		That same technology, however, can be used on a more massive scale to
		reduce pol­lutants in local water supplies in parts of the world where
		access to clean. safe drink­ing water is limited or even non-existent.
	</p>
	<p class="para">
		In addition, the WaterFilters.NET team knew that filtered water was a more
		environmen­tally friendly choice than plastic bottled water. which is
		costly both to the pocketbook and to the planet.
	</p>
</div>
<div class="linebreak style1">
	<img src="{{skin url='images/media/separator.png'}}" alt=""/>
</div>
<div class="quotation">
	<p class="content">
		"We are seeking to align with charities who enzbody servant leadership
		on every level. Our calling is to serve, both locally and globally. In
		business, we serve the customer. In charity, we serve the person in need."
	</p>
	<p class="author">
		-Jamin Arvig, CEO
	</p>
</div>
<div class="linebreak style2">
	<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
</div>
<div class="left-b">
	<p class="landing-title">
		How Do We Afford to make Charitable Donations on All Online Orders?
	</p>
	<p class="para">
		We do things differently at WaterFilters.NET. First and foremost. we want
		to make a difference in the world. Instead of having our biggest budget
		expense in advertising like most e-commerce companies. we move that budget
		to charity. This allows us to keep the lowest prices while also making a
		significant impact in the world by bringing water to those in need.
	</p>
	<p class="para">
		This is only possible because loyal customers like you spread the word
		about our company and our cause. We appreciate all who "like" us (see
		button on the bottom of the page) and/or update their status posts to help
		make a ripple effect about this excellent cause.
	</p>
</div>
<div class="right-b">
	<img src="{{skin url='images/media/charitable.png'}}" alt="" style=""/>
</div>
<div class="linebreak style1">
	<img src="{{skin url='images/media/separator.png'}}" alt=""/>
</div>
<div class="left-a">
	<img src="{{skin url='images/media/leadingvoice.png'}}" alt="" style=""/>
</div>
<div class="right-a">
	<p class="landing-title">
		The Leading Voices in Clean Water
	</p>
	<p class="para">
		WaterFilters.NET is excited about its partnership with charity: water.
		creating a synergy between the premier water filter superstore and the
		leading water charity.
	</p>
	<p class="para">
		In addition to our collaboration with charity: water. the WaterFilters.NET
		team hand-selected a group of outstanding non-profits to support further
		Our company has made financial contributions to ten water-related charities
		in 2011 alone. The point of connection with all ten charities is an
		emphasis on pure water. Underlying that primary commitment, however, are
		organizations with a solid set of core values.
	</p>
	<p class="para">
		When consumers shop at WaterFilters.NET, they will quickly discover a
		company committed not only to customer service but also to global
		sustainability.
	</p>
</div>
<div class="linebreak style2">
	<img src="{{skin url='images/media/separator2.png'}}" alt=""/>
</div>
<div class="left-b">
	<p class="landing-title">
		Our Mission with charity: water
	</p>
	<p class="landing-subtitle">
		HERE ARE THE STARTLING FACTS:
	</p>
	<p class="para">
		<p class="para p-unique">
			- Almost one billion people on the planet don't have access to safe, clean
			drinking water.
		</p>
		<p class="para p-unique">
			- 90% of the 30.000 deaths that occur every week from unsafe water and
			unhygienic conditions are of children under five years old.
		</p>
	</p>
	<p class="para">
		charity: water is a non-profit organization bringing clean and safe
		drinking water to people in developing nations. Since the inception in
		August 2006. charity: water has funded more than 3,750 freshwater projects
		in 19 different countries, serving more than 1.700.00 people.
	</p>
	<p class="para">
		charity: water partners with organizations on the ground to implement clean
		water solutions and provide maintenance and hygiene training to
		communities. Safe water is often just 100- 300 feet underground in aquifers
		and can be tapped using a drill: these freshwater wells can provide at
		least 250 people clean and safe drinking water. Other solutions include
		well reha­bilitations. spring protections, rainwater catchment systems and
		BioSand filters.
	</p>
</div>
<div class="right-b">
	<img class="ldown" src="{{skin url='images/media/mission.png'}}" alt="" style=""/>
</div>
<div class="linebreak style1">
	<img src="{{skin url='images/media/separator.png'}}" alt=""/>
</div>
<div class="left-a">
	<img src="{{skin url='images/media/donation.png'}}" alt="" style=""/>
</div>
<div class="right-a">
	<p class="landing-title">
		WaterFilters for Charity
	</p>
	<p class="para">
		WaterFilters.NET is celebrating the launch of a new initiative that we are
		calling "Water Filters for Charity". Leveraging the great work by the
		non-profit organization charity: water, vie are donating a portion of all
		online sales to provide clean. safe drinking water for those in need around
		the world. Our current collaboration with charity: water will bring access
		to drinking water for people in developing nations. 100% of the donations
		we give will go directly to work "in the field." Administrative costs for
		"charity: water" are covered by other means.
	</p>
	<p class="donation-title">
		DONATE TODAY and Help Us Make a Wave
	</p>
	<p class="para">
		Add a $1 Donation to: Water Filters for Charity
	</p>
	{{block type="core/template" name="donation" template="wagento/charitylanding.phtml"}}
</div>
<!--End of landing page-->
EOD;

	$layout_update = <<<EOD
<reference name="head">
	<action method="addCss"><stylesheet>css/landingpage.css</stylesheet></action>
</reference>
<reference name="root">
    <action method="unsetChild"><alias>breadcrumbs</alias></action>
    <block type="page/html_breadcrumbs" name="breadcrumbs" as="breadcrumbs">
        <action method="addCrumb">
            <crumbName>Home</crumbName>
            <crumbInfo><label>Home</label><title>Home</title><link>/</link></crumbInfo>
        </action>
        <action method="addCrumb">
            <crumbName>Parent CMS Page</crumbName>
            <crumbInfo><label>About Us</label><title>About Us</title><link>/about-us</link></crumbInfo>
        </action>
        <action method="addCrumb">
            <crumbName>Child CMS Page</crumbName>
            <crumbInfo><label>Water Filters for Charity</label><title>Water Filters for Charity</title></crumbInfo>
        </action>
    </block>
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

	$title = 'Water Filters for Charity';

	$identifier = 'water-filters-for-charity.html';

    $cmspage = array(
        'title' => $title,
        'identifier' => $identifier,
        'content' => $content,
        'sort_order' => 0,
		'stores' => array(0),
		'root_template' => 'one_column',
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

