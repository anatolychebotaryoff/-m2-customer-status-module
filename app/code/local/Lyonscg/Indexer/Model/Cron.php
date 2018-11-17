<?php
/**
 * Lyonscg Indexer
 *
 * @category    Lyonscg
 * @package     Lyonscg_Indexer
 * @copyright   Copyright (c) 2015 Lyons Consulting Group (www.lyonscg.com)
 * @author      Eugene Nazarov (enazarov@lyonscg.com) 
 */
class Lyonscg_Indexer_Model_Cron
{
    public function reindexAll()
    {
        if(!Mage::getStoreConfig('lyonscg_indexer/reindex_all/enabled')) return;
        
        Mage::log('Lyonscg Indexer: Reindex All Start');
        $processes = Mage::getSingleton('index/indexer')->getProcessesCollection();
        foreach ($processes as $process) {
            /* @var $process Mage_Index_Model_Process */
            try {
                $process->reindexEverything();
                Mage::log('Lyonscg Indexer: ' . $process->getIndexer()->getName() . ' index was rebuilt successfully');
            } catch (Exception $e) {
                Mage::log('Lyonscg Indexer: Error: ' . $e->getMessage());
                Mage::logException($e);
            }
        }
        Mage::log('Lyonscg Indexer: Reindex All End');
    }
}