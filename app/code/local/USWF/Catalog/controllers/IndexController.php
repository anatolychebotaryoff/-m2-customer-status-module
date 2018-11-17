<?php

class USWF_Catalog_IndexController extends Mage_Core_Controller_Front_Action
{
    protected $_stateBlockName  ;
    protected $_categoryBlockName  ;
    protected $_attributeFilterBlockName  ;
    protected $_priceFilterBlockName  ;
    protected $_decimalFilterBlockName ;

    protected function _initBlocks()
    {
        $this->_stateBlockName              = 'catalog/layer_state';
        $this->_categoryBlockName           = 'catalog/layer_filter_category';
        $this->_attributeFilterBlockName    = 'catalog/layer_filter_attribute';
        $this->_priceFilterBlockName        = 'catalog/layer_filter_price';
        $this->_decimalFilterBlockName      = 'catalog/layer_filter_decimal';
    }

    public function indexAction(){
        $data = $this->getRequest()->getParam('data', false);

        $filterBlocks = array();
        $attributeCollection = $this->getLayer()->getFilterableAttributes();
        foreach ($attributeCollection as $attribute){
            if ($attribute->getAttributeCode() == 'price') {
                $filterBlockName = $this->_priceFilterBlockName;
            } elseif ($attribute->getBackendType() == 'decimal') {
                $filterBlockName = $this->_decimalFilterBlockName;
            } else {
                $filterBlockName = $this->_attributeFilterBlockName;
            }
            $filterBlocks[$attribute->getAttributeCode().'_filter'] = $this->getLayout()->createBlock($filterBlockName)
                ->setLayer($this->getLayer())
                ->setAttributeModel($attribute)
                ->init();
        }

        $stateBlock = $this->getLayout()->createBlock($this->_stateBlockName)
            ->setLayer($this->getLayer());
        $filterBlocks['layer_state_filter'] = $stateBlock;

        $categoryBlock = $this->getLayout()->createBlock($this->_categoryBlockName)
            ->setLayer($this->getLayer())
            ->init();
        $filterBlocks['category_filter'] = $categoryBlock;

        $html = isset($data['filterS']) ? $filterBlocks[$data['filterS']]->toHtml() : "";
        $this->getResponse()->setBody($html);
    }

    /**
     * Get layer object
     *
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer()
    {
        return Mage::getSingleton('catalog/layer');
    }

    public function preDispatch()
    {
        parent::preDispatch();
        Mage::dispatchEvent('controller_action_predispatch_catalog',
            array('controller_action' => $this));

        // init category
        $data = $this->getRequest()->getParam('data', false);
        $categoryId = isset($data['category']) ? $data['category'] : null;
        if (!$categoryId) {
            return;
        }
        $category = Mage::getModel('catalog/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($categoryId);
        Mage::register('current_category', $category);

        $this->_initBlocks();

        return $this;
    }

    /**
     * Postdispatch: should set last visited url
     *
     * @return Mage_Core_Controller_Front_Action
     */
    public function postDispatch()
    {
        parent::postDispatch();
        if (!$this->getFlag('', self::FLAG_NO_START_SESSION )) {
            Mage::getSingleton('core/session')->setLastUrl(Mage::getUrl('*/*/*', array('_current'=>true)));
        }

        return $this;
    }
}