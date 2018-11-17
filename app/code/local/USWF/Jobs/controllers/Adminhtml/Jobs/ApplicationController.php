<?php


require_once Mage::getModuleDir('controllers', 'Zeon_Jobs') . DS . 'Adminhtml' . DS . 'Jobs' . DS . 'ApplicationController.php';
class USWF_Jobs_Adminhtml_Jobs_ApplicationController extends Zeon_Jobs_Adminhtml_Jobs_ApplicationController {

    /**
     * Download action
     *
     */
    public function downloadAction()
    {
        $model = Mage::getModel('zeon_jobs/application')
            ->setId($this->getRequest()->getParam('id'));
        /* @var $model Zeon_Jobs_Model_Application */

        $files = explode('|,|', $model->getFilename());
        if (count($files) == 1) {
            parent::downloadAction();
        }
        $sourceDir =  Mage::getBaseDir('media') . DS . 'resumes';
        $zipName = $sourceDir . DS . 'resumes_' . $model->getId() . '.zip';
        $zip = new ZipArchive();
        $res = $zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($files as $localName) {
            $file = $sourceDir  . DS .  $localName;
            $zip->addFile($file, $localName);
        }
        $zip->close();

        $this->_prepareDownloadResponse('resumes_' . $model->getId() . '.zip', file_get_contents($zipName), 'application/zip', filesize($zipName));
    }

}