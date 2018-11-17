<?php

class USWF_BrontoTrack_Model_Observer {

    public function salesOrderPlaceAfter($observer) {

        $order = $observer->getEvent()->getOrder();
        $email = $order->getCustomerEmail();
        
        $store = $order->getStoreId();

        $redis = new Redis();

        $server = (string) Mage::getConfig()->getNode("global/cache/backend_options/server");
        $port = (int) Mage::getConfig()->getNode("global/cache/backend_options/port");
        $database = (int) Mage::getConfig()->getNode("global/cache/backend_options/database");

        $redis->pconnect($server, $port);
        $redis->select($database);

        $redis->rPush('brontoTrack', json_encode(array("store" => $store, "email" => $email)));

    }

}
