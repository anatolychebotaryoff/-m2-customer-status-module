<?php
/**
 * Element.php
 *
 * @category    USWF
 * @package     USWF_CheckboxSelect
 * @copyright
 * @author
 */

class USWF_CheckboxSelect_Block_Adminhtml_Catalog_Form_Renderer_Fieldset_Element
    extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{
    /**
     * Initialize block template
     */
    protected function _construct()
    {
        $this->setTemplate('uswf/checkboxselect/catalog/form/renderer/fieldset/element.phtml');
    }

}
