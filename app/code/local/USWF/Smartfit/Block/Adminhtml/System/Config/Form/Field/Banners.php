<?php
/**
 * Banners.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Block_Adminhtml_System_Config_Form_Field_Banners 
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract 
{
    public function __construct() {
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Banner');
        parent::__construct();
        $this->setTemplate('uswf_smartfit/system/config/form/field/array.phtml');
    }

    public function _prepareToRender()
    {
        $this->addColumn('link', array(
            'label' => Mage::helper('adminhtml')->__('Link'),
            'style' => 'width:120px'
        ));
        $this->addColumn('image', array(
            'label' => Mage::helper('adminhtml')->__('Image'),
            'style' => 'width:120px',
            'renderer' => $this->getLayout()->createBlock('uswf_smartfit/adminhtml_banners_renderer_file'),
            'empty_renderer' => $this->getLayout()->createBlock('uswf_smartfit/adminhtml_banners_renderer_emptyfile'),
        ));
        return parent::_prepareToRender();
    }

    /**
     * Add a column to array-grid
     *
     * @param string $name
     * @param array $params
     */
    public function addColumn($name, $params)
    {
        $this->_columns[$name] = array(
            'label'     => empty($params['label']) ? 'Column' : $params['label'],
            'size'      => empty($params['size'])  ? false    : $params['size'],
            'style'     => empty($params['style'])  ? null    : $params['style'],
            'class'     => empty($params['class'])  ? null    : $params['class'],
            'renderer'  => false,
        );
        if ((!empty($params['renderer'])) && ($params['renderer'] instanceof Mage_Core_Block_Abstract)) {
            $this->_columns[$name]['renderer'] = $params['renderer'];
        }
        if ((!empty($params['empty_renderer'])) && ($params['empty_renderer'] instanceof Mage_Core_Block_Abstract)) {
            $this->_columns[$name]['empty_renderer'] = $params['empty_renderer'];
        }
    }

    /**
     * Render array cell for prototypeJS template
     *
     * @param string $columnName
     * @return string
     */
    protected function _renderCellEmptyTemplate($columnName)
    {
        if (empty($this->_columns[$columnName])) {
            throw new Exception('Wrong column name specified.');
        }
        $column     = $this->_columns[$columnName];
        $inputName  = $this->getElement()->getName() . '[#{_id}][' . $columnName . ']';

        if (isset($column['empty_renderer']) && $column['empty_renderer']) {
            return $column['empty_renderer']->setInputName($inputName)->setColumnName($columnName)->setColumn($column)
                ->toHtml();
        }

        return '<input type="text" name="' . $inputName . '" value="#{' . $columnName . '}" ' .
        ($column['size'] ? 'size="' . $column['size'] . '"' : '') . ' class="' .
        (isset($column['class']) ? $column['class'] : 'input-text') . '"'.
        (isset($column['style']) ? ' style="'.$column['style'] . '"' : '') . '/>';
    }
}