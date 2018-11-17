<?php

class USWF_OneStepCheckout_Model_Customer_Address extends Mage_Customer_Model_Address {

    /**
     * set address street informa
     * fix duplicate
     * @param $street
     * @return unknown|void
     */
    public function setStreet($street){
        if (is_array($street)) {
            if (count($street) > 1 && ( $street[0] == $street[1])) {
                $street = $street[0];
            }
            $street = trim(implode("\n", $street));
        } elseif (is_string($street)) {
            $streetArr = explode("\n", $street);
            if (count($streetArr) > 1 && ( $streetArr[0] == $streetArr[1])) {
                $street = trim($streetArr[0]);
            }
        }
        $this->setData('street', $street);
    }

}