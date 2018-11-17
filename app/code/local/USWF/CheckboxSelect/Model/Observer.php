<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_CheckboxSelect
 * @copyright
 * @author
 */

class USWF_CheckboxSelect_Model_Observer
{
    /**
     * App model
     *
     * @var Mage_Core_Model_App
     */
    protected $_app;

    /**
     * Constructor with parameters.
     *
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        $this->_app = !empty($args['app']) ? $args['app'] : Mage::app();
    }

    /**
     * Add element in form
     *
     * @param Varien_Event_Observer $observer
     */
    public function adminhtmlCatalogCategoryEditPrepareForm(Varien_Event_Observer $observer){
        $form = $observer->getEvent()->getForm();
        $elements = $form->getElements();
        foreach($elements as $elem){
            foreach($elem->getElements() as $field){
                if ($this->canDisplayUseDefault($field)) {
                    $elem->addField('checkboxSelect', 'column', array(
                        'required'  => true,
                        'name'      => 'checkboxSelect',
                        'container_id' => $field->getContainer()->getHtmlId()
                    ),'^');
                    break;
                }
            }
        }
        $checkboxSelect = $form->getElement('checkboxSelect');
        if ($checkboxSelect) {
            $checkboxSelect->setRenderer(
                $this->_app->getFrontController()->getAction()->getLayout()
                    ->createBlock('uswf_checkboxselect/adminhtml_catalog_form_renderer_fieldset_element')
            );
        }
    }

    private function canDisplayUseDefault($element)
    {
        if ($attribute = $element->getEntityAttribute()) {
            if (!$attribute->isScopeGlobal()
                && $element->getForm()->getDataObject()
                && $element->getForm()->getDataObject()->getId()
                && $element->getForm()->getDataObject()->getStoreId()) {
                return true;
            }
        }
        return false;
    }

}