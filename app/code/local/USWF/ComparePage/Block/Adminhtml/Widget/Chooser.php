<?php

class USWF_ComparePage_Block_Adminhtml_Widget_Chooser extends Mage_Widget_Block_Adminhtml_Widget_Chooser
{

    /**
     * Return chooser HTML and init scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        $element   = $this->getElement();
        /* @var $fieldset Varien_Data_Form_Element_Fieldset */
        $fieldset  = $element->getForm()->getElement($this->getFieldsetId());
        $chooserId = $this->getUniqId();
        $config    = $this->getConfig();

        // add chooser element to fieldset
        $chooser = $fieldset->addField('chooser' . $element->getId(), 'note', array(
            'label'       => $config->getLabel() ? $config->getLabel() : '',
            'value_class' => 'value2',
        ));
        $hiddenHtml = '';
        if ($this->getHiddenEnabled()) {
            $hidden = new Varien_Data_Form_Element_Hidden($element->getData());
            $hidden->setId("{$chooserId}value")->setForm($element->getForm());
            if ($element->getRequired()) {
                $hidden->addClass('required-entry');
            }
            $hiddenHtml = $hidden->getElementHtml();
            $element->setValue('');
        }

        $buttons = $config->getButtons();
        $chooseButton = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setId($chooserId . 'control')
            ->setClass('btn-chooser')
            ->setLabel($buttons['open'])
            ->setOnclick($chooserId.'.choose()')
            ->setDisabled($element->getReadonly());

        $defaultCheckbox =' <script type="text/javascript">'.
                        'Event.observe(window, "load", function () {'.
                            'if ($("'.$element->getHtmlId().'_default")) {'.
                                '$("chooser_'.$element->getHtmlId().'control").disable();'.
                            '} else {'.
                                '$("chooser_'.$element->getHtmlId().'control").enable();'.
                            '}'.
                            'Event.observe($("'.$element->getHtmlId().'_default"), "change", function () {'.
                                'if (this.checked) {'.
                                    '$("chooser_'.$element->getHtmlId().'control").disable();'.
                                '} else {'.
                                    '$("chooser_'.$element->getHtmlId().'control").enable();'.
                                '}'.
                            '});'.
                        '});'.
                    '</script>';

        $chooser->setData('after_element_html', $hiddenHtml . $chooseButton->toHtml().$defaultCheckbox);

        // render label and chooser scripts
        $configJson = Mage::helper('core')->jsonEncode($config->getData());
        return '
            <label class="widget-option-label" id="' . $chooserId . 'label">'
            . $this->quoteEscape($this->getLabel() ? $this->getLabel() : Mage::helper('widget')->__('Not Selected'))
            . '</label>
            <div id="' . $chooserId . 'advice-container" class="hidden"></div>
            <script type="text/javascript">//<![CDATA[
                (function() {
                    var instantiateChooser = function() {
                        window.' . $chooserId . ' = new WysiwygWidget.chooser(
                            "' . $chooserId . '",
                            "' . $this->getSourceUrl() . '",
                            ' . $configJson . '
                        );
                        if ($("' . $chooserId . 'value")) {
                            $("' . $chooserId . 'value").advaiceContainer = "' . $chooserId . 'advice-container";
                        }
                    }

                    if (document.loaded) { //allow load over ajax
                        instantiateChooser();
                    } else {
                        Event.observe(window, "load", instantiateChooser);
                    }
                })();
            //]]></script>
        ';
    }
}
