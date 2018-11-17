<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Block_Adminhtml_BrandCategory_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Edit page block initialize
     */
    public function __construct()
    {
       

        parent::__construct();

        $this->_blockGroup = 'uswf_brandcategory';
        $this->_controller = 'adminhtml_brandcategory';
        $this->_objectId = 'id';
        $this->form_action_url = $this->getUrl('*/*/save', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));

     }

    /**
     * Return header text
     *
     * @return string
     */
    public function getHeaderText()
    {

        $model = Mage::registry('uswf_brandcategory_record');
        if ($model && $model->getId()) {
            $storeId = $model->getStoreId();
            $storeName = Mage::app()->getStore($storeId)->getWebsite()->getName();
            $brandId = $model->getBrand();
            $brandAttr = Mage::getModel('catalog/product')->getResource()->getAttribute('brand');
            $brandName = $brandAttr->getSource()->getOptionText($brandId);
            return Mage::helper('uswf_brandcategory')
                ->__("Edit %s - '%s' Brand Category Record", $storeName , $this->escapeHtml($brandName));
        }
        else {
          return Mage::helper('uswf_brandcategory')->__('New Brand Category Record');
        }
    }
}
