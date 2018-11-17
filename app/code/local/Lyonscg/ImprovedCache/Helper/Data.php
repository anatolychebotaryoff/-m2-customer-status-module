<?php
/**
 * Improved Cache Clearing/Warming
 *
 * @category    Lyonscg
 * @package     Lyonscg_ImprovedCache
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (http://www.lyonscg.com)
 * @author      Nick Hughart (nhughart@lyonscg.com)
 */

require_once BP . "/lib/PHPCrawl/libs/PHPCrawler.class.php";

class Lyonscg_ImprovedCache_Helper_Data extends Mage_Core_Helper_Abstract
{
    const PAGE_TYPE_CATEGORY = 0;
    const PAGE_TYPE_PRODUCT = 1;
    const PAGE_TYPE_CMS = 2;

    const LOG_FILE = 'improvedcache.log';

    /**
     * True if logging is enabled
     *
     * @var bool
     */
    private $_loggingEnabled = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_loggingEnabled = Mage::getStoreConfig('lyonscg_improvedcache/general/logging');
    }

    /**
     * Crawl starting from a specific page
     *
     * @param string $url
     * @throws Exception
     */
    public function crawlPage(Mage_Core_Model_Store $store, $path, $limit = 1, $followPatterns = null, $excludePatterns = null)
    {
        // Create crawler
        $crawler = Mage::getModel('lyonscg_improvedcache/warmer');

        $this->_configureCrawler($crawler, $store, $path);

        // Set the page limit to admin configurable value
        $crawler->setPageLimit($limit);

        if ($followPatterns) {
            foreach($followPatterns as $followPattern) {
                $followPattern = trim($followPattern);
                if (!empty($followPattern)) {
                    $crawler->addURLFollowRule("#$followPattern# i");
                }
            }
        }

        if ($excludePatterns) {
            foreach ($excludePatterns as $excludePattern) {
                $excludePattern = trim($excludePattern);
                if (!empty($excludePattern)) {
                    $crawler->addURLFollowRule("#$excludePattern# i");
                }
            }
        }

        $threads = Mage::getStoreConfig('lyonscg_improvedcache/warming/threads', $store->getId());

        $this->log('Crawling ' . $limit . ' pages on ' . $store->getFrontendName() . ' starting at '. $path . ' with ' . $threads . ' threads.');
        $this->_runCrawler($crawler, $threads);
    }

    /**
     * Start a crawl on the given store
     *
     * @param Mage_Core_Model_Store $store
     * @throws Exception
     * @throws Mage_Core_Exception
     */
    public function crawlStore(Mage_Core_Model_Store $store, $followPatterns = null, $excludePatterns = null)
    {
        $limit = Mage::getStoreConfig('lyonscg_improvedcache/warming/store_limit', $store->getId());

        $this->log('Crawling store ' . $store->getFrontendName());
        $this->crawlPage($store, '/', $limit, $followPatterns, $excludePatterns);
    }

    /**
     * Warm a single page
     *
     * @param string $url
     */
    public function warmPage(Mage_Core_Model_Store $store, $path)
    {
        $this->crawlPage($store, $path);
    }

    /**
     * Configure crawler
     *
     * @param Lyonscg_ImprovedCache_Model_Warmer $crawler
     * @param $url
     */
    protected function _configureCrawler(Lyonscg_ImprovedCache_Model_Warmer $crawler, Mage_Core_Model_Store $store, $path)
    {
        // URL to crawl
        $baseUrl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $crawler->setURL(rtrim($baseUrl, '/') . $path);

        // Only receive content of files with content-type "text/html"
        $crawler->addContentTypeReceiveRule("#text/html#");

        // Store and send cookie-data like a browser does
        $crawler->enableCookieHandling(false);

        // Request gzip encryption to speed up crawling
        $crawler->requestGzipContent(true);

        // Use more localized temporary directory
        $workingDir = Mage::getBaseDir('var') . DS . 'cache_warm' . DS;
        if (!is_dir($workingDir)) {
            mkdir($workingDir);
            chmod($workingDir, 0777);
        }
        $crawler->setWorkingDirectory($workingDir);


        $excludeConfig = Mage::getStoreConfig('lyonscg_improvedcache/warming/excludes', $store->getId());
        $patterns = explode("\n", $excludeConfig);
        foreach($patterns as $pattern) {
            $pattern = trim($pattern);
            if (!empty($pattern)) {
                $crawler->addURLFilterRule("#".$pattern."# i");
            }
        }

        // Set Timeouts for urls
        $crawler->setStreamTimeout(Mage::getStoreConfig('lyonscg_improvedcache/warming/request_timeout', $store->getId()));
        $crawler->setConnectionTimeout(Mage::getStoreConfig('lyonscg_improvedcache/warming/connect_timeout', $store->getId()));
    }

    /**
     * Run Multi-Process Crawler
     *
     * @param Lyonscg_ImprovedCache_Model_Warmer $crawler
     * @throws Exception
     */
    protected function _runCrawler(Lyonscg_ImprovedCache_Model_Warmer $crawler, $threads = 6)
    {
        // Start the crawl using multiple processes
        if ($threads == 1) {
            $crawler->go();
        } else {
            try {
                $crawler->goMultiProcessed($threads, PHPCrawlerMultiProcessModes::MPMODE_PARENT_EXECUTES_USERCODE);
            } catch (Exception $e) {
                $crawler->go();
            }
        }

        // Get a report of the crawl after it's done.
        // TODO: Do something with this report?
        $report = $crawler->getProcessReport();
    }

    /**
     * Log activity to common log.
     *
     * NOTE: Avoid doing any database queries here.
     *
     * @param $message
     */
    public function log($message)
    {
        if (!$this->_loggingEnabled) {
            return;
        }

        Mage::log($message, null, self::LOG_FILE);
    }
}