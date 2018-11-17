<?php
/**
 * Block for rendering ComparePage forms
 *
 */
class USWF_ComparePage_Block_Adminhtml_Catalog_Product_Edit_Tab_Compare extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Prepare form
     *
     * @return null
     */
    protected function _prepareForm()
    {
        $_product = Mage::registry('current_product');
        $storeId = (int)Mage::app()->getRequest()->getParam('store');
        /** @var USWF_ComparePage_Model_Compare_Widget $comparePage */
        $comparePage = Mage::getModel('uswf_comparepage/compare_widget')->loadByProductId($_product->getId(), $storeId);

        $form = new Varien_Data_Form();
        $form->setDataObject($comparePage);

        $fieldset = $form->addFieldset('group_fields_' . 'comparepage', array(
            'legend' => Mage::helper('uswf_comparepage')->__('Compare Page'),
            'class' => 'fieldset-wide'
        ));
        $renderer = $this->getLayout()->createBlock('uswf_comparepage/adminhtml_catalog_form_renderer_fieldset_compare_element');

        /////****************************Main Field
        $this->addFieldToFieldsetMain($fieldset, $renderer, $_product, $storeId);
        /////****************************Product options
        $this->addFieldToFieldset($fieldset, $renderer, $_product, $storeId, 1);
        $this->addFieldToFieldset($fieldset, $renderer, $_product, $storeId, 2);
        $this->addFieldToFieldset($fieldset, $renderer, $_product, $storeId, 3);
        $this->addFieldToFieldset($fieldset, $renderer, $_product, $storeId, 4);
        /////***********************Product options

        $values = $comparePage->getData();
        $form->addValues($values);
        $form->setFieldNameSuffix('comparepage');

        Mage::dispatchEvent('adminhtml_catalog_product_edit_prepare_form', array('form' => $form));

        $this->setForm($form);
    }

    protected function addFieldToFieldsetMain($fieldset, $renderer, $_product, $storeId) {
        $isCreateComparePageType = $storeId ? 'hidden' : 'select';
        $yesnoSource = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();
        $element = $fieldset->addField('is_create_compare_page', $isCreateComparePageType,
            array(
                'name'      => 'is_create_compare_page',
                'label'     => Mage::helper('uswf_comparepage')->__('Create Compare Page?'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'values'    => $yesnoSource,
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));

        $element = $fieldset->addField('page_is_active', 'select',
            array(
                'name'      => 'page_is_active',
                'label'     => Mage::helper('uswf_comparepage')->__('Status'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'values'    => array(
                    '0' => Mage::helper('uswf_comparepage')->__('Disabled'),
                    '1' => Mage::helper('uswf_comparepage')->__('Published')),
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $element = $fieldset->addField('compared_product_position', 'hidden',
            array(
                'name'      => 'compared_product_position',
                'label'     => Mage::helper('uswf_comparepage')->__('Product Position'),
                'class'     => 'test',
                'required'  => '0',
                'class_group'=> 'compare-product-main-group',
                'value'     => '1,2,3,4'
            )
        );

        $fieldset->addType('compared_products', Mage::getConfig()->getBlockClassName('uswf_comparepage/adminhtml_catalog_product_helper_form_compare_products'));
        $compareProducts = $fieldset->addField(USWF_ComparePage_Block_Adminhtml_Catalog_Product_Edit_Tab_Compare_Products::NAME_ID_COMPARED_PRODUCT_GRID,
            'compared_products',
            array(
                'name'      => USWF_ComparePage_Block_Adminhtml_Catalog_Product_Edit_Tab_Compare_Products::NAME_ID_COMPARED_PRODUCT_GRID,
                'label'     => Mage::helper('uswf_comparepage')->__('Compared Products'),
                'class'     => 'compare-products',
                'required'  => '0',
                'class_group'=> 'compare-main-group',
            )
        );
        $compareProducts->setRenderer($this->getLayout()->createBlock('uswf_comparepage/adminhtml_catalog_form_renderer_fieldset_compare_products_element'));

        $element = $fieldset->addField('page_title', 'text',
            array(
                'name'      => 'page_title',
                'label'     => Mage::helper('uswf_comparepage')->__('Page Title'),
                'class'     => 'test',
                'required'  => '1',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'value'     => 'and Tier1 Product Comparison',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $element = $fieldset->addField('page_identifier', 'text',
            array(
                'name'      => 'page_identifier',
                'label'     => Mage::helper('uswf_comparepage')->__('URL Key'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'after_element_html' => '<p class="nm"><small>Leave blank to use compare/[OEMsku]-tier1.html</small></p>',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $metaRobots = Mage::getModel('uswf_comparepage/adminhtml_catalog_form_source_options_robots');
        $element = $fieldset->addField('page_meta_robots', 'select',
            array(
                'name'      => 'page_meta_robots',
                'label'     => Mage::helper('uswf_comparepage')->__('Meta Robots'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'values'    => $metaRobots->toOptionArray(),
                'value' => $metaRobots->toOptionDefault(),
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $element = $fieldset->addField('page_exclude_from_sitemap', 'select',
            array(
                'name'      => 'page_exclude_from_sitemap',
                'label'     => Mage::helper('uswf_comparepage')->__('Exclude from XML Sitemap'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'values'    => $yesnoSource,
                'value' => '1',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $element = $fieldset->addField('options_tier_price_output', 'select',
            array(
                'name'      => 'options_tier_price_output',
                'label'     => Mage::helper('uswf_comparepage')->__('Output Tier Prices'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'values'    => $yesnoSource,
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $optionsTabs = Mage::getModel('uswf_comparepage/adminhtml_catalog_form_source_options_active_tabs');
        $element = $fieldset->addField('options_active_tabs', 'multiselect',
            array(
                'name'      => 'options_active_tabs',
                'label'     => Mage::helper('uswf_comparepage')->__('Enabled Tabs'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'values'       => $optionsTabs->toOptionArray(),
                'value'       => $optionsTabs->getDefaultInForms(),
                'select_all'    => 'true',
                'can_be_empty' => true,
                'class_group'=> 'compare-main-group',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $element = $fieldset->addField('options_display_sku', 'select',
            array(
                'name'      => 'options_display_sku',
                'label'     => Mage::helper('uswf_comparepage')->__('Display SKU'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'values'    => $yesnoSource,
                'value' => '1',
                'class_group'=> 'compare-main-group',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $optionsAttributes = Mage::getModel('uswf_comparepage/adminhtml_catalog_form_source_options_attributes');
        $optionsAttributes->setProduct($_product);
        $element = $fieldset->addField('options_attributes', 'multiselect',
            array(
                'name'      => 'options_attributes',
                'label'     => Mage::helper('uswf_comparepage')->__('Attributes to Include'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'values'       => $optionsAttributes->toOptionArray(),
                'value'        => $optionsAttributes->getDefaultInForms(),
                'can_be_empty' => true,
                'class_group'=> 'compare-main-group',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);
    }
    protected function addFieldToFieldset($fieldset, $renderer, $_product, $storeId, $position)
    {
        $fieldset1 = $fieldset->addFieldset('group_fields_' . 'comparepage_product_'.$position, array(
            'legend' => Mage::helper('uswf_comparepage')->__('Compare Product '.$position),
            'class' => 'fieldset-wide'
        ));

        $element = $fieldset1->addField('product_custom_name' . '_option_' . $position, 'text',
            array(
                'name'      => 'product_custom_name' . '_option_' . $position,
                'label'     => Mage::helper('uswf_comparepage')->__('Product Name'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => 'left empty for autofill',
                'class_group'=> 'compare-main-group',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        //pos for the parent product
        if ($position != 1) {
            $comparePage = $fieldset->getForm()->getDataObject();
            $comparedProduct = $comparePage->getComparedProductByPos($position);
            if (!is_null($comparedProduct)) {
                $_product = $comparedProduct;
            } else {
                $_product = null;
            }
        }
        $reviewId = Mage::getModel('uswf_comparepage/adminhtml_catalog_form_source_options_product_reviewid',
            array('store_id'=>$storeId,'product'=> $_product));
        $element = $fieldset1->addField('review_id' . '_option_' . $position, 'select',
            array(
                'name'      => 'review_id' . '_option_' . $position,
                'label'     => Mage::helper('uswf_comparepage')->__('Review Id'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'values'    => $reviewId->toOptionArrayId(),
                'not_scope_label'=> true,
                //'value' => $reviewId->toOptionDefault(),
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);
        
        $element = $fieldset1->addField('review_text' . '_option_'.$position, 'textarea',
            array(
                'name'      => 'review_text' . '_option_'.$position,
                'label'     => '',
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'not_scope_label'=> true,
                'field_disable' => true
            )
        );
        $review = Mage::helper('uswf_comparepage')->getYotpoReviewId($_product, $storeId);
        $jsonData = Mage::helper('core')->jsonEncode($review);
        $js = "<script>reviewTextJson[".$position."] = {$jsonData}; addOptionToReview(".$position.");</script>";
        $element->setAfterElementHtml($js);
        $element->setRenderer($renderer);

        $data = array(
            'name'=>'comparepage[static_block_id_quality_icons' . '_option_'.$position.']',
            'label'=>'Static Block Id for Product(quality-icons)',
            'class'=>'widget-option',
            'class_group'=> 'compare-main-group',
        );
        $element = $fieldset1->addField('static_block_id_quality_icons' . '_option_'.$position, 'label',$data);
        $helperData = array(
            'button'=>array('open'=>'Select Block...'),
            'type'=>'uswf_comparepage/adminhtml_cms_block_widget_chooser',
        );
        $helperBlock = $this->getLayout()->createBlock('uswf_comparepage/adminhtml_cms_block_widget_chooser', '', $helperData);
        if ($helperBlock instanceof Varien_Object) {
            $helperBlock->setConfig($helperData)
                ->setFieldsetId($fieldset1->getId())
                ->prepareElementHtml($element);
        }
        $element->setRenderer($renderer);

        $element = $fieldset1->addField('title_bar_text' . '_option_'.$position, 'text',
            array(
                'name'      => 'title_bar_text' . '_option_'.$position,
                'label'     => Mage::helper('uswf_comparepage')->__('Title Bar Text'),
                'class'     => 'test',
                'required'  => '0',
                'value'      => 'Your Current Selection',
                'class_group'=> 'compare-main-group',
            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $element->setRenderer($renderer);

        $element = $fieldset1->addField('ribbon_pos'.'_option_'.$position, 'select',
            array(
                'name'      => 'ribbon_pos'.'_option_'.$position,
                'label'     => Mage::helper('uswf_comparepage')->__('Ribbon Position'),
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group',
                'values'    => array(
                    'right' => Mage::helper('uswf_comparepage')->__('Right'),
                    'left' => Mage::helper('uswf_comparepage')->__('Left')),

            )
        );
        $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
        $renderer = $this->getLayout()->createBlock('uswf_comparepage/adminhtml_catalog_form_renderer_fieldset_compare_element');
        $element->setRenderer($renderer);

        $element = $fieldset1->addField('details' . '_option_'.$position, 'textarea',
            array(
                'name'      => 'details' . '_option_'.$position,
                'label'     => 'Details Tab Text ',
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group'
            )
        );
        $element->setRows(5);
        $element->setRenderer($renderer);

        $element = $fieldset1->addField('compatibility' . '_option_'.$position, 'textarea',
            array(
                'name'      => 'compatibility' . '_option_'.$position,
                'label'     => 'Compatibility Tab Text',
                'class'     => 'test',
                'required'  => '0',
                'note'      => '',
                'class_group'=> 'compare-main-group'
            )
        );
        $element->setRows(5);
        $element->setRenderer($renderer);
    }


    public function canShowTab()
    {
        return true;
    }
    public function getTabLabel()
    {
        return $this->__('Compare');
    }
    public function getTabTitle()
    {
        return $this->__('Compare');
    }
    public function isHidden()
    {
        return false;
    }
//    public function getTabUrl()
//    {
//        return $this->getUrl('*/*/comparepage', array('_current' => true));
//    }
    public function getTabClass()
    {
        return '';//'ajax';
    }

    /**
     * Translate html content
     *
     * @param string $html
     * @return string
     */
    protected function _translateHtml($html)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        return $html;
    }
}
