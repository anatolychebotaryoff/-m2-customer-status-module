<?php

/**
 * Cache Model
* 
 * @category    Lyonscg
 * @package     Lyonscg_CacheWarmer
 * @copyright   Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author      Richard Loerzel (rloerzel@lyonscg.com) 
 */

class Lyonscg_CacheWarmer_Model_Cache extends Mage_Core_Model_Abstract
{
    public $batchSize = null;
    
    public $rootUrl = null;
    
    public $maxExecutionTime = null;
    
    public $memoryLimit = null;
    
    public $procNice = null;
    
    public $pos = null;
    
    public function _construct() 
    {
       
        $this->rootUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $this->maxExecutionTime = Mage::getStoreConfig('cachewarmer/setting/max_execution_time');
        $this->memoryLimit = Mage::getStoreConfig('cachewarmer/setting/memory_limit');
        $this->procNice = Mage::getStoreConfig('cachewarmer/setting/proc_nice');
        $this->batchSize = Mage::getStoreConfig('cachewarmer/setting/batch_size');
        $this->maxPos = Mage::getStoreConfig('cachewarmer/setting/max_pos');
        $this->pos = 1;
        
        if (!is_numeric($this->batchSize)) {
            $this->batchSize = 5;
        }
    }
    
    protected function _logServerLoad($message = null) 
    {
        /**
         * If option is enabled in module system config, log server load averages
         */
        if (Mage::getStoreConfig('cachewarmer/setting/log_load')) {
            try {
                $loadAvg = exec("uptime | awk -F'load average:' '{ print $2 }'");
                Mage::log("----- SERVER LOAD AVG ($message): $loadAvg",null,'cache_warmer.log');
            } catch (Exception $e) {
                Mage::log('----- ERROR logging server load average: ' . $e->getMessage(),null,'cache_warmer.log');
            }
           
        }
    }
    
