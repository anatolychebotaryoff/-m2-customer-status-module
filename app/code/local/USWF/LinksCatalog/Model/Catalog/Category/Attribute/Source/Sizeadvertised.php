<?php
/**
 * USWF
 * USWF LinksCatalog Extension
 * 
 * @category   USWF
 * @package    USWF_LinksCatalog
 */

class USWF_LinksCatalog_Model_Catalog_Category_Attribute_Source_Sizeadvertised extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    public function getAllOptions($useConfig = true, $useDefault = false)
    {
        if (!$this->_options) {
            $attribute = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, 'size_advertised');
            if(is_object($attribute)){
                /** @var $attribute Mage_Eav_Model_Entity_Attribute */
                $valuesCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                    ->setAttributeFilter($attribute->getId())
                    ->setStoreFilter(0, false)
                    ->toOptionArray();
            } else {
                $valuesCollection = array(
                    array('value' => 'Attribute of size_advertised isn\'t exist', 'label' => 'Attribute of size_advertised isn\'t exist'),
                );
                Mage::log('Attribute of size_advertised isn\'t exist ::'.get_class($this));
            }

            $this->_options = $valuesCollection;
        }

        if($useDefault){
            $firstItem = reset($this->_options);
            if($firstItem && !$firstItem['value'] == ''){
                array_unshift($this->_options, array('value' => '', 'label' => 'Default'));
            }
        }
        return $this->_options;
    }

}