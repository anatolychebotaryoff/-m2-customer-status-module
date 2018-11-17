<?php

$installer = $this;

$replace = <<<HTML
    .box-5 #accordion_box_5 div h3.open:before {
        background-image: url("{{skin url='images/uswf/cms/ro/open.png'}}");
        margin-left: 15px;
    }
HTML;
$replaceTo = <<<HTML
    .box-5 #accordion_box_5 div h3.open:before {
        background-image: url("{{skin url='images/uswf/cms/ro/open.png'}}");
    }
HTML;

$blockCss = Mage::getModel('cms/block')->load('ro_css', 'identifier');
if ($blockCss) {
    $content = $blockCss->getContent();
    $result = str_replace($replace, $replaceTo, $content);
    $blockCss->setContent($roCss);
    $blockCss->save();
}
$installer->endSetup();
