<?php

$installer = $this;
$installer->startSetup();

$cmsBlockData = array(
    'title' => 'SmartFIT.com footer',
    'identifier' => 'footer_links',
    'stores' => array(Mage::getModel('core/store')->load('sf_en')->getId()),
    'is_active' => 1,
    'content' => '<div class="footer-cols-wrapper">
						<div class="footer-col footer-col-ex">			
							<h4>Information<span class="toggle"></span></h4>
							<div class="footer-col-content">
								<ul>
                                    <li><a href="{{store direct_url=\'customer_service.html\'}}">Customer Service</a></li>
                                    <li><a href="{{store direct_url=\'privacy_policy.html\'}}">Privacy Policy</a></li>
                                    <li><a href="{{store direct_url=\'catalog/seo_sitemap/category\'}}">Site Map</a></li>
                                    <li><a href="{{store direct_url=\'orders_returns.html\'}}">Orders &amp; Returns</a></li>
                                </ul>
							</div>
						</div>
						<div class="footer-col footer-col-ex">
                            <h4>Why Buy SmartFIT<span class="toggle"></span></h4>
                            <div class="footer-col-content">
   	                            <ul>
   		                            <li><a href="{{store direct_url=\'about_us.html\'}}">About Us</a></li>
   		                            <li><a href="{{store direct_url=\'storelocator\'}}">Dealer Locator</a></li>
   	                            </ul>
                            </div>
                        </div>
                        <div class="footer-col footer-col-ex">
                            <h4>My Account<span class="toggle"></span></h4>
                            <div class="footer-col-content">
   	                            <ul>
                                    <li><a href="{{store direct_url=\'customer/account\'}}">My Account</a></li>
                                    <li><a href="{{store direct_url=\'checkout/cart\'}}">View Cart</a></li>
                                    <li><a href="{{store direct_url=\'sales/order/history\'}}">Track My Order</a></li>
                                    <li><a href="{{store direct_url=\'help.html\'}}">Help</a></li>
                                </ul>
                            </div>
                        </div>						
                        <div class="footer-col last footer-col-ex">
							<h4>Contact Us<span class="toggle"></span></h4>
							<div class="footer-col-content">
							    <address>
							        <p>560 22nd Street</p>
							        <p>Zumbrota, MN 55992</p>
							        <p>Tel: 507-216-0188</p>
							    </address>
							</div>
							<h4>Hours<span class="toggle"></span></h4>
							<div class="footer-col-content">
							    <p>Mon-Fri: 8am-5pm</p>
							</div>
                        </div>
                    </div>'
);

Mage::getModel('cms/block')->setData($cmsBlockData)->save();

$installer->endSetup();