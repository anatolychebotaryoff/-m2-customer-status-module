<?php

class Sam_CountdownBanner_Model_Observer
  extends Varien_Event_Observer
{

    public function customerLogin($observer)
    {
        $dt = new DateTime();
        $value = $dt->getTimestamp();
        $domain = Mage::getStoreConfig('web/cookie/cookie_domain');

        //Mage::getModel('core/cookie')->set('countdown_banner_start_time',
      //    $value, null, null, $domain);
      setcookie('countdown_banner_start_time', $value, time() + (86400 * 30), '/', 'discountfilterstore.com');
    }

}
