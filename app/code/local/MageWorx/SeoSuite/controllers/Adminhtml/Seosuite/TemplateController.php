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
class MageWorx_Seosuite_Adminhtml_Seosuite_TemplateController extends Mage_Adminhtml_Controller_Action
{

    private $_currentModel;
    private $_currentModelCode;

    protected function _getTotalCount($entity = 'product')
    {
        $connection  = Mage::getSingleton('core/resource')->getConnection('core_write');
        $tablePrefix = (string) Mage::getConfig()->getTablePrefix();
        $select      = $connection->select()->from($tablePrefix . 'catalog_' . $entity . '_entity', 'COUNT(*)');
        $total       = $connection->fetchOne($select);
        return intval($total);
    }

    public function indexAction()
    {
        $this->_title($this->__('SEO Suite'))->_title($this->__('Manage SEO Templates'));
        $this->loadLayout()
                ->_setActiveMenu('catalog/seo_templates')
                ->_addBreadcrumb($this->__('SEO Suite'), $this->__('SEO Suite'))
                ->_addBreadcrumb($this->__('Templates'), $this->__('Templates'))
                ->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout(false);
        $this->renderLayout();
    }

    public function editAction()
    {
        $templateId = $this->getRequest()->getParam('template_id');
        if (!$templateId) {
            return $this->_forward('grid');
        }
        $template = Mage::getModel('seosuite/template')->load($templateId);
        Mage::register('seosuite_template_edit', $template, true);
        $this->loadLayout();
        $this->renderLayout();
    }

