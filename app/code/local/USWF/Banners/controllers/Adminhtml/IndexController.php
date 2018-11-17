<?php
/**
 * IndexController.php
 *
 * @category    USWF
 * @package     USWF_Banners
 * @copyright
 * @author
 */

class USWF_Banners_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action {

    public function deleteAction() {
        $params = $this->getRequest()->getParams();
        if (isset($params['banner_hash'])) {
            $node = $params['banner_hash'];
            $banners = Mage::getConfig()->getNode(USWF_Banners_Model_Observer::USWF_BANNERS_CONFIG_PATH, 'default');
            $banners = $banners ? $banners->asArray() : array();
            if (isset($banners[$node]) && $node != 'default') {
                foreach ($banners[$node] as $field => $dummy) {
                    Mage::getConfig()->deleteConfig(
                        USWF_Banners_Model_Observer::USWF_BANNERS_CONFIG_PATH . '/' . $node . '/' . $field
                    );
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Banner has been deleted successfully'));
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Banner can\'t be deleted'));
        }
        $this->_redirect('adminhtml/system_config/edit', array('section' => 'uswf_banners'));
    }
}

?>
