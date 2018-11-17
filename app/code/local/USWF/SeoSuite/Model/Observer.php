<?php

class USWF_SeoSuite_Model_Observer
{

    public function addJsToAttribute(Varien_Event_Observer $observer)
    {
        /* @var $form Varien_Data_Form */
        $form      = $observer->getEvent()->getForm();
        $eventElem = $form->getElement('category_canonical_url');
        if ($eventElem) {
            $htmlIdPrefix = $form->getHtmlIdPrefix();
            $html      = "<div style='padding-top:5px;'>
                        <input type='text' value='' style='display:none; width:275px' name='canonical_url_custom' id='canonical_url_custom'>
                    </div>\n
                <script type='text/javascript'>
                function listenCU() {
                    if($('{$htmlIdPrefix}category_canonical_url').value=='custom') {
                        $('canonical_url_custom').show();
                    }
                    else {
                        $('canonical_url_custom').hide();
                    }
               }
               $('{$htmlIdPrefix}category_canonical_url').observe('change',listenCU);
                    </script>";
            $eventElem->setAfterElementHtml($html);
        }
    }

    /**
     * Add "custom canonical url"
     *
     * @param Varien_Event_Observer $observer
     * @return this
     */
    public function addFormFieldsForCmsPage($observer)
    {
        $form      = $observer->getForm();
        $fieldset  = $form->getElements()->searchById('meta_fieldset');

        if(!$fieldset){
            return $this;
        }

        $fieldset->addField('cms_canonical_url', 'text',
            array(
                'name'   => 'cms_canonical_url',
                'label'  => Mage::helper('seosuite')->__('Custom Canonical URL'),
                'title'  => Mage::helper('seosuite')->__('Custom Canonical URL'),
            )
        );

        $model = Mage::registry('cms_page');
        $form->setValues($model->getData());

        return $this;
    }

}
