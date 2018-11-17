<?php


class USWF_AdminAlert_Model_Observer
{

    /**
     * Get details of save event and send email 
     *
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function onAdminSave($observer) {

        $collection = Mage::getModel('enterprise_logging/event')->getCollection();
        $collection->getSelect()->where("time > CURDATE() AND fullaction ='adminhtml_system_config_save'");

        $logEntry = $collection->getLastItem()->getData();

        $logUrl = Mage::helper("adminhtml")->getUrl('adminhtml/logging/details/event_id', array('event_id' => $logEntry["log_id"]));        

        mail('security@commercialwaterdistributing.com',
            'Alert: Magento Payment Configuration Changed',
            sprintf("Server: %s\nUser %s updated the payment configuration @ %s (GMT) \n\nMore information on this event can be seen here:\n%s", gethostname(), $logEntry["user"], $logEntry["time"], $logUrl )
        );
    }

}