    public function changeStatusAction()
    {
        $params        = $this->getRequest()->getParams();
        $templateModel = Mage::getModel('seosuite/template')->load($params['template_id']);
        $status        = 1;
        $statusLabel   = Mage::helper('seosuite')->__('Enabled');
        if ($templateModel->getStatus()) {
            $status      = 0;
            $statusLabel = Mage::helper('seosuite')->__('Disabled');
        }
        try {
            $templateModel->setStatus($status)->save();
        }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('catalog')->__('%s', $e->getMessage()));
            $this->_redirect('*/*/');
            return;
        }
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__("Template '%s' %s",
                        $templateModel->getTemplateName(), $statusLabel));
        return $this->_redirect('*/*/index');
    }

    public function saveAction()
    {
        $params        = $this->getRequest()->getParams();

        //template id
        $templateModel = Mage::getModel('seosuite/template')->load($params['template_id']);

        if($templateModel->getStoreId() != $params['store_template']['store_id']){
            $params['change_store'] = 'yes';
        }

        if($templateModel->getEntityId() != $params['store_template']['entity_id']){
            $params['change_entity'] = 'yes';
            $params['entity_old'] = $templateModel->getEntityId();
            $params['entity_new'] = $params['store_template']['entity_id'];
        }

        try {
            $templateModel->setLastUpdate(time())->setStatus($params['status'])->setStoreData($params)->save();
        }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('catalog')->__('%s', $e->getMessage()));
            $this->_redirect('*/*/');
            return;
        }
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Template successfully saved'));
//        return $this->_redirect('*/*/edit',array('store'=>$params['store_template']['store_id'],'template_id'=>$params['template_id']));
        return $this->_redirect('*/*/index');
    }

    public function applyAction()
    {
        $this->loadLayout();
        $templateId = $this->getRequest()->getParam('template_id');
        $model      = Mage::getModel('seosuite/template')->load($templateId);
        if (!$model->isEnable()) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Template is disabled.'));
            return $this->_redirect('*/*/index');
        }
        $templateStoreCollection = Mage::getModel('seosuite/template_store')->getCollection()->filterTemplateId($templateId);
        if (!$templateStoreCollection->getSize()) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Template key is empty'));
            return $this->_redirect('*/*/index');
        }
        $canApply = false;

        foreach ($templateStoreCollection as $item) {
            if (Mage::app()->getStore($item->getStoreId())->isAdmin()) {
                $canApply = true;
                continue;
            }
//            if ($this->getRequest()->getParam('store') == $item->getStoreId()) {
//                $canApply = true;
//                continue;
//            }
        }

        if (!$canApply) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Default Template key is empty. You can\'t continue.'));
            return $this->_redirect('*/*/index');
        }

        Mage::register('seosuite_template_current_model_id', $model->getId(), true);
        Mage::register('seosuite_template_current_model_name', $model->getTemplateName(), true);

        $this->getLayout()->getBlock('convert_root_head')
                ->setTitle($this->__('SEO Suite'). ': ' . $this->__($model->getTemplateName()) . ' ' . $this->__('Generation') . '...');

        $this->renderLayout();
    }

    public function runApplyAction()
    {
        $model   = Mage::getModel('seosuite/template')->load($this->getRequest()->getParam('model_id'));
        Mage::register('seosuite_template_current_model', $model, true);
        $reindex = $this->getRequest()->getParam('reindex', '');
        if ($reindex) {
            $result = $this->_reindex($reindex, $model);
        }
        else {
            $result = $this->_apply($model);
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    protected function _reindex($reindex, $model)
    {
        $result = array();
        if ($reindex == 'start') {
            $result['url']  = $this->getUrl('*/*/runApply/', array('reindex' => 'run'));
            $result['text'] = $this->__('Starting reindex product data...');
        }
        elseif ($reindex == 'run') {
            //see index_process table
            $aIndexProcessId       = array(1, 3, 4, 5, 6, 7, 10);
            //$aIndex = array(1,2,3,4,5,6,7,8,9,10); # full list of index
            $currentIndexProcessId = intval($this->getRequest()->getParam('current', array_shift($aIndexProcessId)));
            $index                 = Mage::getModel('index/process')->load($currentIndexProcessId);

            if (!$index->getId()) {
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Template was successfully applied.'));
                die($this->getUrl('*/*/index/', array('_secure' => true)));
            }
            else {
                try {
                    $index->reindexAll();
                    $result['text'] = $index->getIndexer()->getDescription() . $this->__('... 100%. Done.');
                }
                catch (Mage_Core_Exception $e) {
                    $result['text'] = $e->getMessage();
                }
                $nextIndexProcessId = $index->getId() + 1;
                while (!in_array($nextIndexProcessId, $aIndexProcessId) && $nextIndexProcessId < max($aIndexProcessId)) {
                    $nextIndexProcessId++;
                }
                $urlParams     = array('reindex'  => 'run', 'current'  => $nextIndexProcessId, 'model_id' => $model->getId());
                $result['url'] = $this->getUrl('*/*/runApply/', $urlParams);
            }
        }
        else {
            Mage::throwException($this->__('Url param \'reindex\' is wrong.'));
        }
        return $result;
    }

    protected function _getEntityNameByTemplateModel(MageWorx_SeoSuite_Model_Template $model)
    {
        $entityName = "product";
        if (strpos($model->getTemplateCode(), 'category_') !== false) {
            $entityName = 'category';
        }
        return $entityName;
    }

    protected function _apply($model)
    {
        $result     = array();
        $limit      = Mage::helper('seosuite/template')->getTemplateLimitForCurrentStore();
        $entityName = $this->_getEntityNameByTemplateModel($model);
        $current    = intval($this->getRequest()->getParam('current', 0));
        $total      = $this->_getTotalCount($entityName);

        if ($current < $total) {
            $this->_getTemplateAdapterByModel($model)->apply($current, $limit);
            $current += $limit;
            if ($current >= $total) {
                $current       = $total;
                $result['url'] = $this->getUrl('*/*/runApply/',
                        array('reindex'  => 'start', 'model_id' => $model->getId()));
            }
            else {
                $result['url'] = $this->getUrl('*/*/runApply/',
                        array('current'  => $current, 'model_id' => $model->getId()));
            }
            $result['text'] = $this->__('Total %1$s, processed %2$s records (%3$s%%)...', $total, $current,
                    round($current * 100 / $total, 2));
        }
        return $result;
    }

    protected function _getTemplateAdapterByModel(MageWorx_SeoSuite_Model_Template $model)
    {
        $templateCodeArray   = explode('_', $model->getTemplateCode());
        $currentTemplateCode = array_shift($templateCodeArray) . "_" . join('', $templateCodeArray);
        Mage::register('seosuite_template_current_model_code', $currentTemplateCode, true);
        return Mage::getSingleton('seosuite/template_adapter_' . $currentTemplateCode)->setModel($model);
    }
}