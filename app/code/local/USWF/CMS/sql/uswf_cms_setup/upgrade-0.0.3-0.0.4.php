<?php

$installer = $this;

if (!$installer->getConnection()->tableColumnExists($installer->getTable('cms_page'), 'ro_product_sku')) {
    $installer->getConnection()->addColumn($installer->getTable('cms_page'), 'ro_product_sku', "varchar(255) NOT NULL DEFAULT ''");
}

$roCss = <<<HTML
<style>
    .std i.fa {
        font-style: inherit;
    }
    .container_26 {
        width: 95%;
        margin: 0 auto;
    }
    .container_26 a{
        cursor: pointer;
    }
    @media only screen and (min-width: 1260px) {
        .container_26 {
            width: 1260px;
        }
    }

    /*3X1 area start*/
    .col-x-3 {
        width: 32.26%;
        display: block;
        float: left;
        margin: 1% 0 1% 1.6%;
    }
    .col-x-3:first-child {
        margin-left: 0;
    }

    .col-x-3.col_1_of_3 > div,
    .col-x-3.col_2_of_3 > div,
    .col-x-3.col_3_of_3 > div {
        width: 100%;
        height: auto;
        background-repeat: no-repeat;
        background-size: 100%;
        padding-top: 46%;
        color: white;
        position: relative;
    }

    .col-x-3 .text-bottom {
        color: white;
        position: absolute;
        bottom: 7%;
        width: 100%;
        font-size: 2.1em;
        text-align: center;
    }

    @media only screen and (max-width: 779px) {
        .col-x-3 {
            margin: 1% 0 1% 0;
            width: 100%;
        }
        .col-x-3.col_1_of_3 > div,
        .col-x-3.col_2_of_3 > div,
        .col-x-3.col_3_of_3 > div {
            width: 280px;
            padding-top: 130px;
            margin-left: auto;
            margin-right: auto;
        }
    }
    @media only screen and (max-width: 969px) {
        .col-x-3 .text-bottom {
            font-size: 1.6em;
        }
    }
    /*3X1 area end*/

    /*++++++++++++++++++++++++++++++++*/
    .box-2 .col_1_of_2,
    .box-2 .col_2_of_2 {
        margin-top: 30px;
    }
    .box-2 .col_1_of_2 {
        width: 20%;
        float: left;
        margin-left: 5%;
    }
    .box-2 .col_1_of_2 img{
        width: 100%;
    }
    .box-2 .col_2_of_2 {
        width: 70%;
        float: right;
    }
    .box-2 h2 {
        height: 40px;
        font-size: 2.1em;
        line-height: 1.7;
        text-align: center;
        color: white;
        background: -webkit-gradient(linear, left top, left bottom, from(#1d9bfc), to(#027ddc));
        background: -moz-linear-gradient(top, #1d9bfc, #027ddc);
        background: -o-linear-gradient(top, #1d9bfc, #027ddc);
        background: -ms-linear-gradient(top, #1d9bfc, #027ddc);
    }
    .box-2 .box-x-content,.box-3 .box-x-content {
        margin: 15px 20px 0 20px;
        text-align: initial;
    }
    @media only screen and (max-width: 779px) {
        .box-2 .col_1_of_2,
        .box-2 .col_2_of_2 {
            width: 100%;
            float: none;
            margin-left: 0;
            text-align: center;
        }
        .box-2 .col_1_of_2 img {
            width: 50%;
            margin-top: 20px;
        }
        .box-2 .col_2_of_2 {
            margin-top: 0;
        }
    }
    /*++++++++++++++++++++++++++++*/
    .box-3, .box-5, .box-6 {
        float: left;
        margin-top: 35px;
        width: 100%;
    }
    .box-3 h2, .box-5 h2, .box-6 h2 {
        height: 40px;
        font-size: 2.1em;
        line-height: 1.7;
        text-align: center;
        color: white;
        background: -webkit-gradient(linear, left top, left bottom, from(#1d9bfc), to(#027ddc));
        background: -moz-linear-gradient(top, #1d9bfc, #027ddc);
        background: -o-linear-gradient(top, #1d9bfc, #027ddc);
        background: -ms-linear-gradient(top, #1d9bfc, #027ddc);
    }
    .box-3 .col_1_of_1, .box-5 h2, .box-6 h2  {
        width: 100%;
    }
    /*++++++++++++++++++++++++++++*/
    .box-4 {
        float: left;
        margin-top: 35px;
        width: 100%;
    }
    .box-4 h2 {
        font-size: 2.1em;
        text-align: center;
    }
    .col-x-5 {
        width: 91%;
        margin-left: auto;
        margin-right: auto;
    }
    .col-x-5 div{
        float: left;
        position: relative;
    }
    .col-x-5 div p{
        position: absolute;
        top: 80px;
        left: 50px;
        right: 15px;
        color: white;
    }
    @media only screen and (max-width: 659px) {
        .col-x-5 {
            text-align: center;
        }
        .col-x-5 div {
            float: none;
        }
        .col-x-5 div p {
            width: 35%;
            text-align: left;
            margin-left: auto;
            margin-right: auto;
        }
    }
    /***************************/
    .box-5 .col_1_of_1 {
        border-left: 2px solid #b4b4b4;
        border-right: 2px solid #b4b4b4;
        border-bottom: 2px solid #b4b4b4;
    }
    .box-5 h2 {
        margin-bottom: 0;
    }
    .box-5 #accordion_box_5 div {
        margin: 0 10px 15px 10px;
    }
    .box-5 #accordion_box_5 div:first-child {
        padding-top: 25px;
    }
    .box-5 #accordion_box_5 div .box-x-content  {
        padding: 15px 10px 15px 10px;
        margin: 0;
        border-left: 2px solid #b4b4b4;
        border-right: 2px solid #b4b4b4;
        border-bottom: 2px solid #b4b4b4;
    }
    .box-5 #accordion_box_5 div h3 {
        padding: 10px;
        margin-bottom: 0;
        font-size: 1.8em;
        color: #1D9BFB;
        background: white;
        border: 2px solid #b4b4b4;
    }

    .box-5 #accordion_box_5 div h3.close + .box-x-content {
        display: none;
    }
    .box-5 #accordion_box_5 div h3.close:before {
        background-image: url("{{skin url='images/uswf/cms/ro/close.png'}}");
    }
    .box-5 #accordion_box_5 div h3.open:before {
        background-image: url("{{skin url='images/uswf/cms/ro/open.png'}}");
        margin-left: 15px;
    }
    .box-5 #accordion_box_5 div h3.close:before,
    .box-5 #accordion_box_5 div h3.open:before{
        display: inline-block;
        margin-top: 4px;
        float: left;
        width: 16px;
        height: 16px;
        margin-right: 10px;
        content: "";
        background-size: 100%;
        background-repeat: no-repeat;
        cursor: pointer;
    }
    /***************************/
    .box-6 .box-x-content  {
        margin: 0 15px 0 15px;
        text-align: center;
    }
    .box-6 .col_1_of_1  {
        text-align: center;
    }
    @media only screen and (max-width: 612px) {
        .box-6 img {
            width: 100%;
        }
    }
</style>
HTML;

$roContent = <<<HTML
<div class="ro-content">
    <!--3X1 area start-->
    <style>
        .col-x-3.col_1_of_3 > div {
            background-image: url("{{skin url='images/uswf/cms/ro/Untitled(1).jpg'}}");
        }
        .col-x-3.col_2_of_3 > div {
            background-image: url("{{skin url='images/uswf/cms/ro/Untitled(1).jpg'}}");
        }
        .col-x-3.col_3_of_3 > div {
            background-image: url("{{skin url='images/uswf/cms/ro/Untitled(1).jpg'}}");
        }
    </style>
    <div class="box-1">
        <div class="col-x-3 col_1_of_3">
            <div>
                <a class="text-bottom">Fridge Filters</a>
            </div>
        </div>
        <div class="col-x-3 col_2_of_3" >
            <div>
                <a class="text-bottom">Fridge Filters</a>
            </div>
        </div>
        <div class="col-x-3 col_3_of_3">
            <div>
                <a class="text-bottom">Fridge Filters</a>
            </div>
        </div>
    </div>
    <!--3X1 area end-->

    <div class="box-2">
        <div class="col_1_of_2">
            <img  src="{{skin url='images/uswf/cms/ro/ro-image.jpg'}}" alt="test" title="test" />
        </div>
        <div class="col_2_of_2">
            <h2>What is Reverse Osmosis&</h2>
            <div class="box-x-content">
                We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
            </div>
            <div class="box-x-content">
                Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
            </div>
        </div>
    </div>

    <div class="box-3">
        <div class="col_1_of_1">
            <h2>What is Reverse Osmosis Systems work?</h2>
            <div class="box-x-content">
                We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
            </div>
            <div class="box-x-content">
                Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
            </div>
        </div>
    </div>

    <style>
        /*change here*/
        .col-x-5 div.col_1_of_5 p {
            top: 80px;
            left: 50px;
            right: 15px;
        }
        @media only screen and (max-width: 659px) {
            .col-x-5 div.col_1_of_5 p{
                width: 35%;
                top: 20px;
                left: 50px;
                right: 15px;
            }
        }
    </style>
    <div class="box-4">
        <h2>What is Reverse Osmosis Systems work?</h2>
        <div class="col-x-5">
            <div class="col_1_of_5">
                <img src="{{skin url='images/uswf/cms/ro/ro-1.jpg'}}"/>
                <p>water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.</p>
            </div>
            <div class="col_2_of_5">
                <img src="{{skin url='images/uswf/cms/ro/ro-2.jpg'}}"/>
                <p>digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.</p>
            </div>
            <div class="col_3_of_5">
                <img src="{{skin url='images/uswf/cms/ro/ro-3.jpg'}}"/>
                <p>digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.</p>
            </div>
            <div class="col_4_of_5">
                <img src="{{skin url='images/uswf/cms/ro/ro-4.jpg'}}"/>
                <p>digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.</p>
            </div>
            <div class="col_5_of_5">
                <img src="{{skin url='images/uswf/cms/ro/ro-5.jpg'}}"/>
                <p>Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.</p>
            </div>
        </div>
    </div>

    <div class="box-3">
        <div class="col_1_of_1">
            <h2>What is Reverse Osmosis Systems work?</h2>
            <div class="box-x-content">
                We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
            </div>
            <div class="box-x-content">
                Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
            </div>
        </div>
    </div>

    <div class="box-5">
        <h2>What is Reverse Osmosis Systems work?</h2>
        <div class="col_1_of_1" id="accordion_box_5">
            <div>
                <h3 class="close">We know man-made chemicals make it into our everyday drinking water, however</h3>
                <div class="box-x-content">
                    We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                    Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
                </div>
            </div>
            <div>
                <h3 class="close">Reverse Osmosis Systems work</h3>
                <div class="box-x-content">
                    We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                    Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
                </div>
            </div>
            <div>
                <h3 class="close">Reverse Osmosis Systems work</h3>
                <div class="box-x-content">
                    We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                    Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
                </div>
            </div>
            <div>
                <h3 class="close">Reverse Osmosis Systems work</h3>
                <div class="box-x-content">
                    We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                    Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
                </div>
            </div>
            <div>
                <h3 class="close">Reverse Osmosis Systems work</h3>
                <div class="box-x-content">
                    We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                    Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
                </div>
            </div>
            <div>
                <h3 class="close">Reverse Osmosis Systems work</h3>
                <div class="box-x-content">
                    We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                    Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
                </div>
            </div>
            <div>
                <h3 class="close">Reverse Osmosis Systems work</h3>
                <div class="box-x-content">
                    We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
                    Below you’ll find dozens of water testing kits & products from pH test strips, digital water test meters, to basic bacteria/lead water testing kits to advanced pesticide and all encompassing water test kits, designed to examine your drinking water for all 83 common water contaminants.
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery( function() {
            jQuery('#accordion_box_5 div h3').on('click', function() {
                jQuery(this).toggleClass(function() {
                    jQuery(this).next('.box-x-content').slideToggle();
                    if ( jQuery(this).is('.close') ) {
                        jQuery(this).removeClass('close');
                        return "open";
                    } else {
                        jQuery(this).removeClass('open');
                        return "close";
                    }
                });
            });
        });
    </script>

    <div class="box-6">
        <div class="col_1_of_1">
            <h2>What is Reverse Osmosis Systems work?</h2>
            <div class="box-x-content">
                We know man-made chemicals make it into our everyday drinking water, however most of the time city water filters and our own home water filters are able to filter out those contaminants.  Testing your homes water no longer requires the help of a professional, with drinking water testing kits from Discount Filter Store you can quickly and easily test your homes drinking water for various contaminants.  Whether you’re concerned with the quality of your water or just want to see what contaminants might be lurking in your drinking water we recommend testing your homes water with a do-it-yourself drinking water testing kit.
            </div>
            <img src="{{skin url='images/uswf/cms/ro/diagram.png'}}"/>
        </div>
    </div>
</div>
HTML;


$store = Mage::getModel('core/store')->load('dfs_en', 'code')->getId();

$blockCss = Mage::getModel('cms/block')->load('ro_css', 'identifier');
if ($blockCss->isEmpty()) {
    $blockCss->setTitle('RO Css');
    $blockCss->setIdentifier('ro_css');
    $blockCss->setStores($store);
    $blockCss->setIsActive(1);
    $blockCss->setContent($roCss);
    $blockCss->save();
}

$blockRoContent = Mage::getModel('cms/block')->load('ro_content', 'identifier');
if ($blockRoContent->isEmpty()) {
    $blockRoContent->setTitle('RO Content');
    $blockRoContent->setIdentifier('ro_content');
    $blockRoContent->setStores($store);
    $blockRoContent->setIsActive(1);
    $blockRoContent->setContent($roContent);
    $blockRoContent->save();
}


$cmsPage = Mage::getModel('cms/page')->load('roproduct', 'identifier');
if ($cmsPage->isEmpty()) {
    $cmsPage
        ->setStoreId(array($store))
        ->setTitle('RO')
        ->setIdentifier('roproduct')
        ->setIsActive(1)
        ->setRootTemplate('uswf_ro')
        ->setContent('<p>{{widget type="cms/widget_block" template="cms/widget/static_block/default.phtml" block_id="'.$blockCss->getId().'"}}</p><p>{{widget type="cms/widget_block" template="cms/widget/static_block/default.phtml" block_id="'.$blockRoContent->getId().'"}}</p>');
    $cmsPage->save();
}




$installer->endSetup();
