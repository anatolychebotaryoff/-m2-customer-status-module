<?php
class Lyonscg_Mscc_Adminhtml_MyformController extends Mage_Adminhtml_Controller_Action {
    public function indexAction()     {
        $this->loadLayout()->renderLayout();
    }

    public function postAction() {
        $post = $this->getRequest()->getPost();
	$failCount = 0;
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }

            if (($post['form_key'] == Mage::getSingleton('core/session')->getFormKey()) && $post['validation'] && $post['validation'] == '1') {
            	$results = $this->do_commands();
            	$successes = '';
            	$failures = '';
            	$full_success = true;
            	if (sizeof($results)) {
            		if (sizeof($results["success"])) {
            			$successes = $this->__("Successful cache-clears");
            			$successCount = 0;
            			foreach ($results["success"] as $servername) {
            				if ($successCount++)
            					$successes .= ', ';
            				$successes .= $servername;
            			}
	            		Mage::getSingleton('adminhtml/session')->addSuccess($successes);
            		}
            		if (sizeof($results["fail"])) {
            			$failures = $this->__("Failed cache-clears");
            			foreach ($results["fail"] as $servername) {
            				if ($failCount++)
            					$failures .= ', ';
            				$failures .= $servername;
            			}
            			Mage::getSingleton('adminhtml/session')->addError($failures);
            			$full_success = false;
            		}
            	}
            	if ($successCount && $failCount)
            		$sep = "<br>";
            	else
            		$sep = "";
        		$uu = Mage::getSingleton('admin/session')->getUser();
            	$this->_logAdminAction($uu->getUsername(), $uu->getUser_id(), "flush", $full_success, $successes . $sep . $failures);
            } else {
            	$message = $this->__('Checkbox unchecked');
	            Mage::getSingleton('adminhtml/session')->addError($message);
			}
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
    }

    protected function _logAdminAction($username, $userId, $action, $success, $details) {
		$eventCode = 'lyonscg_mscc';

		return Mage::getSingleton('enterprise_logging/event')->setData(array(
			'ip' => Mage::helper('core/http')->getRemoteAddr(),
			'user' => $username,
			'user_id' => $userId,
			'is_success' => $success,
			'fullaction' => "adminhtml_cache_mscc",
			'actiongroup' => "Cache Management",
			'event_code' => $eventCode,
			'action' => $action,
			'info' =>$details,
		))->save();
	}

	/*
	 * get the lyonscg_mscc.xml file and settings to get the structure and configurable elements to this module
	 */
	protected function getConfig() {
		$lyonscg_mscc_xml = simplexml_load_file(Mage::getBaseDir('etc') . DS . "lyonscg_mscc.xml");
		// convert xml to some key/value pairs
		$rs = array();
		$rs["ssh"]["user"] = (string)$lyonscg_mscc_xml->ssh->identity->username;
		$rs["ssh"]["idpath"] = (string)$lyonscg_mscc_xml->ssh->identity->path;
		$rs["remote"]["command"] = (string)$lyonscg_mscc_xml->ssh->remote->command;
		$rs["servers"]["origin"] = (string)$lyonscg_mscc_xml->servers->origin;
		$rs["servers"]["destinations"] = array();
		foreach ($lyonscg_mscc_xml->xpath("//servers/destinations/destination") as $dest)
			$rs["servers"]["destinations"][] = (string)$dest;

		return $rs;
	}

	protected function do_commands() {
		// Get config
		$config = $this->getConfig();
		// Setup success array to show all failures, mark success only on success.
		$origin = $config["servers"]["origin"];
		$successes = array();
		$successes[$origin] = 1;
		$command = $config["remote"]["command"] . " " . Mage::getBaseDir('cache') . DS . "*";
		$id_path = $config["ssh"]["idpath"];
		$ssh_command = "/usr/bin/ssh -l " . $config["ssh"]["user"] . " -i " . $id_path;

	// First do the local command
		$this_command = $command . " 2>&1";
		unset($outarray);
		$last_line = exec($this_command, $outarray, $retval);
		Mage::log("cmd=$this_command, retval=$retval, output=" . implode('\r', $outarray), null, 'mscc.log');
		$successes[$origin] = $retval;
	// Next, loop through the destination servers
		foreach($config["servers"]["destinations"] as $destination) {
			$successes[$destination] = 1;
			$this_command = $ssh_command . ' ' . $destination . ' ' . $command . " 2>&1";
			unset($outarray);
			$last_line = exec($this_command, $outarray, $retval);
			Mage::log("cmd=$this_command, retval=$retval, output=" . implode('\r', $outarray), null, 'mscc.log');
			$successes[$destination] = $retval;
		}

		$results = array("success" => array(), "fail" => array());
		foreach($successes as $servername => $value) {
			if ((int)$value == 0)
				$results["success"][] = $servername;
			else
				$results["fail"][] = $servername;
		}
		return $results;
	}

}
?>
