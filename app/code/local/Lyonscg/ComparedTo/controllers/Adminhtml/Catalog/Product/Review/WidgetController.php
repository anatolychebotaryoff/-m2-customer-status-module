<?php
/**
 * Add new controller for Review selector
 *
 * @category  Lyons
 * @package   Lyonscg_ComparedTo
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 */
class Lyonscg_ComparedTo_Adminhtml_Catalog_Product_Review_WidgetController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Chooser Source action
     */
    public function chooserAction()
    {
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $massAction = $this->getRequest()->getParam('use_massaction', false);
        $productTypeId = $this->getRequest()->getParam('product_type_id', null);
        $hiddenElements = $this->getRequest()->getParam('hidden_elements', null);

        $parameters = array();
        $hiddenElements = urldecode($hiddenElements);
        foreach (explode('&', $hiddenElements) as $element) {
            $param = explode('=', $element);
            if ($param) {
                $parameters[$param[0]] = $param[1];
            }
        }

        $productsGrid = $this->getLayout()->createBlock('lyonscg_comparedto/catalog_product_review_widget_chooser', '', array(
            'id'                =>  $uniqId,
            'use_massaction'    =>  $massAction,
            'product_type_id'   =>  $productTypeId,
            'category_id'       =>  $this->getRequest()->getParam('category_id'),
            'parameters'        =>  $parameters
        ));

        $html = $productsGrid->toHtml();

        $this->getResponse()->setBody($html);
    }
}
