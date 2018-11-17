<?php
require_once Mage::getModuleDir('controllers', 'SFC_CyberSource') . DS . 'Adminhtml/PaymentprofileController.php';
class USWF_CyberSource_Adminhtml_PaymentprofileController extends SFC_CyberSource_Adminhtml_PaymentprofileController
{
    /**
     * Save data to existing payment profile
     */
    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();

        if ($profileId = $this->getRequest()->getParam('id')) {
            $model = Mage::getModel('sfc_cybersource/payment_profile')->load($profileId);
        }
        else {
            $model = Mage::getModel('sfc_cybersource/payment_profile');
        }

        if ($postData) {

            try {
                try {
                    // Save post data to model
                    $model->addData($postData);
                    // Now try to save payment profile to gateway
                    $model->saveProfileData();
                }
                catch (SFC_CyberSource_Helper_Gateway_Exception $eCyberSource) {
                    Mage::getSingleton('adminhtml/session')->addError('Failed to save credit card to CyberSource!');
                    if ($eCyberSource->getMessage()) {
                        Mage::getSingleton('adminhtml/session')->addError($eCyberSource->getCode(). ' : ' .
                            $eCyberSource->getMessage());
                    }
                    // Send customer back to saved credit cards grid
                    $this->_redirect('adminhtml/customer/edit/tab/customer_info_tabs_paymentprofile',
                        array('id' => $postData['customer_id']));

                    return;
                }

                // Now save model
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Saved credit card ' . $model->getCustomerCardnumber() . '.'));
                Mage::getSingleton('adminhtml/session')->setCustomerData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));

                    return;
                }
                $this->_redirect('adminhtml/customer/edit/tab/customer_info_tabs_paymentprofile',
                    array('id' => $model->getCustomerId()));

                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError('Failed to save credit card!');
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // Send customer back to saved credit cards grid
                $this->_redirect('adminhtml/customer/edit/tab/customer_info_tabs_paymentprofile',
                    array('id' => $postData['customer_id']));
            }
        }

        // Send customer back to saved credit cards grid
        $this->_redirect('adminhtml/customer/edit/tab/customer_info_tabs_paymentprofile', array('id' => $postData['customer_id']));
    }
}