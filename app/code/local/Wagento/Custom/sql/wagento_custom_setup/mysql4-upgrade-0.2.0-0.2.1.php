<?php
try{
    $installer = $this;
    $installer->startSetup();

  /*ADD BLOCK*/
    $content = <<<EOD
    <div class="blog-content">
    <div>
    <p class="title3"><a href="#">Is Acid Rain Still Problem</a></p>
    <img src="{{skin url='images/wfn_blog1.png'}}" alt="" />
    <span class="content1"><p class="time">February 7,2013</p>It's been years since people were talking about acid rain. At one point in time, you may have thought that little rain droplets would fall from the</span>
    </div><div>
    <p class="title2"><a href="#">A Grassroots Ask-Bottled Water Movement</a></p>
    <span class="time">February 7,2013</span>
    <p class="content">In Arlington, Virginia, a county board member is crusad&not;ing to ban bottled water and plastic bags in his city...</p>
    </div><div class="div-last">
    <p class="title2"><a href="#">Water is a High Priority in China</a></p>
    <span class="time">February 7,2013</span>
    <p class="content">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sod diem nonumy eirmod tempor invidunt or la...</p>
    </div>
    <p class="more"><a href="#">view all blog posts ></a></p>
    </div>


EOD;

  $title = 'Water Filters Blog';

  $identifier = 'water-filters-blog';

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

  /* ADD Water University Page*/
  $content = <<<EOD
    <div id="wu-main"><img src="{{skin url='images/wfn_banner.jpg'}}" alt="wfn_banner" />
  <div id="wu-understand"><span class="wu-understand-title">We understand </span>
    how overwhelming the technical aspects of purifying water can be for consumers who do not spend the majority of their time in the water industry.
   With this in mind, we have created Water University, which will give you a wealth of resources at your fingertips.
   Water University is broken down by the following sections.
  </div><!--end #we-understand-->
  <div class="wu-understand-below-left">
      <a href="{{store url='water-basic.html'}}"><img src="{{skin url='images/wfn_water_basic.png'}}" alt="" /></a>
      <a href="{{store url='why-filtered-water.html'}}"><img src="{{skin url='images/wfn_why_filter_water.png'}}" alt="" /></a>
       <a href="{{store url='why-waterfiltersnet.html'}}"><img src="{{skin url='images/wfn_why_waterfilter.net.png'}}" alt="" /></a>
        <a href="{{store url='evaluate-your-water.html'}}"><img src="{{skin url='images/wfn_evaluate.png'}}" alt="" /></a>
        <a href="{{store url='choose-your-filter.html'}}"><img src="{{skin url='images/wfn_choose_filter.png'}}" alt="" /></a>
     <a href="{{store url='find-your-filter.html'}}"><img src="{{skin url='images/wfn_find_your_filter.png'}}" alt="" /></a>
  </div><!--end .we-understand-below-left-->
  <div class='wu-understand-below-right'><a href="{{store url='filter-facts.html'}}"><img src="{{skin url='images/wfn_take_water_quiz.png'}}" alt="" /></a></div>
  <div id='wu-news'>
    <div class='wu-news-title'>
      <span class='left'>Water news</span>
      <span class='middle'><a hef="#">10 American Citles With the Worst Drinking Water</a>
           <span class='more'><a hef="#">more water news ></a></span>
           <div class='right'>
             <span class='right1'><img src="{{skin url='images/wfn_water_news_bgr1.png'}}" /></span>
             <span class='right2'><a href="#"><img src="{{skin url='images/wfn_water_news_bgr2.png'}}" /></a></span>
             <span class='right3'><a href="#"><img src="{{skin url='images/wfn_water_news_bgr3.png'}}" /></a></span>
          </div>
       </span>
    </div><!--end .wu-news-title-->
    <span class='line2'><img src="{{skin url='images/wfn_line2.png'}}" alt=''/></span>
    <div class='featured-video'>
          <p class='title1'>Featured Video</p>
          <div class="featured-video1">
            <p class='feature-video-video'>
              <object width="330" height="270" data="http://www.youtube.com/v/Ahg6qcgoay4" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/Ahg6qcgoay4" /></object>
            </<p>
            <p class='feature-video-content'>
              <p class='title2'>WATER WISDOM: Undersink Water Filter <br/> Systems Overview</p>
              <span class='content'>Karl from WaterFilters.NET reviews the basic features of undersink water filter systems,
               including the Pentek US-I000 and the Culligan</span>
              <span class='more'><a href="#">view all videos ></a></span>
            </p>
          </div>
    </div><!--end .featured-video-->
    <div class='water-filter-blog'>
          <p class='title1'>Water Filters Blog</p>
          {{block type="cms/block" block_id="water-filters-blog" }}
    </div><!--end water-filter-blog-->
    <img src="{{skin url='images/wfn_line3.png'}}" alt="" />
    <div class='featured-customer-qa'>
      <p class='featured-customer-qa-title'>Featured Customer Q&A</p>

      <table>
        <tr>
          <td class='q'>Q</td>
          <td class='q1'>Aren't water treatment plants supposed to remove harmful substances from my water supply?</td>
        </tr>
        <tr>
          <td class='a'>A</td>
          <td class='a1'>Water treatment plants are not always effective at removing harmful substances from your water supply.
              To ensure the protection of you, your family, and your children,
              it is recommended that you guru Reverse Osmosis System to reduce more contaminants in your drinking water..,</td>
        </tr>
        <tr><td align="right" class='more' colspan=2><a href="#">read more ></a></td></tr>
        <!------------------------------------------------------------------------------------>
        <tr>
          <td class='q'>Q</td>
          <td class='q1'>I am interested in filtering all the water in my house. What should I consider?</td>
        </tr>
        <tr>
          <td class='a'>A</td>
          <td class='a1'>The filters you need will depend on the contaminants in your water and the level of sediment in your
          water The following three stage process is the basic water filtration needed.</td>
        </tr>
        <tr><td align="right" class='more' colspan=2><a href="#">read more ></a></td></tr>
        <!------------------------------------------------------------------------------------>
        <tr>
          <td class='q'>Q</td>
          <td class='q1'>What is Point of Use vs Point of Entry?</td>
        </tr>
        <tr>
          <td class='a'>A</td>
          <td class='a1'>A point of use water filter is a filter that is attached to the plumbing that's only used for a specific use. For example an under sink filter is a point of use filter for the use of water coming out of the sink faucet.
          A faucet mount filter is a point of use filter for the use of water...</td>
        </tr>
        <tr><td align="right" class='more' colspan=2><a href="#">read more ></a></td></tr>
      </table>

       <p class='more'><a href="#">view all customer Q&A ></a></p>
    </div><!--end .featured-customer-qa-->
    <img src="{{skin url='images/wfn_line3.png'}}" alt="" />

    <div class='blog'>
      <div class='brain'>
        <div class='title'>DID YOU KNOW? </div>
        <div class='brain-1'> <span style='color: #1a80ad;font-size:35px;'>95% </span> of the human brain is composed of water</div>
        <p class='more'><a href="#">more water facts ></a></p>
      </div>
      <div class='blog-center'>
        <div class='title'>LOREM IPSUM DOLORES</div>
        <div class='content'> Do We Really Need Bottled Water?</div>
        <p class='more'><a href="#">learn more ></a></p>
      </div>
      <div class='blog-right'>
        <div class='title'>FEATURED GLOSSARY TERM</div>
        <div class='content'><span style='font-size:19px; color: #2f97bf;font-style:italic;font-family:Georgia;'>Distillation</span><br/> The process in which a liquid. such es water. is converted into its vapor state by heating,
          and the vapor cooled and condensed to the liquid state and</div>
        <p class='more'><a href="#">view glossary ></a></p>
      </div>
    </div><!--end .blog-->
  </div><!--end #wu-news-->
</div><!--end #wu-main-->

EOD;

  $root_template = 'two_columns_left';

  $title = 'Water University';

  $identifier = 'water-university.html';

  $layout_update = <<<EOD
<reference name="left">
<block type="cms/block" name="water.university.navigation">
    <action method="setBlockId"><block_id>water-university-navigation </block_id></action>
</block>
</reference>
<reference name="head">
  <action method="addCss"><stylesheet>css/style-default.css</stylesheet></action>
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
