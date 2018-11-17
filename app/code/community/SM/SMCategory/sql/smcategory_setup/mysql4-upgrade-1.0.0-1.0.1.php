<?php



    $installer = $this;

    $installer->startSetup();

    if (Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_category','short_name')->getData('attribute_code') != 'short_name')
    {
    $this->addAttribute('catalog_category', 'short_name', array(
        'group'         => 'General Information',

        'input'         => 'text',

        'type'          => 'varchar',

        'label'         => 'Short Name',

        'frontend'      => '',

        'backend'       => '',

        'visible'       => 1,

        'required'      => 0,

        'user_defined'  => 1,

        'sort_order'    => 0,

        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,

    ));
    }

    $this->endSetup();


