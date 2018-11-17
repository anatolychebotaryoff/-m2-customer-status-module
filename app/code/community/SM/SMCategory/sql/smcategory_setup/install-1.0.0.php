<?php



    $installer = $this;

    $installer->startSetup();

    if (Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_category','featured_category')->getData('attribute_code') != 'featured_category')
    {
    $this->addAttribute('catalog_category', 'featured_category', array(
        'group'         => 'General',

        'input'         => 'select',

        'type'          => 'varchar',

        'label'         => 'Featured Category',

        'frontend'      => '',

        'backend'       => '',

        'visible'       => 1,

        'required'      => 0,

        'user_defined' => 1,

        'source'    =>  'eav/entity_attribute_source_boolean',

        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,

    ));
    }

    if (Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product','use')->getData('attribute_code') != 'use')
    {
    $this->addAttribute('catalog_product', 'use', array(

        'group'         => 'General',

        'input'         => 'select',

        'type'          => 'varchar',

        'label'         => 'Use',

        'frontend'      => '',

        'backend'       => '',

        'visible'       => 1,

        'searchable'        => 1,

        'visible_in_advanced_search' => 1,

        'required'      => 0,

        'user_defined' => 1,

        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,

        'option' => array(
            'value' => array(
                'optionone' => array( 'Default Value Use' ),
            )
        ),

    ));
    }

    if (Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product','contaminant')->getData('attribute_code') != 'contaminant')
    {
    $this->addAttribute('catalog_product', 'contaminant', array(

        'group'         => 'General',

        'input'         => 'select',

        'type'          => 'varchar',

        'label'         => 'Contaminant',

        'frontend'      => '',

        'backend'       => '',

        'visible'       => 1,

        'visible_in_advanced_search' => true,

        'required'      => 0,

        'user_defined' => 1,

        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,

        'option' => array(
            'value' => array(
                'optionone' => array( 'Default Value Contaminant' ),
            )
        ),

    ));
    }

    $contentBannerHome = '<p><img src="{{skin url=\'images/homepage/home_banner.jpg\'}}" alt="" width="680" height="340" /></p>';
    $staticBannerHome = array(
        'title' => 'Home Banner',
        'identifier' => 'banner_home',
        'content' => $contentBannerHome,
        'is_active' => 1,
        'stores' => array(0)
    );
    if (!Mage::getModel('cms/block')->load('banner_home')->getBlockId())
    {
        Mage::getModel('cms/block')->setData($staticBannerHome)->save();
    }

    $contentBannerStatic = '<p><img src="{{skin url=\'images/homepage/static_banner.jpg\'}}" alt="" width="270" height="180" /></p>';
    $staticBannerStatic = array(
        'title' => 'Static Banner',
        'identifier' => 'banner_static',
        'content' => $contentBannerStatic,
        'is_active' => 1,
        'stores' => array(0)
    );
    if (!Mage::getModel('cms/block')->load('banner_static')->getBlockId())
    {
        Mage::getModel('cms/block')->setData($staticBannerStatic)->save();
    }

    $contentMeetOurExpert = '<div class="meet-image"><img src="{{skin url="images/bn_meet-content.jpg"}}" alt="" /></div>
                            <div class="meet-content">
                            <h3>MEET OUR EXPERT</h3>
                            <p>When John isn\'t dreaming about </br>water filters he enjoys cookings and </br>watching his beloved Vikings</p>
                            <div class="author">- John S.</div>
                            <div class="link">meet the team &gt;</div>
                            </div>';
    $staticMeetOurExpert = array(
        'title' => 'Meet Our Experts',
        'identifier' => 'meet_our_experts',
        'content' => $contentMeetOurExpert,
        'is_active' => 1,
        'stores' => array(0)
    );
    if (!Mage::getModel('cms/block')->load('meet_our_experts')->getBlockId())
    {
        Mage::getModel('cms/block')->setData($staticMeetOurExpert)->save();
    }

    $contentWeLove = '<div class="love-content">
                            <h3>WE LOVE OUR CUSTOMERS!</h3>
                            <p><span>"</sapn>The fileter is installed and works perfectly.Again,</br>
                             my father is happy that it is installed and working.</br>
                             Thank you for your professional assistance</br>
                             and patience.<span>"</sapn></p>
                            <div class="author">- Frank from Dillon Vale, OH.</div>
                            <div class="link">more testimonials &gt;</div>
                            </div>';
    $staticWeLove = array(
        'title' => 'We Love Our Customers',
        'identifier' => 'we_love_our_customers',
        'content' => $contentWeLove,
        'is_active' => 1,
        'stores' => array(0)
    );
    if (!Mage::getModel('cms/block')->load('we_love_our_customers')->getBlockId())
    {
        Mage::getModel('cms/block')->setData($staticWeLove)->save();
    }

    $this->endSetup();


