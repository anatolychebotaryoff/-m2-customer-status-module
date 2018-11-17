<?php

class USWF_SeoSuite_Model_Catalog_Category_Attribute_Backend_Meta_Canonical extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{

    public function beforeSave($object)
    {
        if ($object['category_canonical_url'] == 'custom') {
            if (Mage::app()->getRequest()->getParam('canonical_url_custom')) {
                $urlCustom = trim(Mage::app()->getRequest()->getParam('canonical_url_custom'));
                if ($urlCustom !== '') {
                    $object->setData('category_canonical_url', $urlCustom);
                }
            }
        }

        return parent::beforeSave($object);
    }

}