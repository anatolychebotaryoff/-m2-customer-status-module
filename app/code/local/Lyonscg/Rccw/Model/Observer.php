<?php
/**
 * RCCW cps, index, cache, crawler
 *
 * @category     Lyonscg
 * @package      Lyonscg_Rccw
 * @copyright    Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author       Ashutosh Potdar (apotdar@lyonscg.com)
 */
class Lyonscg_Rccw_Model_Observer
{
    /**
     * @var $log Varien_Io_File
     */
    protected static $log;

    /**
     * @var $totalTime int
     */
    protected static $totalTime;

    /**
     * run RCCW script without waiting for response
     */
    public static function run()
    {
        if ($pid = self::isRunning()) {
            Mage::getSingleton('adminhtml/session')->addError('Process is already running pid : ' . $pid);
            return;
        }

        self::runBackgroundProcess();
        $found = false;
        $attempts = 20;
        do {
            sleep(1);//wait for rccw.php
            $pidFiles = self::getPidFiles();
            if (empty($pidFiles)) {
                $attempts--;
            } else {
                $found = true;
            }
        } while ($attempts > 0 && !$found);

        if (empty($pidFiles)) {
            Mage::getSingleton('adminhtml/session')->addError('Can\'t run process');
            return;
        }

        if (count($pidFiles) == 1) {
            $pid = str_replace('-rccw.log', '', current($pidFiles));
            Mage::getSingleton('adminhtml/session')->addSuccess('Running process pid : ' . $pid);
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError('Something went wrong');
        Mage::getSingleton('adminhtml/session')->addError('RCCW detected multiple PID files:');
        foreach ($pidFiles as $pidFile) {
            $pid = str_replace('-rccw.log', '', $pidFile);
            Mage::getSingleton('adminhtml/session')->addError('PID : ' . $pid);
        }
    }

    /**
     * run script shell/lyons/rccw.php in background
     */
    protected static function runBackgroundProcess()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, str_replace('/index.php/', '/', Mage::getBaseUrl() . 'shell/lyonscg/rccw.php'));
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 1); // times out after 1s
        curl_setopt($ch, CURLOPT_POST, 1); // set POST method
        curl_exec($ch); // run the whole process
        curl_close($ch);
    }

    /**
     * run long process
     * if there is the already running process just do nothing
     */
    public static function runProc()
    {
        self::openLog();
        self::log('Process has started');
        self::$totalTime = 0;
        self::reindex();
        self::runcatalogrule();
        // Commenting out the following two functions
        // as these are issues with running these on multiple servers
        // Cache warmer works only on the same server due to the setup.
        // 
        //self::runMscc();
        //self::runwarmcache();
        self::log('Total execution time : ' . self::$totalTime);
        self::closeLog();
    }

    /**
     * run Catalogrule apply all.
     */

    protected static function runcatalogrule()
    {
        self::log('Started runcatalogrule');
        $time = microtime(true);
        try {
            $catalogrule = new Mage_CatalogRule_Model_Rule();
            $catalogrule->applyAll();
        } catch (Exception $e) {
            self::log('Error occured while executing runcatalogrule. Here is the error message: ' . $e->getMessage());
        }
        $time = microtime(true) - $time;
        self::$totalTime += $time;
        self::log('Ran runcatalogrule : ' . $time);
    }

    /**
     * run reindex everything
     */
    protected static function reindex()
    {
        self::log('Started Reindex All');
        $time = microtime(true);
        exec('php -f ' . Mage::getBaseDir() . '/shell/indexer.php -- reindexall', $output);
        foreach($output as $msg) {
            self::log($msg);
        }
        $time = microtime(true) - $time;
        self::$totalTime += $time;
        self::log('Ran Reindex All: ' . $time);
    }

    /*
     * run cache warmer
     */
    protected static function runwarmcache()
    {
        self::log('Kicking off Warm Cache on each server separately');
        try {
            $warmCacheFile = Mage::getBaseDir('etc') . DS . "lyonscg_warmcache.xml";
            $lyonscg_mscc_xml = simplexml_load_file($warmCacheFile);

            if (is_file($warmCacheFile) && $lyonscg_mscc_xml) {
                // convert xml to some key/value pairs
                $sshUser = (string) $lyonscg_mscc_xml->ssh->identity->username;
                $idpath = (string) $lyonscg_mscc_xml->ssh->identity->path;
                // Build the commands that needs to be executed.
                // We are assuming that there will be atleast one command.
                $commands = '';
                foreach ($lyonscg_mscc_xml->xpath("//ssh/commands/command") as $command) {
                    if ($commands) {
                        $commands .= ';';
                    }
                    $commands .= (string) $command;
                }
                $servers = array();
                foreach ($lyonscg_mscc_xml->xpath("//servers/server") as $dest) {
                    $servers[] = (string) $dest;
                }

                $ssh_command = "/usr/bin/ssh -l " . $sshUser . " -i " . $idpath;

                // Loop through the destination servers
                foreach ($servers as $destination) {
                    $this_command = $ssh_command . ' ' . $destination . ' ' . $commands;
                    $last_line = exec($this_command);
                    self::log("cmd=$this_command");
                }
            } else {
                self::log('Error occured while executing runwarmcache. ' . $warmCacheFile . ' was not found.');
            }
        } catch (Exception $e) {
            self::log('Error occured while executing runwarmcache. Here is the error message: ' . $e->getMessage());
        }
        self::log('Kicked off Warm Cache on each server separately');
    }

    /**
     * run MSCC multi server cache clear
     */
    protected static function runMscc()
    {
        self::log('Started Multi Server Cache Clear');
        $time = microtime(true);

        // Call the actual mscc function
        self::runCommandsMscc();

        $time = microtime(true) - $time;
        self::$totalTime += $time;
        self::log('Ran Multi Server Cache Clear: ' . $time);
    }

    /*
     *  This method executes the command, captures the output and logs it.
     *  it also logs any information necessary to help debug if there are
     *  any issues encountered.
     *
     */
    protected static function runCommandsMscc()
    {
        self::log('Started runCommandsMscc function');
        // Get config
        $config = self::getMsccConfig();
        if ($config) {
            // Setup success array to show all failures, mark success only on success.
            $origin = $config["servers"]["origin"];
            $successes = array();
            $successes[$origin] = 1;
            $command_list = $config["remote"];
            $id_path = $config["ssh"]["idpath"];
            $ssh_command = "/usr/bin/ssh -l " . $config["ssh"]["user"] . " -i " . $id_path;

            // First do the local command
            $this_command = $command_list . " 2>&1";
            unset($outarray);
            $last_line = exec($this_command, $outarray, $retval);
            self::log("cmd=$this_command, retval=$retval, output=" . implode('\r', $outarray));
            $successes[$origin] = $retval;
            // Next, loop through the destination servers
            foreach ($config["servers"]["destinations"] as $destination) {
                $successes[$destination] = 1;
                $this_command = $ssh_command . ' ' . $destination . ' ' . $command_list . " 2>&1";
                unset($outarray);
                $last_line = exec($this_command, $outarray, $retval);
                self::log("cmd=$this_command, retval=$retval, output=" . implode('\r', $outarray));
                $successes[$destination] = $retval;
            }

            // Collect all the servernames put them in appropriate bucket.
            $results = array("success" => array(), "fail" => array());
            foreach ($successes as $servername => $value) {
                if ((int) $value == 0)
                    $results["success"][] = $servername;
                else
                    $results["fail"][] = $servername;
            }

            $successes = '';
            $failures = '';
            $full_success = false;
            // Check if we have either success or failure or both.
            if (sizeof($results)) {
                if (sizeof($results["success"])) {
                    $successes = $this->__("Successful cache-clears");
                    $successCount = 0;
                    foreach ($results["success"] as $servername) {
                        if ($successCount++) {
                            $successes .= ', ';
                        }
                        $successes .= $servername;
                    }
                    $full_success = true;
                }
                if (sizeof($results["fail"])) {
                    $failures = $this->__("Failed cache-clears");
                    $failCount = 0;
                    foreach ($results["fail"] as $servername) {
                        if ($failCount++) {
                            $failures .= ', ';
                        }
                        $failures .= $servername;
                    }
                    $full_success = false;
                }
            }
            $message = 'Username: ' . $uu->getUsername() .
                    ' User ID: ' . $uu->getUser_id() .
                    ' Action: flush Success: ' . $full_success .
                    ' Result: ' . $successes . ' ' . $failures;
            self::log($message);
        } else {
            // Did not find lyonscg_mscc.xml file so run only the magento clear cache
            // on the local server.
            self::runClearCache();
        }
        self::log('Done runCommandsMscc function');
    }

    /*
    * get the lyons_mscc.xml file and settings to get the structure and configurable elements to this module
    */
    protected static function getMsccConfig()
    {
        try {
            if (is_file(Mage::getBaseDir('etc') . DS . "lyonscg_mscc.xml")) {
                if (!$lyonscg_mscc_xml = simplexml_load_file(Mage::getBaseDir('etc') . DS . "lyonscg_mscc.xml")) {
                    return false;
                };

                // convert xml to some key/value pairs
                $rs = array();
                $rs["ssh"]["user"] = (string) $lyonscg_mscc_xml->ssh->identity->username;
                $rs["ssh"]["idpath"] = (string) $lyonscg_mscc_xml->ssh->identity->path;
                // Build the commands that needs to be executed.
                // We are assuming that there will be atleast one command.
                $rs["remote"] = '';
                foreach ($lyonscg_mscc_xml->xpath("//ssh/remote/command") as $command) {
                    if ($rs["remote"]) {
                        $rs["remote"] .= ';';
                    }
                    $rs["remote"] .= (string) $command;
                }
                $rs["servers"]["origin"] = (string) $lyonscg_mscc_xml->servers->origin;
                $rs["servers"]["destinations"] = array();
                foreach ($lyonscg_mscc_xml->xpath("//servers/destinations/destination") as $dest) {
                    $rs["servers"]["destinations"][] = (string) $dest;
                }

                return $rs;
            } else {
                return false;
            }
        } catch(Exception $e) {
            return false;
        }
    }

    /**
     * Magento clear cache
     */
    protected static function runClearCache()
    {
        self::log('WARNING!!! - Config file missing or this is only a single server.  Started Magento Cache Clear');
        $time = microtime(true);
        Mage::app()->cleanCache();
        Enterprise_PageCache_Model_Cache::getCacheInstance()->clean(Enterprise_PageCache_Model_Processor::CACHE_TAG);
        Mage::app()->getCacheInstance()->flush();
        $time = microtime(true) - $time;
        self::log('Ran Magento Clear Cache : ' . $time);
    }

    /**
     * determine if there is a working process return false
     *
     * @return bool
     */
    protected static function openLog()
    {
        if (!self::$log) {
            self::$log = new Varien_Io_File();
            self::$log->cd(Mage::getBaseDir('log'));
        }
    }

    /**
     * write to custom log
     *
     * @param $str
     */
    public static function log($str)
    {
        if (self::$log) {
            self::$log->streamOpen(getmypid() . '-rccw.log', 'a+');
            self::$log->streamWrite($str . "\n");
            self::$log->streamClose();
        } else {
            Mage::log($str, null, 'rccw.log');
        }
    }

    /**
     * close opened resource
     */
    protected static function closeLog()
    {
        if (self::$log) {
            self::$log->checkAndCreateFolder('rccw');
            self::$log->mv(
                getmypid() . '-rccw.log',
                'rccw/' . Mage::app()->getLocale()->date()->toString('MMddyy-HHmmss') . '.log'
            );
        }
    }

    /**
     * scan log dir for pid files
     *
     * @return array
     */
    protected static function getPidFiles()
    {
        $pids = array();
        foreach(scandir(Mage::getBaseDir('var').'/log/') as $file) {
            if ($file != "." && $file != ".." && strpos($file, '-rccw.log') !== false) {
                $pids[] = $file;
            }
        }

        return $pids;
    }

    /**
     * determine is process already running
     * return pid if running false if not
     *
     * @return bool|mixed
     */
    protected static function isRunning()
    {
        $curDir = getcwd();
        @chdir(Mage::getBaseDir('var') . '/log/');
        Mage::log('searching for running processes', null, 'rccw.log');
        foreach (self::getPidFiles() as $pidFile) {
            $pid = str_replace('-rccw.log', '', $pidFile);
            Mage::log('pid ' . $pid, null, 'rccw.log');
            if (file_exists("/proc/$pid")) {
                Mage::log('Process is already running', null, 'rccw.log');
                @chdir($curDir);

                return $pid;
            } else {
                @chmod($pidFile, 0777);
                Mage::log('Process is not running, deleting then', null, 'rccw.log');
                @unlink($pidFile);
            }
        }

        @chdir($curDir);

        return false;
    }
}