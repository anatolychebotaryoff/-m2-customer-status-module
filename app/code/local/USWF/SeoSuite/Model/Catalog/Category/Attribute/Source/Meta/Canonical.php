<?php

class USWF_SeoSuite_Model_Catalog_Category_Attribute_Source_Meta_Canonical extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    public function getAllOptions()
    {
        $category = Mage::registry('current_category');

        if (!$this->_options) {
            $this->_options = array();
            $this->_options[] = array('value' => '', 'label' => Mage::helper('seosuite')->__('Use Config'));
            $this->_options[] = array('value' => 'custom', 'label' => Mage::helper('seosuite')->__('Use Custom'));
            if ($category->getData('category_canonical_url') != '') {
                $this->_options[] = array(
                    'value' => $category->getData('category_canonical_url'),
                    'label' => $category->getData('category_canonical_url')
                );
            }
        }

        return $this->_options;
    }
}