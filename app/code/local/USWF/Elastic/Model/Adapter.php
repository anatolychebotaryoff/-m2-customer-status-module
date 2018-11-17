<?php

class USWF_Elastic_Model_Adapter extends Mage_Core_Model_Abstract
{

    const XML_PATH_ELASTICSEARCH_URL = 'uswf_elastic/general/url';

    public function save() {
        throw new Mage_Core_Exception("This model is abstract and should not be saved");
    }

    public function create( $dataType, $qs) {

        $id = $qs["entity_id"] . "-" . $qs["store_id"];

        if (!$dataType || !$id) {
            throw new Mage_Core_Exception("You must specify a dataType and ID to call a record create");
        }

        $url = array(
            Mage::getStoreConfig(self::XML_PATH_ELASTICSEARCH_URL),
            $dataType,
            $id);

        $url = implode('/', $url);

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($qs));

        return json_decode(curl_exec($ch));

    }

    public function bulk( $dataType, $qs) {

        $url = array(
            Mage::getStoreConfig(self::XML_PATH_ELASTICSEARCH_URL),
            $dataType,
            "_bulk" );

        $url = implode('/', $url);

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);

        return curl_exec($ch);

    }



    public function update( $dataType, $qs ) {

        $id = $qs["entity_id"] . "-" . $qs["store_id"];

        if (!$dataType || !$id) {
            throw new Mage_Core_Exception("You must specify a dataType and ID to call a record update");
        }

        $url = array(
            Mage::getStoreConfig(self::XML_PATH_ELASTICSEARCH_URL),
            $dataType,
            $id);

        $url = implode('/', $url);

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($qs));

        return json_encode(curl_exec($ch));

    }

    public function loadRecord( $dataType, $id ) {

        if (!$dataType || !$id) {
            throw new Mage_Core_Exception("You must specify a dataType and ID to call a record deletion");
        }

        $url = array(
            Mage::getStoreConfig(self::XML_PATH_ELASTICSEARCH_URL),
            $dataType,
            $id);

        $url = implode('/', $url);
        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        return json_decode(curl_exec($ch));

    }

    public function search( $dataType, $qs ) {

        if (!$dataType) {
            throw new Mage_Core_Exception("You must specify a dataType to call a search");
        }

        $url = array(
            Mage::getStoreConfig(self::XML_PATH_ELASTICSEARCH_URL),
            $dataType,
            '_search');

        $url = implode('/', $url);
        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);

        return json_decode(curl_exec($ch));
    }

    public function deleteRecord( $dataType, $id ) {

        if (!$dataType || !$id) {
            throw new Mage_Core_Exception("You must specify a dataType and ID to call a record deletion");
        }

        $url = array(
            Mage::getStoreConfig(self::XML_PATH_ELASTICSEARCH_URL),
            $dataType,
            $id);

        $url = implode('/', $url);

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        return json_decode(curl_exec($ch));

    }

    public function createType ( $dataType, $mapping ) {

        if (!$dataType || !$mapping) {
            throw new Mage_Core_Exception("You must specify a dataType and mapping to call record creation");
        }

        $url = array(
            Mage::getStoreConfig(self::XML_PATH_ELASTICSEARCH_URL),
            $dataType);

        $url = implode('/', $url);

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mapping));

        return json_decode(curl_exec($ch));

    }

}
