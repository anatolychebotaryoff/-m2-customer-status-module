<?php

require_once Mage::getModuleDir('controllers', 'Zeon_Jobs') . DS . 'ApplicationController.php';
class USWF_Jobs_ApplicationController extends Zeon_Jobs_ApplicationController {

    /**
     * action after form submition
     */
    public function applyPostAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $session = $this->_getSession();
            $model = Mage::getModel('zeon_jobs/application');
            try {
                if (!empty($data)) {
                    $model->addData($data);
                    $session->setFormData($data);
                }
                if (isset($_FILES['upload_resume']['name']) && $_FILES['upload_resume']['name'] != '') {
                    $file = $_FILES['upload_resume'];
                    $fileCount = count($file["name"]);
                    $filesPath = array();
                    for ($i = 0; $i < $fileCount; $i++) {
                        $uploader = new Varien_File_Uploader(
                            array(
                                'name' => $_FILES['upload_resume']['name'][$i],
                                'type' => $_FILES['upload_resume']['type'][$i],
                                'tmp_name' => $_FILES['upload_resume']['tmp_name'][$i],
                                'error' => $_FILES['upload_resume']['error'][$i],
                                'size' => $_FILES['upload_resume']['size'][$i]
                            )
                        );
                        $uploader->setAllowedExtensions(
                            explode(',', Mage::helper('zeon_jobs')->getAllowedFileExtensions())
                        );
                        $uploader->setAllowRenameFiles(true);
                        $uploader->setFilesDispersion(false);
                        $path = Mage::getBaseDir('media') . DS . 'resumes' . DS;
                        $_FILES['upload_resume']['name'][$i] = str_replace(' ', '-', $_FILES['upload_resume']['name'][$i]);
                        $uploader->save($path, $_FILES['upload_resume']['name'][$i]);
                        $filesPath[] = $uploader->getUploadedFileName();
                    }
                    $model->setUploadResume(implode('|,|', $filesPath));
                }

                $model->save();
                $session->addSuccess(
                    Mage::helper('zeon_jobs')->__('Your application has been submitted. Thank you for contacting us.')
                );

                $translate = Mage::getSingleton('core/translate');
                $translate->setTranslateInline(false);
                /*To send email*/
                $dataObject = new Varien_Object();
                $dataObject->setData($data);
                //Send Email Notification to Admin & User
                if (!$model->sendNotificationEmail($dataObject)) {
                    throw new Exception('Email notification has not been sent.');
                }

                $translate->setTranslateInline(true);

                // Redirect to a success page, at the moment it goes back to the job list.
                $this->_redirect('careers');
                return;

            } catch (Exception $e) {
                $session->addError($e->getMessage());
                $session->getFormData($data);
                $this->_redirect('careers');
                return;
            }
        }
    }
}