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

class Lyonscg_ImprovedCache_Model_Warmer extends PHPCrawler
{
    function handleDocumentInfo(PHPCrawlerDocumentInfo $DocInfo)
    {
        Mage::helper('lyonscg_improvedcache')
            ->log(
                '--Request: ' . $DocInfo->url .
                ' ' . ($DocInfo->http_status_code ? $DocInfo->http_status_code : '(timeout)') .
                ' ' . ($DocInfo->server_connect_time + $DocInfo->server_response_time)
            );
    }
}