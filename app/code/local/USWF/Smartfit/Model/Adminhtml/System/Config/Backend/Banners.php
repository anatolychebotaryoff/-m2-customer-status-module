<?php
/**
 * Banners.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Model_Adminhtml_System_Config_Backend_Banners 
    extends Mage_Adminhtml_Model_System_Config_Backend_Serialized_Array 
{
    protected function _beforeSave()
    {
        $origData = $this->getId() ? 
            Mage::getModel('adminhtml/system_config_backend_serialized_array')->load($this->getId())->getValue() :
            array();
        if (!empty($_FILES['banner_img']['name']) && is_array($_FILES['banner_img']['name'])) {
            $value = $this->getValue();
            $value = !empty($value) && is_array($value) ? $value : array();
            foreach ($_FILES['banner_img']['name'] as $hash => $image) {
                $uploader = new Varien_File_Uploader(array(
                    'name' => $image,
                    'type' => $_FILES['banner_img']['type'][$hash],
                    'tmp_name' => $_FILES['banner_img']['tmp_name'][$hash],
                    'error' => $_FILES['banner_img']['error'][$hash],
                    'size' => $_FILES['banner_img']['size'][$hash]
                ));
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setFilesDispersion(true);
                $result = $uploader->save(Mage::getBaseDir('media'));
                if (!empty($result['file'])) {
                    $value[$hash]['image'] = $result['file'];
                }
            }
            if (!empty($value)) {
                $this->setValue($value);
            }
        }
        $value = $this->getValue();
        if (!empty($value)) {
            foreach ($value as $hash => $data) {
                if (!isset($data['image']) && isset($origData[$hash]['image'])) {
                    $value[$hash]['image'] = $origData[$hash]['image'];
                }
            }
            $this->setValue($value);
        }
        return parent::_beforeSave();
    }
}