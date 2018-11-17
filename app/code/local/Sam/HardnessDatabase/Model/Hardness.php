<?php

class Sam_HardnessDatabase_Model_Hardness extends Mage_Core_Model_Abstract
{
    
    protected function _construct()
    {
        $this->_init('hardness/hardness');
    }
    
    public function import()
    {
        $file = new Varien_Io_File();
        
        $filePath = Mage::getBaseDir('var') . DS . 'hardness_import' . DS . 'hardness_db.csv';
        
        if ($file->fileExists($filePath, true)) {
            try {
                $file->streamOpen($filePath, 'r');
            } catch (Exception $e) {
                return $e->getMessage();
            }
            while ($data = $file->streamReadCsv(";")) {
                if ((int)$data[0] > 0) {
                    try {
                        $record = null;
                        $record = $this->load($data[0], 'zip_code');
                        if (!$record->getId()) {
                            $record->setZipCode($data[0]);
                        }
                        $record->setHardnessRange($data[1]);
                        $record->setPrimaryCity($data[2]);
                        $record->setSecondaryCities($data[3]);
                        $record->setState($data[4]);
                        $record->setCounty($data[5]);
                        $record->setCountry($data[6]);
                        
                        $record->save();
                        
                        $this->unsetData();
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                }
            }
            return true;
        } else {
            return "No such file 'PROJECT_ROOT/var/hardness_import/hardness_db.csv'";
        }
    }
    
}