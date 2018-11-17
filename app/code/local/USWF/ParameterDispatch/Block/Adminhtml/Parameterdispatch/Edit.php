<?php
/**
 * USWF Parameter Dispatch Event
 *
 * @category    USWF
 * @package     USWF_ParameterDispatch
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_ParameterDispatch_Block_Adminhtml_ParameterDispatch_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Edit page block initialize
     */
    public function __construct()
    {
       

        parent::__construct();

        $this->_blockGroup = 'uswf_parameterdispatch';
        $this->_controller = 'adminhtml_parameterdispatch';
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
        $model = Mage::registry('uswf_parameterdispatch_event');
        if ($model && $model->getId()) {
          return Mage::helper('uswf_parameterdispatch')
              ->__("Edit '%s' Parameter Dispatch Event", $this->escapeHtml($model->getParam()));
        }
        else {
          return Mage::helper('uswf_parameterdispatch')->__('New Parameter Dispatch Event');
        }
    }
}
