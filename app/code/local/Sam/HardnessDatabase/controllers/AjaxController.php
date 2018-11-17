<?php

class Sam_HardnessDatabase_AjaxController
    extends Mage_Core_Controller_Front_Action
{
    
    public function checkzipAction()
    {
        if(!$this->getRequest()->isAjax()) {
            $this->_redirect('');
        }
    
        $zip_code = $this->getRequest()->getParam('zip_code');
    
        /**
         * @var $model Sam_HardnessDatabase_Model_Hardness
         */
        $model = Mage::getModel('hardness/hardness');
        $result = $model->load($zip_code, 'zip_code');
        
        if($result->getId()) {
            Mage::register('hardness_data', $result->getData());
    
            $data['result'] = true;
            $data['html'] = $this->getLayout()->createBlock('hardness/zipresult')->toHtml();
        } else {
            $data['result'] = false;
        }
        
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($data));
    }
    
}