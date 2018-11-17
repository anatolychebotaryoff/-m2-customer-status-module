<?php

class USWF_Jobs_Model_Observer {

    public function jobsApplyPost(Varien_Event_Observer $observer){
        $action = $observer->getControllerAction();
        $jobCode = $action->getRequest()->getParam('job_code', false);
        $jobId = Mage::getResourceModel('zeon_jobs/jobs')->checkJobCode($jobCode, Mage::app()->getStore()->getId());
        $job = Mage::getModel('zeon_jobs/jobs')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($jobId);
        $action->getRequest()
            ->setPost('job_title', $job->getTitle());
    }

}