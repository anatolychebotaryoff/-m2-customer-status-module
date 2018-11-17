<?php
/**
 * Lyonscg_HotDealShoppingRule
 *
 * @category  Lyonscg
 * @package   Lyonscg_HotDealShoppingRule
 * @copyright Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author    Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Observer to add shopping rule condition
 *
 * @category Lyonscg
 * @package  Lyonscg_HotDealShoppingRule
 */
class Lyonscg_HotDealShoppingRule_Model_Observer
{
    /**
     * Add cookie condition config
     *
     * @param  Varien_Event_Observer $event
     * @return void
     */
    public function addCookieCondition(Varien_Event_Observer $observer)
    {

        $additional = $observer->getEvent()->getAdditional();
        $conditions = $additional->getConditions();
        $conditions[] = array(
            'value'=>'lyonscg_hotdealshoppingrule/rule_condition_cookie',
            'label'=>Mage::helper('lyonscg_hotdealshoppingrule')->__('Cookie Condition')
        );

        $additional->setConditions($conditions);

    }
}
