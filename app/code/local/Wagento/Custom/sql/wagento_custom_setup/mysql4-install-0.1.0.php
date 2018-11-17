<?php
try{
    $installer = $this;
    $installer->startSetup();

    // Create footer block
    $content =
<<<EOD
<div class="bg-footer">
<div class="bx-footer bx-1">
<h4><a href="#">Ordering</a></h4>
<ul>
<li><a href="#">How to order</a></li>
<li><a href="#">Order form</a></li>
<li><a href="#">Clearance center</a></li>
<li><a href="#">Auto-Ship Program</a></li>
<li><a href="#">Porpular Searches</a></li>
</ul>
</div>
<div class="bx-footer bx-2">
<h4><a href="#">Your Account</a></h4>
<ul>
<li><a href="#">Create Acount</a></li>
<li><a href="#">My Account</a></li>
<li><a href="#">Order Status</a></li>
<li><a href="#">Reorder</a></li>
<li><a href="#">FREE Reminders</a></li>
</ul>
</div>
<div class="bx-footer bx-3">
<h4><a href="#">Polocies</a></h4>
<ul>
<li><a href="#">Low Price Guarantee</a></li>
<li><a href="#">Term &amp; Conditions</a></li>
<li><a href="#">Shipping Policy &amp; Rates</a></li>
<li><a href="#">Returns &amp; Exchanges</a></li>
<li><a href="#">Privacy &amp; Security</a></li>
</ul>
</div>
<div class="bx-footer bx-4">
<h4><a href="#">Company</a></h4>
<ul>
<li><a href="#">About Us</a></li>
<li><a href="#">Contact Us</a></li>
<li><a href="#">Water University</a></li>
<li><a href="#">Water Filter for Charity</a></li>
<li><a href="#">Customer Testimonials</a></li>
<li><a href="#">Affiliate Program</a></li>
<li><a href="#">Carreers</a></li>
</ul>
</div>
<div class="bx-social">
<ul>
<li><a>.</a></li>
</ul>
</div>
<div class="bx-footer bx-5">
<ul>
<li class="call"><span style="font-style: italic;">Give us a call: </span> <br /> {{config path="contacts/contacts/phone"}} - Pure({{config path="contacts/contacts/pure"}})</li>
<li>{{block type="core/template" name="sm_newsletter" template="newsletter/subscribe.phtml" }}</li>
<li><img src="../skin/frontend/enterprise/wfn/images/sale-subscribe.jpg" alt="" width="300" height="80" /></li>
</ul>
</div>
</div>
<!--end .bg-footer-->
<div style="clear: both;">&nbsp;</div>
<div class="bg-partner">&nbsp;</div>
<div class="footer-bottom">Committed to making a difference through: Water Filters for Charity,<br />improving Water and the World,and 360 Degree Service</div>
<!--end #footer-->
EOD;

	$title = 'Footer Links';

	$identifier = 'footers_custom';

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

    $installer->endSetup();

}catch(Excpetion $e){
    Mage::logException($e);
    Mage::log("ERROR IN SETUP ".$e->getMessage());
}
