<?php

$content = <<<EOL
<div class="upsell-banner-content" style="background-color:{{var banner_fill_color}};color:{{var banner_text_color}}">
    <span class="upsell-banner-content-top">{{var banner_primary_text}}</span>
    <span class="upsell-banner-content-bottom">{{var banner_secondary_text}} <span class="upsell-arrow-right">&#9654;</span></span>
    <span class="upsell-banner-anchor"></span>
</div>
<div class="upsell-banner-logo-wrapper">
    <img class="upsell-banner-logo" src="{{var image_src}}" alt="">
</div>

<script type="text/javascript">

  jQuery('.box-up-sell .upsell-banner').css('border-color', '{{var banner_border_color}}');

</script>
EOL;

$identifier = 'upsell-block';

$cmsBlock = array(
    'title'         => 'Upsell Block',
    'identifier'    => $identifier,
    'content'       => $content,
    'is_active'     => 1,
    'stores'        => 0
);

$block = Mage::getModel('cms/block')->load($identifier, 'identifier');

if ($block) {
    $block->delete();
}

Mage::getModel('cms/block')->setData($cmsBlock)->save();
