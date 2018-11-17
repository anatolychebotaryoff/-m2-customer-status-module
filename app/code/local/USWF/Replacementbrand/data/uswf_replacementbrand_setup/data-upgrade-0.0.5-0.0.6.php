<?php

$installer = $this;
$installer->startSetup();

$cmsBlockData = array(
    'title' => 'ReplacementBrand.com footer',
    'identifier' => 'footer_links',
    'stores' => array(Mage::getModel('core/store')->load('rb_en')->getId()),
    'is_active' => 1,
    'content' => '<div class="footer-cols-wrapper">
						<div class="footer-col col-xs-4 col-sm-4 col-md-4 col-lg-3 footer_st_block">
							<a href="{{store url=\'\'}}"><img src="{{skin url=\'images/logo.png\'}}"></a>
                            <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.</p>
						</div>
						<div class="footer-col col-xs-3 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1 col-lg-2 col-lg-offset-0">
							<h4>Customer Service</h4>
							<div class="footer-col-content">
                                    <ul>
                                        <li><a href="#">Help / FAQ</a></li>
                                        <li><a href="#">Shipping Policy</a></li>
                                        <li><a href="#">Return Policy</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Order Form</a></li>
                                        <li><a href="#">No Worries Guarantee</a></li>
                                    </ul>
							</div>
						</div>
                        <div class="footer-col col-xs-4 col-sm-4 col-md-4 col-lg-2">
                              <h4>My Account</h4>
                              <div class="footer-col-content">
                                    <ul>
                                        <li><a href="{{store direct_url=\'customer/account/login\'}}">Sign In / Register</a></li>
                                        <li><a href="{{store direct_url=\'customer/account\'}}">My Account</a></li>
                                        <li><a href="{{store direct_url=\'checkout/cart\'}}">View Cart</a></li>
                                        <li><a href="{{store direct_url=\'sales/order/history\'}}">Order History</a></li>
                                        <li><a href="{{store direct_url=\'checkout/cart\'}}">Checkout</a></li>
                                    </ul>
                              </div>
                        </div>
                        <div class="footer-col col-xs-6 col-sm-5 col-md-5 col-lg-2 clear-left">
                            <h4>Information</h4>
                                <div class="footer-col-content">
                                    <ul>
                                        <li><a href="{{store direct_url=\'catalog/seo_sitemap/category\'}}">Site Map</a></li>
                                        <li><a href="#">Blog</a></li>
                                        <li><a href="#">Everything Guide to Filters</a></li>
                                        <li><a href="#">Video Center</a></li>
                                        <li><a href="#">Terms & Conditions</a></li>
                                        <li><a href="#">Affiliate Program</a></li>
                                    </ul>
                                </div>
                        </div>
						<div class="footer-col col-xs-6 col-sm-7 col-md-7 col-lg-3">
                            <div class="footer_address">
                                22nd Street, <br />Zumbrota, MN 55992
                                <span class="tel">507-216-0188</span>
                            </div>
                            <div class="soc-icon">
                                <a href="#"><span class="fa fa-facebook"></span></a>
                                <a href="#"><span class="fa fa-twitter"></span></a>
                                <a href="#"><span class="fa fa-google-plus"></span></a>
                                <a href="#"><span class="fa fa-youtube"></span></a>
                            </div>
						</div>
						<div class="clear"></div>
					  </div>'
);

Mage::getModel('cms/block')->setData($cmsBlockData)->save();

$installer->endSetup();