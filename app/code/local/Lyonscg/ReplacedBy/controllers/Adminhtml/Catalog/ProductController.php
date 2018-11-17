<?php
/**
 * Enter description here ...
 *
 * @category   Lyons
 * @package    Lyonscg_ReplacedBy
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
require_once 'Mage/Adminhtml/controllers/Catalog/ProductController.php';

class Lyonscg_ReplacedBy_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{

    public function preDispatch()
    {
        parent::preDispatch();
        /*$this->getRequest()->setRouteName('admin');*/
    }

    /**
     * Get specified tab grid
     */
    public function gridOnlyAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $module = $this->getRequest()->getParam('gridOnlyModule'); // this is a little tweak i find out
        $module = $module ? $module : 'adminhtml'; //this is passed in an ajax request (see related2Action in line 36)
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock($module . '/adminhtml_catalog_product_edit_tab_' . $this->getRequest()->getParam('gridOnlyBlock'))
                ->toHtml()
        );
    }

    public function replacedAction()
    {
        $this->_initProduct();

        $gridBlock = $this->getLayout()->createBlock('lyonscg_replacedby/adminhtml_catalog_product_edit_tab_replaced')
            ->setGridUrl($this->getUrl('*/*/gridOnly', array('_current' => false, 'gridOnlyBlock' => 'replaced', 'gridOnlyModule' => 'lyonscg_replacedby')));
        $serializerBlock = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer');
        $serializerBlock
            ->initSerializerBlock(
                $gridBlock, 'getSelectedReplaced', 'links[replaced]', 'products_replaced'
            );
        $serializerBlock->setInputElementName('links[replaced]');
        $serializerBlock->addColumnInputName('position');
        $serializerBlock->setProductsReplaced(
            Mage::registry('product')->getReplacedProducts()
        );
        $this->_outputBlocks($gridBlock, $serializerBlock);
    }

    protected function _initProduct($block=null)
    {
        static $product = null;
        if ($block === false) {
            $product = null;
            return;
        }
        if (!$product) {
            $r = parent::_initProduct();
            $product = $r;
            return($r);
        } else {
            return($product);
        }
    }

}
