<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_Import
 * @copyright
 * @author
 */
class USWF_Import_Model_Observer
{

    /**
     * Reindex for Import
     *
     * @param $observer
     * @return $this
     */
    public function endProcessEventCatalogProductImportSave($observer)
    {
        $factory = Mage::getSingleton('core/factory');
        $indexer = $factory->getSingleton($factory->getIndexClassAlias());

        $processes = $indexer->getProcessesCollectionByCodes(array('tag_summary', 'catalog_product_flat'));
        foreach($processes as $process){
            $process->reindexEverything();
        }
        return $this;
    }
}
