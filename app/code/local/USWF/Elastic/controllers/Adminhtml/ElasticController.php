<?php

class USWF_Elastic_Adminhtml_ElasticController extends Mage_Adminhtml_Controller_Action {

    public function searchAction() {

        $request = $this->getRequest();

        $dataType = $request->getPost('dataType');
        $query = $request->getPost('query');

        $adapter = Mage::getSingleton('uswf_elastic/adapter');

        $this->getResponse()->setBody( json_encode($adapter->search($dataType, $query)));

    }

    public function loadAction() {

        $request = $this->getRequest();

        $dataType = $request->getPost('dataType');
        $id = $request->getPost('id');

        $adapter = Mage::getSingleton('uswf_elastic/adapter');

        $this->getResponse()->setBody( json_encode( $adapter->loadRecord($dataType, $id)));

    }

    protected function _validateFormKey() {
        return true;
    }

}
