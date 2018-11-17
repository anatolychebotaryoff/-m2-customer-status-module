<?php
/**
 * This class resets the cutomergroup ids to their previous ids via cron job.
 *
 * @category   Lyonscg
 * @package    Lyonscg_HotDeal
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Ashutosh Potdar <apotdar@lyonscg.com>
 */

/**
 * Customer Group Reset
 *
 * @category    Lyonscg
 * @package     Lyonscg_HotDeal
 */
class Lyonscg_Hotdeal_Model_Customergroupreset extends Mage_Core_Model_Abstract
{
    /**
     * File name to capture error messages.
     * 
     * @var type
     */
    public $filename = 'customer_group_reset_debug';

    /**
     * This method extracts the group ids mapping from the admin panel, removes any
     * whitespaces (space, spaces, tabs etc) and ensures that there is a value.
     * if it is empty, nothing happens, otherwise it processes the request.
     *
     * @return void
     */
    public function customerGroupIdsReset()
    {
        $groupIds = $this->_getCustomerGroupMapping();
        // Make sure to remove all the spaces.
        $groupIds = preg_replace('/\s+/', '', $groupIds);
        if ($groupIds != '') {
            // split the string.  It is in csv format.
            $groupArray = explode(',', $groupIds);
            // Loop through each set of group ids and reset the values.
            foreach ($groupArray as $groupId) {
                $customerGroup = explode('=', $groupId);
                $this->_resetCustomerGroup($customerGroup[0], $customerGroup[1]);
            }
        }
    }

    /**
     * This function returns customer group ids in csv format entered in the admin
     * panel config.
     *
     * @return string
     */
    private function _getCustomerGroupMapping()
    {
        return Mage::getStoreConfig('web/hotdeals/customer_group_ids_to_reset',
                Mage::app()->getStore()->getStoreId());
    }

    /**
     * This method resets the customer group ids using from and to values.
     *
     * @param int $fromGroupId
     * @param int $toGroupId
     *
     * @return void
     */
    private function _resetCustomerGroup($fromGroupId = 0, $toGroupId = 0)
    {

        // Make sure that the group ids are greater than zero.
        if ($fromGroupId > 0 && $toGroupId > 0) {
            // Update each customer for the give $groupId.
            $customerModel = Mage::getModel('customer/customer')->getCollection();
            $customerModel->addAttributeToFilter('group_id', $fromGroupId);

            Mage::getSingleton('core/resource_iterator')->walk($customerModel->getSelect(), array(array($this, 'resetCallback')));

        }

    }

    public function resetCallback($args) {

        $customer = Mage::getModel('customer/customer');
        $customer->setData($args['row']);
        $customer->setCustomerGroupId(0);
        $customer->getResource()->saveAttribute($customer, 'customer_group_id');

    }

}
