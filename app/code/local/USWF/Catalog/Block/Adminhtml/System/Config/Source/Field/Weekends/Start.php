<?php

class USWF_Catalog_Block_Adminhtml_System_Config_Source_Field_Weekends_Start
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $_timeRenderer;

    protected $_dayRenderer;

    public function __construct() {
        parent::__construct();
        $this->setTemplate('uswf/catalog/system/config/form/field/array.phtml');
    }

    public function _prepareToRender()
    {
        $this->addColumn('day', array(
            'renderer' => $this->_getDayRenderer(),
            'label' => Mage::helper('adminhtml')->__('Start Day'),
            'style' => 'width:75px',
        ));
        $this->addColumn('time', array(
            'renderer' => $this->_getTimeRenderer(),
            'label' => Mage::helper('adminhtml')->__('Start Time'),
            'style' => 'width:100px',
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add');
    }

    /**
     * Retrieve column renderer
     *
     * @return USWF_Catalog_Block_Adminhtml_System_Config_Source_Field_Day
     */
    protected function  _getDayRenderer()
    {
        if (!$this->_dayRenderer) {
            $this->_dayRenderer = $this->getLayout()->createBlock(
                'uswf_catalog/adminhtml_system_config_source_field_day', '',
                array('is_render_to_js_template' => true)
            );
            $this->_dayRenderer->setExtraParams('style="width:140px"');
        }
        return $this->_dayRenderer;
    }

    /**
     * Retrieve column renderer
     *
     * @return USWF_Catalog_Block_Adminhtml_System_Config_Source_Field_Time
     */
    protected function _getTimeRenderer()
    {
        if (is_null($this->_timeRenderer)) {
            $this->_timeRenderer = $this->getLayout()->createBlock(
                'uswf_catalog/adminhtml_system_config_source_field_time', '',
                array('is_render_to_js_template' => true)
            );
            $this->_timeRenderer->setExtraParams('style="width:140px"');
        }
        return $this->_timeRenderer;
    }

    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getDayRenderer()->calcOptionHash($row->getData('day')),
            'selected="selected"'
        );

        $time = $row->getData('time');
        $row->setData(
            'option_extra_attr_' . $this->_getTimeRenderer()->calcOptionHash(0, $time[0]),
            'selected="selected"'
        );
        $row->setData(
            'option_extra_attr_' . $this->_getTimeRenderer()->calcOptionHash(1, $time[1]),
            'selected="selected"'
        );
        $row->setData(
            'option_extra_attr_' . $this->_getTimeRenderer()->calcOptionHash(2, $time[2]),
            'selected="selected"'
        );
    }
}