<?php
/**
 * Creating a static block for upsell banner
 *
 * @category   Lyons
 * @package    Lyonscg_Catalog
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Valentin Ponomarenko (vponomarenko@lyonscg.com)
 */ 

$content = '<img src="{{media url="wysiwyg/dfs-comparable-1.png"}}" class="background-image" />
<img src="{{var item_image}}" class="product-image" alt="{{var item_name}}" title="{{var item_name}}" />
<div class="description">Buy the {{var item_sku}} filter at a fraction of the price.</div>
<div class="price">Save {{var price_differ}} on your filter.</div>';

$cmsBlock = array(
    'title'         => 'Upsell Block',
    'identifier'    => 'upsell-block',
    'content'       => $content,
    'is_active'     => 1,
    'stores'        => 0
);

Mage::getModel('cms/block')->setData($cmsBlock)->save();