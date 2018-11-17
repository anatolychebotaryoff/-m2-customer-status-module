<?php
/**
 * Footer CMS blocks for Usff website
 *
 * @category     Lyonscg
 * @package      Lyonscg_Usff
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Alexandr Pomelov (apomelov@lyonsg.com)
 */


$installer = $this;
$installer->startSetup();


// 1. Subscribe Call Time
$title = 'Fridge Subscribe Call Time';
$identifier = 'subscribe_call_time';
$content = '<h2>Give us a Call</h2>
    <h3>888-683-8353</h3>
    <h3>7am-7pm Central</h3>
    <h3>Monday-Friday</h3>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 2. Social Links

$title = 'Fridge Social Links';
$identifier = 'social_links';
$content = '<div class="one columns social-media">
    <ul class="socials">
    <li><a class="facebook" title="Facebook" href="#">&nbsp;</a></li>
    <li><a class="twitter" title="Twitter" href="#">&nbsp;</a></li>
    <li><a class="youtube" title="You Tube" href="#">&nbsp;</a></li>
    <li><a class="pinterest" title="Pinterest" href="#">&nbsp;</a></li>
    <li><a class="googleplus" title="Google Plus" href="#">&nbsp;</a></li>
    </ul>
    </div>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 3. Footer Icons

$title = 'Fridge Footer Icons';
$identifier = 'footer_icons';
$content = '<ul class="footer-logos">
    <li class="fl-1"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-1.png\'}}" alt="" /></a></li>
    <li class="fl-2"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-2.png\'}}" alt="" /></a></li>
    <li class="fl-3"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-3.png\'}}" alt="" /></a></li>
    <li class="fl-4"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-4.png\'}}" alt="" /></a></li>
    <li class="fl-5"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-5.png\'}}" alt="" /></a></li>
    <li class="fl-6"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-6.png\'}}" alt="" /></a></li>
    <li class="fl-7"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-7.png\'}}" alt="" /></a></li>
    <li class="fl-8"><a href="#" target="_blank"><img src="{{skin url=\'images/fl-8.png\'}}" alt="" /></a></li>
    </ul>
<p class="right-filters">We’ve got the right filter for your fridge.</p>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

/*----------------------------------------------------------------------------------------------------------*/
// 4. Footer Links

$title = 'Fridge Footer Links List';
$identifier = 'usff_footer_links_list';
$content = '<div class="footer-col">
    <h4>Ordering</h4>
    <div class="footer-col-content">
    <ul>
    <li><a href="#">How to Order</a></li>
    <li><a href="#">Payment Methods</a></li>
    <li><a href="#">Sales Tax</a></li>
    <li><a href="#">Auto-Delivery</a></li>
    <li><a href="#">Program</a></li>
    </ul>
    </div>
    </div>

    <div class="footer-col">
    <h4>Your Account</h4>
    <div class="footer-col-content">
    <ul>
    <li><a href="#">Order Status</a></li>
    <li><a href="#">Returns</a></li>
    <li><a href="#">Email Preferences</a></li>
    <li><a href="#">Email Reminders</a></li>
     </ul>
     </div>
    </div>

    <div class="footer-col">
    <h4>Policies</h4>
    <div class="footer-col-content">
    <ul>
    <li><a href="#">Satisfaction Guarantee</a></li>
    <li><a href="#">FREE Return Shipping</a></li>
    <li><a href="#">FREE Reminder Service</a></li>
    <li><a href="#">Privacy & Security</a></li>
      </ul>
     </div>
    </div>
    <div class="footer-col">
    <h4>Company</h4>
     <div class="footer-col-content">
      <ul>
    <li><a href="#">Contact Us</a></li>
    <li><a href="#">FAQ</a></li>
    <li><a href="#">Customer Reviews</a></li>
    <li><a href="#">Drinking Water Contaminant Glossary</a></li>
    <li><a href="#">Airborne Contaminant Glossary</a></li>
    <li><a href="#">Site Map</a></li>
    </ul>
     </div>
    </div>';

$website = Mage::getModel('core/website')->load('ff');
$stores = $website->getStores();

foreach ($stores as $store) {
    $cmsBlock = Mage::getModel('cms/block')
        ->setStoreId($store->getId())
        ->load($identifier)
        ->delete();

    $cmsBlock = Mage::getModel('cms/block')
        ->setTitle($title)
        ->setIdentifier($identifier)
        ->setContent($content)
        ->setStores($store->getId())
        ->save();
}

$installer->endSetup();