    public function reheat($method = 'cron')
    {
        try {
            $startTime = time();
            Mage::log('',null,'cache_warmer.log');
            Mage::log('CACHE WARMING',null,'cache_warmer.log');
            Mage::log('----- START TIME = ' . date("H:i:s", $startTime) . ' UTC',null,'cache_warmer.log');
            Mage::log('----- BASEURL = ' . $this->rootUrl,null,'cache_warmer.log');
            Mage::log('----- METHOD = ' . $method,null,'cache_warmer.log');
            Mage::log('----- BATCH SIZE = ' . $this->batchSize,null,'cache_warmer.log');
            
            /**
             * Debug: limit number of urls
             */
            if (is_numeric($this->maxPos)) {
                Mage::log('----- DEBUG SETTING: max number of URLs = ' . $this->maxPos,null,'cache_warmer.log');
            }
            /**
             * Set PHP max_execution_time in seconds 
             * Excessively large numbers or 0 (infinite) will hurt server performance
             */
            
            if (is_numeric($this->maxExecutionTime)) {
                ini_set("max_execution_time", $this->maxExecutionTime);
                Mage::log('----- PHP SETTING: max_execution_time = ' . $this->maxExecutionTime,null,'cache_warmer.log');
            }
            
            /**
             * Set PHP memory_limit: Number + M (megabyte) or G (gigabyte)
             * Excessively large numbers will hurt server performance
             * Format: 1024M or 1G
             */
            if (strlen($this->memoryLimit) > 1) {
                ini_set("memory_limit", $this->memoryLimit);
                Mage::log('----- PHP SETTING: memory_limit = ' . $this->memoryLimit,null,'cache_warmer.log');
            }
            
            /**
             * Set PHP nice value. 
             * Lower numbers = lower priority
             */
            if (is_numeric($this->procNice)) {
                proc_nice($this->procNice);
                Mage::log('----- PHP SETTING: proc_nice = ' . $this->procNice,null,'cache_warmer.log');
            }
            
            /**
             * Get all available store_ids and create large union join 
             * with all products and a categories from each store
             */
            
            $this->_logServerLoad('START reheat()');
            
            $sql1 = ' SELECT `store_id` FROM `core_store` WHERE `store_id` > 0';
            
            $stores = Mage::getSingleton('core/resource')
                ->getConnection('core_read')
                ->fetchAll($sql1);
            
            $storeSql = array();
            
            foreach($stores as $store) {
                if (is_numeric($store['store_id'])) {
                    $storeSql[] = 'SELECT url_path FROM catalog_product_flat_' . $store['store_id'] . ' UNION ' .
                                  'SELECT url_path FROM catalog_category_flat_store_' . $store['store_id'];
                }
            }
            
            $sql2 = 'SELECT DISTINCT x.url_path FROM (' . implode(' UNION ', $storeSql) . ') as x';
            
            $data = Mage::getSingleton('core/resource')
                    ->getConnection('core_read')
                    ->fetchAll($sql2);
            
            $count = 1;
            $batch = array();
            $stop =false;
            /**
             * Create batches of URLs in arrays with $this->batchSize elements
             */
            foreach($data as $row) {
                
                if (is_numeric($this->maxPos) && $this->pos >= $this->maxPos) {
                    $stop = true;
                    break;
                } else if ($count > $this->batchSize) {
                    $this->_process($batch);
                    $batch = array();
                    $count = 1;
                }
                $batch[] = $this->rootUrl . $row['url_path'];
                $count++;
            }
            
            /**
             * Final batch may be less than $this->batchSize
             * Process separately
             */
            if (count($batch) > 0 && !$stop) {
                $this->_process($batch);
            }
            
            /**
             * Log the total execution time 
             */
            $endTime = time();
            $totalTime = $endTime - $startTime;
            
            Mage::log('----- END TIME = ' . date("H:i:s", $endTime) . ' UTC',null,'cache_warmer.log');
            Mage::log("----- TOTAL PROCESSING TIME = $totalTime seconds",null,'cache_warmer.log');
            
            /**
             * Change output if run as cron or manually run through admin
             */
            if ($method === 'manual') {
                return array('type' => 'success','content' => "Successfully warmed cached. Total processing time: $totalTime seconds.");
            } else {
                echo "SUCCESS: cache reheated.";
                return true;
            }
            
            /**
             * kill child process to "reset" niceness
             * @todo Reset proc_nice value
             * 
            
            if (is_numeric($this->procNice)) {     
                //proc_nice(0);
                //posix_kill( getmypid(), 28 );
            }
             */
            
            $this->_logServerLoad('END reheat()');
            
        } catch (Exception $e) {
            if ($method === 'manual') {
                return array('type' => 'error','content' => 'ERROR warming cache: ' . $e->getMessage());
            } else {
                echo 'ERROR: ' . $e->getMessage();
                return false;
            }
        }
    }
    
    
    protected function _process($urls)
    {
        /**
         * Initialize multithreaded cURL
         */
        $mh = curl_multi_init();
        $ch = array();
       
        
        /**
         * Set all cURL options including batch size.
         */
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_MAXREDIRS => $this->batchSize
        );
        
        /**
         * Add all urls from batch to multithread cURL handler
         */
        for ($i = 0; $i < $this->batchSize; $i++) {
            if (isset($urls[$i])) {
                $handle = curl_init();
                $options[CURLOPT_URL] = $urls[$i];
                curl_setopt_array($handle,$options);
                curl_multi_add_handle($mh, $handle);
                $ch[] = $handle;
            }
        }
        
        $handle = null;
        $active = null;
        
        /**
         * execute the handles
         */
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($mh) != -1) {
                do {
                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
        
        $this->_logServerLoad('execute the handles');
        
        /**
         * close the handles
         */
        foreach($ch as $handle) {
            $info = curl_getinfo($handle);
            curl_multi_remove_handle($mh, $handle);
            if ($info['url']) {
                Mage::log($this->pos . '. ' . preg_replace('/[\n\r]/','',$info['url']) . ' status_code: ' . $info['http_code'] . ' total_time:' . $info['total_time'],null,'cache_warmer.log');
                $this->pos++;
            }
         }
        
        curl_multi_close($mh);
        return true;
    }

}