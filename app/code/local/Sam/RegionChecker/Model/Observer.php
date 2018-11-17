<?php


class Sam_RegionChecker_Model_Observer
{

    public function checkRegion($observer)
    {

        $order = $observer->getEvent()->getOrder();
        $regionId = $order->getShippingAddress()->getRegionId();

        if (empty($regionId)) {
            $regionId = $order->getBillingAddress()->getRegionId();
        }

        if ($regionId) {
          $result = Mage::helper('sam_regionchecker')->checkItems($regionId, $order->getAllItems());
        }

        if (isset($result['error'])) {
            foreach($result['message'] as $message) {

                //Mage::log($message , null, 'region_checker.log');
                //  Mage::getSingleton('adminhtml/session')->addWarning($message);
                Mage::throwException(Mage::helper('sales')->__($message));

            }
        }





    }

}
