<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Adminhtml_BrandCategoryController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return USWF_BrandCategory_Adminhtml_BrandCategoryController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('system/')
            ->_addBreadcrumb(Mage::helper('uswf_brandcategory')->__('Brand Category Records'),
                             Mage::helper('uswf_brandcategory')->__('Manage Records'));
        return $this;
    }

    /**
     * Return some checking result
     *
     * @return void
     */
     public function checkAction()
     {
         $result = 1;
         Mage::app()->getResponse()->setBody( $result );
     }

    /**
     * index action
     */
    public function indexAction()
    {
       
	$this->_title($this->__('Brand Category'))->_title($this->__('Records'));
        $this->loadLayout();
	$this->_addContent($this->getLayout()->createBlock('uswf_brandcategory/adminhtml_brandcategory'));
        $this->renderLayout();
	/*
        $this->_initAction();
        $this->renderLayout();
	*/
       
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

        /** @var $model USWF_BrandCategory_Model_Filter */
        $model = Mage::getModel('uswf_brandcategory/record');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('uswf_brandcategory')->__('The specified filter does not exist.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('uswf_brandcategory_record', $model);

        $breadcrumbText = ($id ? Mage::helper('uswf_brandcategory')->__('Edit Filter') :
                                 Mage::helper('uswf_brandcategory')->__('New Filter'));
        $this->_initAction()->_addBreadcrumb($breadcrumbText, $breadcrumbText);

        $this->_addContent($this->getLayout()->createBlock('uswf_brandcategory/adminhtml_brandcategory_edit')); 

        $this->renderLayout();
    }

    /**
     * save action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('uswf_brandcategory/record');
            if (isset($data['id'])) {
                $model->load($data['id']);
            }

            try {
                if(isset($data['stores'])) {
                    if(in_array('0',$data['stores'])){
                        $data['store_id'] = '0';
                    }
                    else{
                        $data['store_id'] = implode(",", $data['stores']);
                    }
                    unset($data['stores']);
                }
                $model->setData($data);
                $model->save();


                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('uswf_brandcategory')->__('Filter was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                Mage::app()->getCache()->remove('brand-category-records');

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
                $model = Mage::getModel('uswf_brandcategory/record');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('uswf_brandcategory')->__('Filter was successfully deleted'));

                Mage::app()->getCache()->remove('brand-category-records');

                $this->_redirect('*/*/');

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));

                return;
            }
        }

        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('uswf_brandcategory')->__('Filter cannot be deleted: Filter not found!'));
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
                Mage::helper('uswf_brandcategory')->__('Please select filter(s)')
            );
        } else {
            try {
                foreach ($filterIds as $filterId) {
                    Mage::getSingleton('uswf_brandcategory/record')
                        ->load($filterId)
                        ->setEnabled($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }


                $this->_getSession()->addSuccess(
                    Mage::helper('uswf_brandcategory')->__('%d filter(s) successfully updated', count($filterIds))
                );

                Mage::app()->getCache()->remove('brand-category-records');

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
                ->addError(Mage::helper('uswf_brandcategory')->__('Please select filter(s)'));
        } else {
            try {
                foreach ($filterIds as $filterId) {
                    $mass = Mage::getModel('uswf_brandcategory/record')->load($filterId);
                    $mass->delete();
                }


                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('uswf_brandcategory')->__('%d filter(s) successfully deleted', count($filterIds))
                );

                Mage::app()->getCache()->remove('brand-category-records');

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
