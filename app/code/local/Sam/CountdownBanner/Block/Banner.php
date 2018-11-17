<?php
class Sam_CountdownBanner_Block_Banner extends Mage_Core_Block_Template {

    protected function addBannerData() {

        $customer_group_conf = Mage::getStoreConfig('sam_countdownbanner/general/customer_group');
        $customer_group_curr = Mage::getSingleton('customer/session')->getCustomerGroupId();

        if ($customer_group_conf == $customer_group_curr)
          return '<input type="hidden" id="show_countdown_banner" name="show_countdown_banner" value="true">';

        return '';

    }
}
