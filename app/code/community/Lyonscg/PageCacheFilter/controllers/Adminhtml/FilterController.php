<?php
/**
 * LyonsCG Page Cache Filter
 *
 * @category    Lyonscg
 * @package     Lyonscg_PageCacheFilter
 * @author      Nicholas Hughart (nhughart@lyonscg.com)
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 */

class Lyonscg_PageCacheFilter_Adminhtml_FilterController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Lyonscg_PageCacheFilter_Adminhtml_FilterController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('system/')
            ->_addBreadcrumb(Mage::helper('lyonscg_pagecachefilter')->__('Full Page Cache Filter'),
                             Mage::helper('lyonscg_pagecachefilter')->__('Manage Filters'));
        return $this;
    }

    /**
     * index action
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * new action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * edit action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');

        /** @var $model Lyonscg_PageCacheFilter_Model_Filter */
        $model = Mage::getModel('lyonscg_pagecachefilter/filter');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('lyonscg_pagecachefilter')->__('The specified filter does not exist.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('lyonscg_pagecachefilter_filter', $model);

        $breadcrumbText = ($id ? Mage::helper('lyonscg_pagecachefilter')->__('Edit Filter') :
                                 Mage::helper('lyonscg_pagecachefilter')->__('New Filter'));
        $this->_initAction()->_addBreadcrumb($breadcrumbText, $breadcrumbText);

        $this->renderLayout();
    }

    /**
     * save action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('lyonscg_pagecachefilter/filter');
            if (isset($data['id'])) {
                $model->load($data['id']);
            }

            try {
                $model->setData($data);
                $model->save();

                Mage::helper('lyonscg_pagecachefilter')->refreshCachedFilters();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('lyonscg_pagecachefilter')->__('Filter was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

                return;
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     * delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('lyonscg_pagecachefilter/filter');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('lyonscg_pagecachefilter')->__('Filter was successfully deleted'));

                Mage::helper('lyonscg_pagecachefilter')->refreshCachedFilters();

                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));

                return;
            }
        }

        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('lyonscg_pagecachefilter')->__('Filter cannot be deleted: Filter not found!'));
        $this->_redirect('*/*/');
    }

    /**
     * massStatus action
     */
    public function massStatusAction()
    {
        $filterIds = $this->getRequest()->getParam('massaction');

        if (!is_array($filterIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('lyonscg_pagecachefilter')->__('Please select filter(s)')
            );
        } else {
            try {
                foreach ($filterIds as $filterId) {
                    Mage::getSingleton('lyonscg_pagecachefilter/filter')
                        ->load($filterId)
                        ->setEnabled($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }

                Mage::helper('lyonscg_pagecachefilter')->refreshCachedFilters();

                $this->_getSession()->addSuccess(
                    Mage::helper('lyonscg_pagecachefilter')->__('%d filter(s) successfully updated', count($filterIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * massDelete action
     */
    public function massDeleteAction()
    {
        $filterIds = $this->getRequest()->getParam('massaction');

        if (!is_array($filterIds)) {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('lyonscg_pagecachefilter')->__('Please select filter(s)'));
        } else {
            try {
                foreach ($filterIds as $filterId) {
                    $mass = Mage::getModel('lyonscg_pagecachefilter/filter')->load($filterId);
                    $mass->delete();
                }

                Mage::helper('lyonscg_pagecachefilter')->refreshCachedFilters();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('lyonscg_pagecachefilter')->__('%d filter(s) successfully deleted', count($filterIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
