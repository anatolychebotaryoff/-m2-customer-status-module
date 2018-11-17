<?php


    $installer = $this;

    $installer->startSetup();

    $installer->run("
     
        DELETE FROM {$this->getTable('cms_page')} WHERE identifier = 'home' and title = 'WFN HOME';
     
    ");

    $layoutUpdate= '<reference name="Breadcrumbs">
                    <remove name="breadcrumbs" />
                    </reference>';

    $contentHome = '<div class="row-fluid show-grid landingholder">
                    <div class="span8">{{block type="banner7/banner7" before="-" name="banner7" template="magentothem/banner7/banner7.phtml"}}</div>
                    <div class="bx-filter">{{block type="catalogsearch/advanced_form" template="catalogsearch/advanced/homepage/form.phtml"}}</div>
                    <div class="static-banner">{{block type="cms/block" block_id="banner_static"}}</div>
                    </div>';
    $cmsHome = array(
        'title' => 'WFN HOME',
        'root_template' => 'one_column',
        'identifier' => 'home',
        'content' => $contentHome,
        'is_active' => 1,
        'layout_update_xml' => $layoutUpdate,
        'stores' => array(0)
    );
    if (!Mage::getModel('cms/page')->load('home')->getBlockId())
    {
        Mage::getModel('cms/page')->setData($cmsHome)->save();
    }

    $this->endSetup();


