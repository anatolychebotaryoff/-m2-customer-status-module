<?php
/**
 * HTML select element block
 * Class USWF_Catalog_Block_Adminhtml_System_Config_Source_Field_Time
 */

class USWF_Catalog_Block_Adminhtml_System_Config_Source_Field_Time
    extends Mage_Core_Block_Abstract
{
    protected $_options = array();

    /**
     * Get options of the element
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Set options for the HTML select
     *
     * @param array $options
     * @return Mage_Core_Block_Html_Select
     */
    public function setOptions($options)
    {
        $this->_options = $options;
        return $this;
    }

    /**
     * Add an option to HTML select
     *
     * @param string $value  HTML value
     * @param string $label  HTML label
     * @param array  $params HTML attributes
     * @return Mage_Core_Block_Html_Select
     */
    public function addOption($value, $label, $params=array())
    {
        $this->_options[] = array('value' => $value, 'label' => $label, 'params' => $params);
        return $this;
    }

    /**
     * Set element's HTML ID
     *
     * @param string $id ID
     * @return Mage_Core_Block_Html_Select
     */
    public function setId($id)
    {
        $this->setData('id', $id);
        return $this;
    }

    /**
     * Set element's CSS class
     *
     * @param string $class Class
     * @return Mage_Core_Block_Html_Select
     */
    public function setClass($class)
    {
        $this->setData('class', $class);
        return $this;
    }

    /**
     * Set element's HTML title
     *
     * @param string $title Title
     * @return Mage_Core_Block_Html_Select
     */
    public function setTitle($title)
    {
        $this->setData('title', $title);
        return $this;
    }

    /**
     * HTML ID of the element
     *
     * @return string
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * CSS class of the element
     *
     * @return string
     */
    public function getClass()
    {
        return $this->getData('class');
    }

    /**
     * Returns HTML title of the element
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * Render HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html = '<input type="hidden" id="' . $this->getId() . '" />';
        $html .= '<div '.$this->getExtraParams().'>';
        $name = $this->getName() . '[0]';
        $html .= '<select name="'. $name . '"  style="width:40px">';
        for( $i=0;$i<24;$i++ ) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html.= '<option value="'.$hour.'" '. '#{option_extra_attr_' . $this->calcOptionHash(0, $hour).'}' .' >' . $hour . '</option>';
        }
        $html.= '</select>';
        $name = $this->getName() . '[1]';
        $html.= '&nbsp;:&nbsp;<select name="'. $name . '"  style="width:40px">';
        for( $i=0;$i<60;$i++ ) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html.= '<option value="'.$hour.'" '. '#{option_extra_attr_' . $this->calcOptionHash(1, $hour).'}' .' >' . $hour . '</option>';
        }
        $html.= '</select>';
        $name = $this->getName() . '[2]';
        $html.= '&nbsp;:&nbsp;<select name="'. $name  . '" style="width:40px">';
        for( $i=0;$i<60;$i++ ) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html.= '<option value="'.$hour.'" '. '#{option_extra_attr_' . $this->calcOptionHash(2, $hour).'}' .' >' . $hour . '</option>';
        }
        $html.= '</select>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Alias for toHtml()
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->toHtml();
    }

    /**
     * Calculate CRC32 hash for option value
     *
     * @param int $idTime
     * @param string $optionValue Value of the option
     * @return string
     */
    public function calcOptionHash($idTime, $optionValue)
    {
        $name = $this->getName(). '['.$idTime.']';
        return sprintf('%u', crc32($name . $this->getId() . $optionValue));
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }
}