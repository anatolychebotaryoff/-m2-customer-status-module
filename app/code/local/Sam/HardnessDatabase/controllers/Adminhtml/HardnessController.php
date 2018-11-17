<?php

class Sam_HardnessDatabase_Adminhtml_HardnessController
    extends Mage_Adminhtml_Controller_Action
{
    
    public function indexAction()
    {
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->getResponse()->setBody($this->getLayout()->createBlock('hardness/adminhtml_zipcodes_grid')->toHtml());
            return $this;
        }
        
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('hardness/adminhtml_zipcodes')
        );
        $this->renderLayout();
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function editAction()
    {
        $id = $this->getRequest()->getParam('hardness_id');
        Mage::register('hardness_zip', Mage::getModel('hardness/hardness')->load($id));
        $hardnessObject = (array)Mage::getSingleton('adminhtml/session')->getHardnessObject(true);
        if (count($hardnessObject)) {
            Mage::registry('hardness_zip')->setData($hardnessObject);
        }
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('hardness/adminhtml_zipcodes_edit'));
        $this->renderLayout();
    }
    
    public function saveAction()
    {
        try {
            $id = $this->getRequest()->getParam('hardness_id');
            $hardness = Mage::getModel('hardness/hardness')->load($id);
            
            $hardness
                ->setData($this->getRequest()->getParams())
                ->save();
            
            if (!$hardness->getId()) {
                Mage::getSingleton('adminhtml/session')->addError('Cannot save data');
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setBlockObject($hardness->getData());
            return $this->_redirect('*/*/edit', array('hardness_id' => $this->getRequest()->getParam('hareness_id')));
        }
        
        Mage::getSingleton('adminhtml/session')->addSuccess('Data was saved successfully!');
        
        $this->_redirect('*/*/' . $this->getRequest()->getParam('back', 'index'), array('hardness_id' => $hardness->getId()));
    }
    
    public function deleteAction()
    {
        $hardness = Mage::getModel('hardness/hardness')
            ->setId($this->getRequest()->getParam('hardness_id'))
            ->delete();
        if ($hardness->getId()) {
            Mage::getSingleton('adminhtml/session')->addSuccess('Data was deleted successfully!');
        }
        $this->_redirect('*/*/');
        
    }
    
    public function massDeleteAction()
    {
        $hardness = $this->getRequest()->getParams();
        try {
            $hardness = Mage::getModel('hardness/hardness')
                ->getCollection()
                ->addFieldToFilter('hardness_id', array('in' => $hardness['massaction']));
            foreach ($hardness as $hard) {
                $hard->delete();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return $this->_redirect('*/*/');
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Data were deleted!');
        
        return $this->_redirect('*/*/');
        
    }
    
    public function importAction()
    {
        try {
            $model = Mage::getModel('hardness/hardness');
            if($result = $model->import()) {
                Mage::getSingleton('core/session')->addSuccess('Data successfuly imported from file.');
                return $this->_redirect('*/*/');
            } else {
                Mage::getSingleton('core/session')->addError($result);
                return $this->_redirect('*/*/*/');
            }
        }catch(Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            return $this->_redirect('*/*/*/');
        }
    }
    
}