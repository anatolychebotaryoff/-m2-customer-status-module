<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */
class MageWorx_Seosuite_Block_Adminhtml_Template_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Prepare form for render
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $form     = new Varien_Data_Form();
        $template = Mage::registry('seosuite_template_edit');

        $fieldset = $form->addFieldset('base_fieldset',
                array('legend' => Mage::helper('customer')->__('Template Information')));

        $tCode = $fieldset->addField('template_code', 'hidden',
                array(
            'name'     => 'template_code',
            'label'    => Mage::helper('seosuite')->__('Template Code'),
            'title'    => Mage::helper('seosuite')->__('Template Code'),
            'required' => true,
                )
        );

        if (!$template->getTemplateKey()) {
            $tCode->setAfterElementHtml('<div style="font-size: 15px;margin-top:5px;color:red;"><u><b>You need to specify the template value for all store views</b></u></div>');
        }

        $templateKey = $fieldset->addField('template_key', 'text',
                array(
            'name'     => 'store_template[template_key]',
            'label'    => Mage::helper('seosuite')->__('Template Rule'),
            'title'    => Mage::helper('seosuite')->__('Template Rule'),
            //'note'  => $this->__('Use default Value'),
            'required' => true,
                )
        );
        $fieldset->addField('status', 'select',
                array(
            'name'     => 'status',
            'label'    => Mage::helper('seosuite')->__('Template Status'),
            'title'    => Mage::helper('seosuite')->__('Template Status'),
            'values'   => array(0 => Mage::helper('seosuite')->__('Disabled'),
                1 => Mage::helper('seosuite')->__('Enabled'),
            ),
            'required' => true,
                )
        );
        ($template->getIsDefaultValue()) ? $checked     = 'checked=1' : $checked     = '';

        if ($template->getStoreId()) {
            $storeId = $template->getStoreId();
        }
        else {
            $storeId = Mage::app()->getRequest()->getParam('store', 0);
        }

        if ($storeId) {
            $templateKey->setAfterElementHtml("<input type=checkbox " . $checked . " id='useDefault_template_key'>Use default
                <script type='text/javascript'>
                    Event.observe('useDefault_template_key','change',function(){
                        getDefault();
                    });
                    getDefault();
                    function getDefault()
                    {
                        if($('useDefault_template_key').checked) {
                            $('template_key').disabled = true;
                        } else {
                            $('template_key').disabled = false;
                        }
                    }
                </script>
            ");
        }

        $templateKey->setAfterElementHtml("<div style='width:1000px'>" . $template->getComment() . "</div>");
        // If edit add id
        $form->addField('template_store_id', 'hidden',
                array(
            'name'  => 'store_template[store_id]',
            'value' => $storeId,
                )
        );

        $form->addField('entity_id', 'hidden',
                array(
            'name' => 'store_template[entity_id]',
                )
        );

        if (!is_null($template->getTemplateId())) {
            // If edit add id
            $form->addField('id', 'hidden',
                    array(
                'name'  => 'template_id',
                'value' => $template->getId(),
                    )
            );
        }

        if (Mage::getSingleton('adminhtml/session')->getCustomerGroupData()) {
            $form->addValues(Mage::getSingleton('adminhtml/session')->getCustomerGroupData());
            Mage::getSingleton('adminhtml/session')->setCustomerGroupData(null);
        }
        else {
            $form->addValues($template->getData());
        }

        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $this->setForm($form);
    }

}
